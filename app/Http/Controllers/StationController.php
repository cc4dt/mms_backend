<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\User;

use App\Exports\MaintenancesExport;
use App\Models\Breakdown;
use App\Models\Category;
use App\Models\Detail;
use App\Models\MaintenanceForm;
use App\Models\MaintenanceProcedure;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use Redirect;
use Exception;
use Log;

class StationController extends Controller
{

    private $slug;
    /**
     * Datatable Columns Array
     *
     * @var Array
     */
    private $datatableColumns;

    private $createRoute;
    private $viewRoute;
    private $editRoute;
    private $deleteRoute;

    /**
     * Controller constructor
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->slug = $this->getSlug($request);

        $this->createRoute = 'station.create';
        $this->viewRoute = 'station.show';
        $this->editRoute = 'station.edit';
        $this->deleteRoute = 'station.destroy';

        $this->datatableColumns = [

            'id' => [
                'title' => '#',
                'sortable' => true,
                'searchable' => true,
            ],
            'name' => [
                'title' => 'Name',
            ],
            'state.name_ar' => [
                'title' => 'State',
                'sortable' => true,
                'searchable' => true,
            ],
        ];
    }

    public function export()
    {
        $type = TicketType::where('key', '=', $this->slug)->first();
        return Excel::download(new MaintenancesExport($this->slug), $this->slug . '.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $type = TicketType::where('key', '=', $this->slug)->first();
        $stations = Station::with('state');
        return Inertia::render('Station/Index', [])->table($stations, function ($table) {
            $table->transform(function ($item) {
                return $item;
            });

            $table->queryBuilder
                ->join('states as state', 'state.id', 'stations.state_id')
                ->select('stations.*');

            $table->defaultSort('id');
            // $table->actionButtons(false);

            // $table->createRoute($this->createRoute);
            // $table->deleteRoute($this->deleteRoute);
            // $table->editRoute($this->editRoute);
            $table->showRoute($this->viewRoute);
            $table->addColumns($this->datatableColumns);
            $table->addFilters([
                'state_id' => [
                    'title' => 'State',
                    'type' => 'multiple_select',
                    'data' => State::all()->pluck('name', 'id')->all(),
                ],
            ]);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $stations = Station::all('id', 'name')
            ->loadMissing('equipment');

        $type = TicketType::where('key', '=', $this->slug)->first()->loadMissing(
            'forms',
            'forms.equipment',
            'forms.procedures',
            'forms.procedures.input_type',
            'forms.procedures.spare_part.sub_parts',
            'forms.procedures.options'
        );
        return Inertia::render('Ticket/Create', [
            'type' => $type,
            'stations' => $stations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data =  $request->all();

            $data['created_by_id'] = Auth::id();
            $data['updated_by_id'] = Auth::id();

            $ticket = Ticket::create($data);
            if ($ticket) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        $process = $ticket->processes()->create($item);
                        if ($process) {
                            foreach ($item['details'] as $detail) {
                                if ($detail) {
                                    $process->details()->create($detail);
                                } else {
                                    throw new Exception("Error Processing Request", 3);
                                }
                            }
                        } else {
                            throw new Exception("Error Processing Request", 3);
                        }
                    } else {
                        throw new Exception("Error Processing Request", 2);
                    }
                }
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('ticket.' . $this->slug . '.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect()->back()->withErrors([
                'create' => 'ups, there was an error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Station $station)
    {
        $station->loadMissing(
            'state',
        );

        $replaced = Detail::whereHas('option',  function ($query) {
            $query->replaces();
        });

        $total = (clone $replaced)->whereHas('process',  function ($query) use ($station) {
            $query->whereHas('maintenance',  function ($query) use ($station) {
                $query->where('station_id', $station->id);
            });
        })->count();

        $categs = Category::all()->map(function ($item, $key) use ($replaced, $station) {
            $count = (clone $replaced)->whereHas('process',  function ($query) use ($item, $station) {
                $query->whereHas('maintenance',  function ($query) use ($item, $station) {
                    $query->where('category_id', $item->id)->where('station_id', $station->id);
                });
            })->count();
            return [$item->name => $count];
        });
        // dump($this->maintenance_needs($station));
        return Inertia::render('Station/View', [
            'station' => $station,
            'tickets' => $station->tickets()->orderByDesc('updated_at')->take(10)
                ->with('station', 'type', 'timeline.status', 'openline.created_by', 'breakdown')->get(),
            'equipment' => $station->equipment()->with('equipment')->get(),
            'needs' => $this->maintenance_needs($station),
            'ticketsCount' => $station->tickets()->count(),
            "ticketStatusCounts" => TicketStatus::all()
                ->transform(function ($item) use($station) {
                    $count = $station->tickets()->onStatus($item->key)->count();
                    return [
                        'key' => $item->name,
                        'data' => $count,
                        'percent' => $count / $station->tickets()->count() * 100,
                    ];
                }),
                
            "breakdownCounts" => Breakdown::all()
            ->transform(function ($item) use($station) {
                return [
                    'key' => $item->name,
                    // ->onType('breakdown')
                    'data' => $item->tickets()->where('station_id', $station->id)->count()
                ];
            }),
        ]);
    }


    public function maintenance_needs($station)
    {
        $columns = (object) [
            'maintenances' => [],
            'procedures' => [],
            'spares' => [],
        ];
        $rows = [];
        $sumRow = [];
        $totalRow = [];
        $priceRow = [];

        foreach (Category::all() as $categ) {
            $rows[] = (object) [
                'id' => $categ->id,
                'name' => $categ->name,
                'items' => [],
                'total' => 0,
            ];
        }

        $replacedHse = Detail::whereHas('option',  function ($query) {
            $query->replaces();
        })->whereHas('process',  function ($query) use ($station) {
            $query->whereHas('maintenance',  function ($query) use ($station) {
                $query->where('station_id', $station->id);
            });
        });

        // $replacedHse = Detail::where('id', '<>', '0');

        // dump($replacedHse->count());
        // dd(Category::where('slug', 'hse')->get());
        foreach (Equipment::whereHas('forms')->get() as $form) {
            // $procedures = [];
            $procedure_count = 0;
            $procedures = MaintenanceProcedure::whereHas('forms', function ($q) use ($form) {
                $q->whereHas('equipment', function ($q) use ($form) {
                    $q->where('id', $form->id);
                });
            })->replaces();
            if ($procedures->count()) {
                foreach ($procedures->get() as $procedure) {
                    $spares = [];
                    $spares_count = 1;
                    $sub_price = 0;
                    if ($procedure->spare_part && $procedure->spare_part->sub_parts->count() > 0) {
                        foreach ($procedure->spare_part->sub_parts as $spare) {

                            $total_items = (clone $replacedHse)->where('spare_part_id', $spare->id)->get();

                            // dump([
                            //     "spare" => $spare->name,
                            //     "count" => $total_items->count(),
                            //     "query" => $total_items->toSql(),
                            // ]);
                            $subSum = 0;
                            foreach ($rows as $key => $row) {
                                $items = $total_items->filter(function ($item) use ($row) {
                                    return $item->process->maintenance->category_id == $row->id;
                                })->count();
                                $rows[$key]->total += $spare->price * $items;
                                $rows[$key]->items[] = $items;
                                $subSum += $items;
                            }

                            $spares_count = $procedure->spare_part->sub_parts->count();
                            $columns->spares[] = (object) [
                                'name' => $spare->name
                            ];
                            $sumRow[] = $subSum;
                            $priceRow[] = $spare->price;
                            $totalRow[] = $subSum * $spare->price;
                        }
                    } else {
                        $total_items = ((clone $replacedHse))->where('procedure_id', $procedure->id)->get();
                        $subSum = 0;
                        foreach ($rows as $key => $row) {
                            $items = $total_items->filter(function ($item) use ($row) {
                                return $item->process->maintenance->category_id == $row->id;
                            })->count();
                            $rows[$key]->items[] = $items;
                            $rows[$key]->total += $procedure->price * $items;
                            $subSum += $items;
                        }
                        $sumRow[] = $subSum;
                        $priceRow[] = $procedure->price;
                        $totalRow[] = $subSum * $procedure->price;
                    }

                    $procedure_count += $spares_count;

                    $columns->procedures[] = (object) [
                        'name' => $procedure->name,
                        'count' => $spares_count
                    ];
                }

                $columns->maintenances[] = (object) [
                    'name' => $form->name,
                    'count' => $procedure_count
                ];
            }
        }

        foreach ($rows as $key => $row) {
            $rows[$key]->total = $rows[$key]->total;
        }
        $arr = [
            'columns' => (object) $columns,
            'rows' => $rows,
            'sumRow' => $sumRow,
            'priceRow' => $priceRow,
            'totalRow' => $totalRow,
        ];
        return $arr;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Station  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $ticket)
    {

        if ($this->slug != $ticket->type->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);

        $stations = Station::all('id', 'name')
            ->loadMissing('equipment');

        $type = TicketType::where('key', '=', $this->slug)->first()->loadMissing(
            'forms',
            'forms.equipment',
            'forms.procedures',
            'forms.procedures.input_type',
            'forms.procedures.spare_part.sub_parts',
            'forms.procedures.options'
        );

        $ticket->loadMissing(
            'station',
            'processes',
            'processes.equipment',
            'processes.master_equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option'
        );
        return Inertia::render('Station/Edit', [
            'type' => $type,
            'stations' => $stations,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Station  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Station $ticket)
    {

        if ($this->slug != $ticket->type->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        try {
            DB::beginTransaction();
            $data =  $request->all();

            $currentProcesses = [];
            $data['updated_by_id'] = Auth::id();
            if ($ticket->update($data)) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        if (isset($item['id']) && $process = Process::find($item['id']))
                            $process->update($item);
                        else
                            $process = $ticket->processes()->create($item);

                        $currentProcesses[] = $process->id;
                        if ($process) {
                            foreach ($item['details'] as $value) {
                                if ($value) {
                                    if (isset($value['id']) && $detail = Detail::find($value['id']))
                                        $detail->update($value);
                                    else
                                        $detail = $process->details()->create($value);
                                } else {
                                    throw new Exception("Error Processing Request", 4);
                                }
                            }
                        } else {
                            throw new Exception("Error Processing Request", 3);
                        }
                    } else {
                        throw new Exception("Error Processing Request", 2);
                    }
                }
                $ticket->processes()->whereNotIn('id', $currentProcesses)->delete();
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('ticket.' . $this->slug . '.show', [$ticket->id]);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect()->back()->withErrors([
                'update' => 'ups, there was an error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Station $ticket)
    {

        // $ticket = Ticket::find($request->id);

        if ($this->slug != $ticket->type->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        $catName = $ticket->type->name;
        if ($ticket && $ticket->delete()) {
            $request->session()->flash('result', $catName . ' Deleted Successfully');
            return back();
        }
    }

    public function report()
    {
        $cat = TicketType::where('key', $this->slug)->first();
        $arr['stations'] = Station::all('id', 'name');
        $arr['hse'] = $cat->equipment;
        $arr['title'] = $cat->name;
        $arr['details'] = Detail::whereHas('process', function ($q) {
            $q->whereHas('ticket', function ($q) {
                $q->whereHas('type', function ($q) {
                    $q->where('key', $this->slug);
                });
            });
        })->get()->loadMissing(
            'procedure',
            'spare_part',
            'option',
            'process',
            'process.equipment',
            'process.master_equipment',
            'process.ticket',
            'process.ticket.station',
            'process.ticket.created_by'
        );

        return view('hse-procedures-report')->with($arr);
    }

    public function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $this->slug = $this->slug;
        } else {
            $this->slug = explode('.', $request->route()->getName())[1];
        }

        return $this->slug;
    }
}
