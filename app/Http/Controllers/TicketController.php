<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Ticket;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\User;

use App\Exports\MaintenancesExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use Redirect;
use Exception;
use Log;

class TicketController extends Controller
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
    public function __construct(Request $request) {
        $this->slug = $this->getSlug($request);

        $this->createRoute = 'ticket.create';
        $this->viewRoute = 'ticket.show';
        $this->editRoute = 'ticket.edit';
        $this->deleteRoute = 'ticket.destroy';

        $this->datatableColumns = [
            'number' => [
                'title' => 'No.',
            ],
            'station.name' => [
                'title' => 'Station',
                'sortable' => true,
                'searchable' => true,
            ],
            'equipment.name_ar' => [
                'title' => 'Equipment',
                'sortable' => true,
                'searchable' => true,
            ],
            'breakdown.name_ar' => [
                'title' => 'Breakdown',
                'sortable' => true,
                'searchable' => true,
            ],
            'type.name_ar' => [
                'title' => 'Type',
                'sortable' => true,
                'searchable' => true,
            ],
            'openline.timestamp' => [
                'title' => 'Date',
                'type' => 'datetime',
                'sortable' => false,
                'searchable' => false,
            ],
            // 'openline.created_by.name' => [
            //     'title' => 'Created By',
            //     'sortable' => false,
            //     'searchable' => false,
            // ],
            // 'timeline.status.name' => [
            //     'title' => 'Status',
            //     'type' => 'badge',
            //     'sortable' => false,
            //     'searchable' => false,
            // ],
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
        $tickets = Ticket::with('station', 'equipment', 'breakdown', 'type', 'timeline.status', 'openline.created_by');
        return Inertia::render('Ticket/Index', [
            "type" => [],
        ])->table($tickets, function ($table) {
            $table->transform(function($item) {
                return $item;
            });

            $table->queryBuilder
            ->join('stations as station', 'station.id', 'tickets.station_id')
            ->join('equipment', 'equipment.id', 'tickets.equipment_id')
            ->join('ticket_types as type', 'type.id', 'tickets.type_id')
            ->join('breakdowns as breakdown', 'breakdown.id', 'tickets.breakdown_id')
            ->select('tickets.*');

            $table->defaultSort('number', 'desc');
            $table->actionButtons(false);

            // $table->createRoute($this->createRoute);
            $table->deleteRoute($this->deleteRoute);
            $table->editRoute($this->editRoute);
            $table->showRoute($this->viewRoute);
            $table->addColumns($this->datatableColumns);
            $table->addFilters([
                'station_id' => [
                    'title' => 'Station',
                    'type' => 'multiple_select',
                    'data' => Station::all()->pluck('name', 'id')->all(),
                ],
                'type_id' => [
                    'title' => 'Type',
                    'type' => 'multiple_select',
                    'data' => TicketType::all()->pluck('name', 'id')->all(),
                ],
                // 'created_by_id' => [
                //     'title' => 'Created By',
                //     'type' => 'multiple_select',
                //     'data' => User::all()->pluck('name', 'id')->all(),
                // ],
                'openBetween' => [
                    'title' => 'Open Between',
                    'type' => 'date_between',
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
            'forms.procedures.options');
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
            if($ticket) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        $process = $ticket->processes()->create($item);
                        if($process) {
                            foreach ($item['details'] as $detail) {
                                if($detail) {
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
    public function show(Request $request, Ticket $ticket)
    {
        $ticket->loadMissing(
            'station',
            'created_by',
            'processes',
            'processes.equipment',
            'processes.master_equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Ticket/View', [
            'ticket' => $ticket,
            'type' => $ticket->type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ticket $ticket)
    {

        if($this->slug != $ticket->type->slug)
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
            'forms.procedures.options');

        $ticket->loadMissing(
            'station',
            'processes',
            'processes.equipment',
            'processes.master_equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Ticket/Edit', [
            'type' => $type,
            'stations' => $stations,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {

        if($this->slug != $ticket->type->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        try {
            DB::beginTransaction();
            $data =  $request->all();

            $currentProcesses = [];
            $data['updated_by_id'] = Auth::id();
            if($ticket->update($data)) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        if(isset($item['id']) && $process = Process::find($item['id']))
                            $process->update($item);
                        else
                            $process = $ticket->processes()->create($item);

                        $currentProcesses[] = $process->id;
                        if($process) {
                            foreach ($item['details'] as $value) {
                                if($value) {
                                    if(isset($value['id']) && $detail = Detail::find($value['id']))
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
    public function destroy(Request $request, Ticket $ticket)
    {

        // $ticket = Ticket::find($request->id);

        if($this->slug != $ticket->type->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        $catName = $ticket->type->name;
        if($ticket && $ticket->delete()){
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
        $arr['details'] = Detail::whereHas('process', function($q) {
            $q->whereHas('ticket', function($q) {
                $q->whereHas('type', function($q) {
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
            'process.ticket.created_by');

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
