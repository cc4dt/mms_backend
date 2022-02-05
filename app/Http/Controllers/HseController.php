<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\User;
use App\Models\Hse;
use App\Models\MasterHse;
use App\Models\HseProcess;
use App\Models\HseDetail;
use App\Models\Station;

use Redirect;
use Exception;

class HseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['station' => 'Station', 'created_by' => 'Created By', 'timestamp' => 'Created At'];

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) use($columns) {
            $query->where(function ($query) use ($value, $columns) {
                $q = $query;
                $f = true;
                foreach($columns as $key => $v) {
                    if($f) {
                        $f = false;
                        $q = $q->where($key, 'LIKE', "%{$value}%");
                    } else {
                        $q = $q->orWhere($key, 'LIKE', "%{$value}%");
                    }
                }
            });
        });

        $data = QueryBuilder::for(MasterHse::class)
            ->defaultSort('timestamp')
            ->allowedSorts(array_keys($columns))
            ->allowedFilters(array_merge(array_keys($columns), [
                $globalSearch,
                AllowedFilter::exact('station_id'),
                AllowedFilter::exact('created_by_id'),
                
                // AllowedFilter::scope('createdBetween'),
            ]))
            ->paginate()
            ->withQueryString();

        $data->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'station' => $item->station->name,
                'created_by' => $item->created_by->name,
                'timestamp' => $item->timestamp,
            ];
        });

        // return Inertia::render('Hse/Index', [
        //     'data' => $data,
        // ])->table(function (InertiaTable $table) use($columns) {
        //     $table->addSearchRows($columns)
        //         ->addColumns($columns)
        //         ->addFilter('station_id', 'Station', Station::all()->pluck('name', 'id')->all())
        //         ->addFilter('created_by_id', 'Created By', User::all()->pluck('name', 'id')->all());
        // });
        
        $arr['hses'] = MasterHse::all();
        return view('hse')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hses = Hse::all()->loadMissing(
                            'equipment',
                            'procedures',
                            'procedures.input_type',
                            'procedures.spare_part.sub_parts',
                            'procedures.options');
        $stations = Station::all('id', 'name_ar', 'name_en')
                ->loadMissing('equipment');
        return Inertia::render('Hse/Create', [
            'stations' => $stations,
            'hses' => $hses,
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
        // return redirect()->back()->withErrors([
        //    'create' => 'ups, there was an error'
        // ]);
        try {
            DB::beginTransaction();
            
            $form =  $request->all();
            $hse = MasterHse::create([
                'station_id' => $form['station']['id'],
                'timestamp' => $form['date'],
                'created_by_id' => Auth::id(),
                'updated_by_id' => Auth::id(),
            ]);
            if($hse) {
                foreach ($form['processes'] as $processItem) {
                    if ($processItem['hse']) {
                        $process = $hse->processes()->create([
                            'hse_id' => $processItem['hse']['id'],
                            'equipment_id' => $processItem['equipment'] ? $processItem['equipment']['id'] : null,
                            'description' => $processItem['description'],
                        ]);
                        if($process) {
                            foreach ($processItem['procedures'] as $key => $value) {
                                if($key && $value) {
                                    $process->details()->create([
                                        'procedure_id' => $key,
                                        'option_id' => $value['option'] ? $value['option']['id'] : null,
                                        'spare_part_id' => $value['spare'] ? $value['spare']['id'] : null,
                                        'value' => $value['val'],
                                    ]);
                                } else {
                                    throw new Exception("Error Processing Request", 1);
                                } 
                            }
                        } else {
                            throw new Exception("Error Processing Request", 1);
                        }
                    } else {
                        throw new Exception("Error Processing Request", 1);
                    }
                }
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('hse.index');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withErrors([
               'create' => 'ups, there was an error'
            ]);
        }
        // HseProcess::create(
        //     // Request::validate([
        //     //     'first_name' => ['required', 'max:50'],
        //     //     'last_name' => ['required', 'max:50'],
        //     //     'email' => ['required', 'max:50', 'email'],
        //     // ])
        // );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterHse  $masterHse
     * @return \Illuminate\Http\Response
     */
    public function show(MasterHse $hse)
    {
        $hse->loadMissing(
            'station',
            'created_by',
            'processes',
            'processes.hse',
            'processes.equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Hse/View', [
            'hse' => $hse,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterHse  $masterHse
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterHse $hse)
    {
        $hses = Hse::all()->loadMissing(
                            'equipment',
                            'procedures',
                            'procedures.input_type',
                            'procedures.spare_part.sub_parts',
                            'procedures.options');

        $stations = Station::all('id', 'name_ar', 'name_en')
                ->loadMissing('equipment');
                
        $hse->loadMissing(
            'station',
            'processes',
            'processes.hse',
            'processes.equipment',
            'processes.details',
            'processes.details.procedure',
            'processes.details.spare_part',
            'processes.details.option');
        return Inertia::render('Hse/Edit', [
            'stations' => $stations,
            'hses' => $hses,
            'hse' => $hse,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterHse  $masterHse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterHse $masterHse)
    {
        try {
            DB::beginTransaction();
            $form =  $request->all();
            if(!$id = $form['id'])
                throw new Exception("Error Processing Request", 1);
            $masterHse = MasterHse::find($id);
            $hse = $masterHse->update([
                'station_id' => $form['station']['id'],
                'timestamp' => $form['date'],
                'updated_by_id' => Auth::id(),
            ]);
            if($hse) {
                foreach ($form['processes'] as $processItem) {
                    if ($processItem['hse']) {
                        $data = [
                            'hse_id' => $processItem['hse']['id'],
                            'equipment_id' => isset($processItem['equipment']) ? $processItem['equipment']['id'] : null,
                            'description' => $processItem['description'],
                        ];
                        if($process = HseProcess::find($processItem['id']))
                            $process->update($data);
                        else
                            $process = $masterHse->processes()->create($data);
                        if($process) {
                            foreach ($processItem['procedures'] as $key => $value) {
                                if($key && $value) {
                                    $data = [
                                        'procedure_id' => $key,
                                        'option_id' => isset($value['option']) ? $value['option']['id'] : null,
                                        'spare_part_id' => isset($value['spare']) ? $value['spare']['id'] : null,
                                        'value' =>  isset($value['val']) ? $value['val'] : null,
                                    ];
                                    if(isset($value['id']) && $detail = HseDetail::find($value['id']))
                                        $detail->update($data);
                                    else
                                        $detail = $process->details()->create($data);
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
            } else {
                throw new Exception("Error Processing Request", 1);
            }
            DB::commit();
            return Redirect::route('hse.show', [$id]);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->back()->withErrors([
               'update' => 'ups, there was an error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterHse  $masterHse
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request)
    {

        $hse = MasterHse::find($request->id);
        
        if($hse && $hse->delete()){
            $request->session()->flash('result','HSE Deleted Successfully');
            return back();
        }
    }
}
