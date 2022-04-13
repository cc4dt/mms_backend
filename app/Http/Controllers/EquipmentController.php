<?php

namespace App\Http\Controllers;

use App\Models\MasterEquipment;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\User;

use App\Exports\MaintenancesExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf;

use Redirect;
use Exception;

class EquipmentController extends Controller
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

        $this->createRoute = 'master.create';
        $this->viewRoute = 'master.show';
        $this->editRoute = 'master.edit';
        $this->deleteRoute = 'master.destroy';

        $this->datatableColumns = [
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
            'serial' => [
                'title' => 'Serial',
            ],
        ];
    }
    
    public function export() 
    {
        // return Excel::download(new MaintenancesExport($this->slug), $this->slug . '.xlsx');
    }

    public function exportQrcode()
    {
        $data = [
            'equipment' => MasterEquipment::whereNotNull('serial')->orWhere('serial', '<>', '')->with('station','equipment')->get(),
        ];
        $pdf = SnappyPdf::loadView('reports.qrcode', $data);
        return $pdf->setPaper('a4')->inline();
        // return view('reports.qrcode', $data);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Master/Index')
        ->table(MasterEquipment::with('station', 'equipment'), function ($table) {
            $table->transform(function($item) {
                return $item;
            });
            
            $table->queryBuilder
                ->join('stations as station', 'station.id', 'master_equipment.station_id')
                ->join('equipment', 'equipment.id', 'master_equipment.equipment_id')
                ->select('master_equipment.*');

            $table->defaultSort('station.name');
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
                'equipment_id' => [
                    'title' => 'equipment',
                    'type' => 'multiple_select',
                    'data' => Equipment::all()->pluck('name', 'id')->all(),
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

        $equipment = Equipment::all()->loadMissing(
            'attributes',
            'attributes.options',
        );
        return Inertia::render('Master/Create', [
            'equipment' => $equipment,
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

            $master = MasterEquipment::create($data);
            if($master) {
                foreach ($data['details'] as $item) {
                    $detail = $master->details()->create($item);
                }
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('master.index');
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
     * @param  \App\Models\MasterEquipment  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MasterEquipment $master)
    {
        $master->loadMissing(
            'station',
            'equipment',
            'details',
            'details.attribute',);
        return Inertia::render('Master/View', [
            'master' => $master,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterEquipment  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MasterEquipment $master)
    {
        $stations = Station::all('id', 'name')
                ->loadMissing('equipment');

        $equipment = Equipment::all()->loadMissing(
            'attributes',
            'attributes.options',
        );
        return Inertia::render('Master/Edit', [
            'equipment' => $equipment,
            'stations' => $stations,
            'master' => $master->loadMissing('details'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterEquipment  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterEquipment $master)
    {
        try {
            DB::beginTransaction();
            $data =  $request->all();
            
            if($master->update($data)) {
                $currentDetails = [];
                foreach ($data['details'] as $item) {
                    $currentDetails[] = $item['attribute_id'];
                    if($item) {
                        if($detail = $master->details()->where('attribute_id', $item['attribute_id'])->first())
                            $detail->update($item);
                        else
                            $detail = $master->details()->create($item);
                    } else {
                        throw new Exception("Error Processing Request", 4);
                    } 
                }
                $master->details()->whereNotIn('attribute_id', $currentDetails)->delete();
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('master.show', [$master->id]);
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
     * @param  \App\Models\MasterEquipment  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MasterEquipment $master)
    {
        dd($master);
        if($request->id)
            $master = MasterEquipment::find($request->id);

        if($master && $master->delete()){
            $request->session()->flash('result', 'Equipment Deleted Successfully');
            return back();
        }
    }
    
    public function report()
    {
        // $cat = MasterEquipmentType::where('key', $this->slug)->first();
        // $arr['stations'] = Station::all('id', 'name');
        // $arr['hse'] = $cat->equipment;
        // $arr['title'] = $cat->name;
        // $arr['details'] = Detail::whereHas('process', function($q) {
        //     $q->whereHas('masterEquipment', function($q) {
        //         $q->whereHas('type', function($q) {
        //             $q->where('key', $this->slug);
        //         });
        //     });
        // })->get()->loadMissing(
        //     'procedure',
        //     'spare_part',
        //     'option',
        //     'process',
        //     'process.equipment',
        //     'process.master_equipment',
        //     'process.masterEquipment',
        //     'process.masterEquipment.station',
        //     'process.masterEquipment.created_by');

        // return view('hse-procedures-report')->with($arr);
    }
}
