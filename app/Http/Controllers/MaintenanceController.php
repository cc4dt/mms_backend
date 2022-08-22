<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MaintenanceForm;
use App\Models\Maintenance;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\Process;
use App\Models\Detail;
use App\Models\User;

use App\Exports\MaintenancesExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use Redirect;
use Exception;

class MaintenanceController extends Controller
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

        $this->createRoute = 'maintenance.' . $this->slug . '.create';
        $this->viewRoute = 'maintenance.' . $this->slug . '.show';
        $this->editRoute = 'maintenance.' . $this->slug . '.edit';
        $this->deleteRoute = 'maintenance.' . $this->slug . '.destroy';

        $this->datatableColumns = [
            'station.name' => [
                'title' => 'Station',
                'sortable' => true,
                'searchable' => true,
            ],
            'created_by.name' => [
                'title' => 'Created By',
                'sortable' => true,
                'searchable' => true,
            ],
            'date' => [
                'title' => 'Date',
                'type' => 'date',
            ],
        ];
    }
    
    public function export() 
    {
        $category = Category::where('slug', '=', $this->slug)->first();
        return Excel::download(new MaintenancesExport($this->slug), $this->slug . '.xlsx');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::where('slug', '=', $this->slug)->first();
        $maintenances = $category->maintenances()->with('station', 'created_by');

        return Inertia::render('Maintenance/Index', [
            "category" => $category,
        ])->table($maintenances, function ($table) {
            $table->transform(function($item) {
                return $item;
            });
            
            $table->queryBuilder
            ->join('stations as station', 'station.id', 'maintenances.station_id')
            ->join('users as created_by', 'created_by.id', 'maintenances.created_by_id')
            ->select('maintenances.*', 'station.name as station_name', 'created_by.name as created_by_name');

            $table->defaultSort('date', 'desc');
            $table->createRoute($this->createRoute);
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
                'created_by_id' => [
                    'title' => 'Created By',
                    'type' => 'multiple_select',
                    'data' => User::all()->pluck('name', 'id')->all(),
                ],
                'createdBetween' => [
                    'title' => 'Created Between',
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

        $category = Category::where('slug', '=', $this->slug)->first()->loadMissing(
            'forms',
            'forms.equipment',
            'forms.procedures',
            'forms.procedures.input_type',
            'forms.procedures.spare_part.sub_parts',
            'forms.procedures.options');
        return Inertia::render('Maintenance/Create', [
            'category' => $category,
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

            $maintenance = Maintenance::create($data);
            if($maintenance) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        $process = $maintenance->processes()->create($item);
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
            return Redirect::route('maintenance.' . $this->slug . '.index');
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
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Maintenance $maintenance)
    {
        

        if($this->slug != $maintenance->category->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);

        $maintenance->loadMissing(
            'station',
            'created_by',
            'processes',
            'processes.equipment',
            'processes.master_equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Maintenance/View', [
            'maintenance' => $maintenance,
            'category' => $maintenance->category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Maintenance $maintenance)
    {
        
        if($this->slug != $maintenance->category->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);

        $stations = Station::all('id', 'name')
                ->loadMissing('equipment');

        $category = Category::where('slug', '=', $this->slug)->first()->loadMissing(
            'forms',
            'forms.equipment',
            'forms.procedures',
            'forms.procedures.input_type',
            'forms.procedures.spare_part.sub_parts',
            'forms.procedures.options');

        $maintenance->loadMissing(
            'station',
            'processes',
            'processes.equipment',
            'processes.master_equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Maintenance/Edit', [
            'category' => $category,
            'stations' => $stations,
            'maintenance' => $maintenance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        
        if($this->slug != $maintenance->category->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        try {
            DB::beginTransaction();
            $data =  $request->all();
            
            $currentProcesses = [];
            $data['updated_by_id'] = Auth::id();
            if($maintenance->update($data)) {
                foreach ($data['processes'] as $item) {
                    if (isset($item['equipment_id'])) {
                        if(isset($item['id']) && $process = Process::find($item['id']))
                            $process->update($item);
                        else
                            $process = $maintenance->processes()->create($item);
                        
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
                $maintenance->processes()->whereNotIn('id', $currentProcesses)->delete();
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('maintenance.' . $this->slug . '.show', [$maintenance->id]);
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
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Maintenance $maintenance)
    {
        
        // $maintenance = Maintenance::find($request->id);

        if($this->slug != $maintenance->category->slug)
            return redirect()->back()->withErrors([
                'url' => 'ups, there was an error'
            ]);
        $catName = $maintenance->category->name;
        if($maintenance && $maintenance->delete()){
            $request->session()->flash('result', $catName . ' Deleted Successfully');
            return back();
        }
    }
    
    public function report()
    {
        $cat = Category::where('slug', $this->slug)->first();
        $arr['stations'] = Station::all('id', 'name');
        $arr['hse'] = $cat->equipment;
        $arr['title'] = $cat->name;
        $arr['details'] = Detail::whereHas('process', function($q) {
            $q->whereHas('maintenance', function($q) {
                $q->whereHas('category', function($q) {
                    $q->where('slug', $this->slug);
                });
            });
        })->get()->loadMissing(
            'procedure',
            'spare_part',
            'option',
            'process',
            'process.equipment',
            'process.master_equipment',
            'process.maintenance',
            'process.maintenance.station',
            'process.maintenance.created_by');

        return view('hse-procedures-report')->with($arr);
    }

    
    public function maintenance_needs()
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
        
        foreach (Station::all() as $station) {
            $rows[] = (object) [
                'id' => $station->id,
                'name' => $station->name,
                'items' => [],
                'total' => 0,
            ];
        }

        $replacedHse = Detail::whereHas('option',  function ($query) {
            $query->replaces();
        });

        // $replacedHse = Detail::where('id', '<>', '0');
        
        // dump($replacedHse->count());
        // dd(Category::where('slug', 'hse')->get());
        foreach (Category::where('slug', $this->slug)->first()->forms as $form) {
            $procedures = [];
            $procedure_count = 0;
            if($form->procedures()->replaces()->count()) {
                foreach ($form->procedures()->replaces()->get() as $procedure) {
                    $spares = [];
                    $spares_count = 1;
                    $sub_price = 0;
                    if($procedure->spare_part && $procedure->spare_part->sub_parts->count() > 0) {
                        foreach ($procedure->spare_part->sub_parts as $spare) {
                            
                            $total_items = (clone $replacedHse)->where('spare_part_id', $spare->id)->get();
                            
                            // dump([
                            //     "spare" => $spare->name,
                            //     "count" => $total_items->count(),
                            //     "query" => $total_items->toSql(),
                            // ]);
                            $subSum = 0;
                            foreach ($rows as $key => $row) {
                                $items = $total_items->filter(function($item) use($row) {
                                    return $item->process->maintenance->station_id == $row->id;
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
                            $items = $total_items->filter(function($item) use($row) {
                                return $item->process->maintenance->station_id == $row->id;
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
                    'name' => $form->equipment->name,
                    'count' => $procedure_count
                ];
            }
        }

        foreach ($rows as $key => $row) {
            $rows[$key]->total = number_format($rows[$key]->total);
        }
        $arr = [
            'columns' => (object) $columns,
            'rows' => $rows,
            'sumRow' => $sumRow,
            'priceRow' => $priceRow,
            'totalRow' => $totalRow,
        ];
        return view('maintenance-needs-report')->with($arr);
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
