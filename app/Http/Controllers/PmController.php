<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\User;
use App\Models\Equipment;
use App\Models\Pm;
use App\Models\PmProcess;
use App\Models\PmDetail;
use App\Models\Station;

use Redirect;

class PmController extends Controller
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

        $data = QueryBuilder::for(Pm::class)
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
                'station' => $item->station->name,
                'created_by' => $item->created_by->name,
                'timestamp' => $item->timestamp,
            ];
        });

        // return Inertia::render('Pm/Index', [
        //     'data' => $data,
        // ])->table(function (InertiaTable $table) use($columns) {
        //     $table->addSearchRows($columns)
        //         ->addColumns($columns)
        //         ->addFilter('station_id', 'Station', Station::all()->pluck('name', 'id')->all())
        //         ->addFilter('created_by_id', 'Created By', User::all()->pluck('name', 'id')->all());
        // });
        
        $arr['pms'] = Pm::all();
        return view('pm')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipment = Equipment::all()->loadMissing(
                            'pm_procedures',
                            'pm_procedures.input_type',
                            'pm_procedures.spare_part.sub_parts',
                            'pm_procedures.options');
        $stations = Station::all('id', 'name')
                ->loadMissing('equipment');
        return Inertia::render('Pm/Create', [
            'stations' => $stations,
            'equipment' => $equipment,
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
        $form =  $request->all();
        // dd($form);
        $pm = Pm::create([
            'station_id' => $form['station']['id'],
            'timestamp' => $form['date'],
            'created_by_id' => Auth::id(),
            'updated_by_id' => Auth::id(),
        ]);
        if($pm) {
            foreach ($form['processes'] as $processKey => $processItem) {
                if ($processItem['equipment']) {
                    $process = $pm->processes()->create([
                        'equipment_id' => $processItem['equipment']['id'],
                        'master_equipment_id' => $processItem['master_equipment'] ? $processItem['equipment']['id'] : null,
                        'description' => $processItem['description'],
                    ]);
                    if($process) {
                        foreach ($processItem['procedures'] as $key => $value) {
                            if($value) {
                                $process->details()->create([
                                    'procedure_id' => $key,
                                    'option_id' => $value['option'] ? $value['option']['id'] : null,
                                    'spare_part_id' => $value['spare'] ? $value['spare']['id'] : null,
                                    'value' => $value['val'],
                                ]);
                            } 
                        }
                    }
                }
            }
        }
        // HseProcess::create(
        //     // Request::validate([
        //     //     'first_name' => ['required', 'max:50'],
        //     //     'last_name' => ['required', 'max:50'],
        //     //     'email' => ['required', 'max:50', 'email'],
        //     // ])
        // );

        return Redirect::route('pm.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
