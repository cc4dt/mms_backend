<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MaintenanceForm;
use App\Models\Maintenance;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\Process;
use App\Models\Detail;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Redirect;
use Exception;
use DataTables;

class MaintenanceController extends Controller
{
    
    private $slug;
    /**
     * Datatable Columns Array
     *
     * @var Array
     */
    private $datatableColumns;

    /**
     * Datatable Headers Array
     *
     * @var Array
     */
    private $datatableHeaders;

    /**
     * Datatables Data URL
     *
     * @var String
     */
    private $datatableUrl;

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
        
        $this->datatableHeaders = [
            'Station',
            'Created By',
            'Date',
            '',
        ];

        $this->datatableColumns = [
            ['title' => 'Station', 'data' => 'station.name'],
            ['title' => 'Created By', 'data' => 'created_by'],
            ['title' => 'Date', 'data' => 'date'],
        ];

        $this->datatableUrl = route('maintenance.' . $this->slug . '.datatables');

        $this->createRoute = 'maintenance.' . $this->slug . '.create';
        $this->viewRoute = 'maintenance.' . $this->slug . '.show';
        $this->editRoute = 'maintenance.' . $this->slug . '.edit';
        $this->deleteRoute = 'maintenance.' . $this->slug . '.destroy';
    }
    
    public function datatables() {
        
        $category = Category::where('slug', '=', $this->slug)->first();
        
        $maintenances = $category->maintenances();
        return Datatables::of($maintenances)
            ->addColumn('station.name', fn($maintenance) => $maintenance->station->name)
            ->addColumn('created_by', fn($maintenance) => $maintenance->created_by->name)
            // ->addColumn('action', function ($maintenance) use($category) {
            //     $editRoute = route('maintenance.' . $category->slug . '.edit', $maintenance->id);                
            //     $deleteRoute = route('maintenance.' . $category->slug . '.destroy', $maintenance->id);

            //     return '<a href="'. $editRoute . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            // })
            // ->editColumn('id', 'ID: {{$id}}')
            // ->removeColumn('password')
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Maintenance/Index', [
            'datatableUrl' => $this->datatableUrl,
            'createRoute' => $this->createRoute,
            'viewRoute' => $this->viewRoute,
            'editRoute' => $this->editRoute,
            'deleteRoute' => $this->deleteRoute,
            'datatableColumns' => $this->datatableColumns,
            'datatableHeaders' => $this->datatableHeaders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        

        $stations = Station::all('id', 'name_ar', 'name_en')
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

        $stations = Station::all('id', 'name_ar', 'name_en')
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
