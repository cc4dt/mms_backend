<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Models\User;
use App\Models\Hse;
use App\Models\HseProcess;
use App\Models\HseDetail;
use App\Models\Station;

use Redirect;

class HseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['hse' => 'HSE', 'station' => 'Station', 'serial' => 'Serial', 'created_by' => 'Created By', 'timestamp' => 'Created At'];

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

        $data = QueryBuilder::for(HseProcess::class)
            ->defaultSort('timestamp')
            ->allowedSorts(array_keys($columns))
            ->allowedFilters(array_merge(array_keys($columns), [
                $globalSearch,
                AllowedFilter::exact('hse_id'),
                AllowedFilter::exact('station_id'),
                AllowedFilter::exact('created_by_id'),
                
                // AllowedFilter::scope('createdBetween'),
            ]))
            ->paginate()
            ->withQueryString();

        $data->getCollection()->transform(function ($item) {
            return [
                'hse' => $item->hse->name,
                'station' => $item->station->name,
                'serial' => $item->equipment ? $item->equipment->serial : null,
                'created_by' => $item->created_by->name,
                'timestamp' => $item->timestamp,
            ];
        });

        return Inertia::render('Hse/Index', [
            'data' => $data,
        ])->table(function (InertiaTable $table) use($columns) {
            $table->addSearchRows($columns)
                ->addColumns($columns)
                ->addFilter('hse_id', 'HSE', Hse::all()->pluck('name', 'id')->all())
                ->addFilter('station_id', 'Station', Station::all()->pluck('name', 'id')->all())
                ->addFilter('created_by_id', 'Created By', User::all()->pluck('name', 'id')->all());
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hses = Hse::all();

        return Inertia::render('Hse/Create', [
            'hses' => Hse::all()->loadMissing('equipment', 'procedures', 'procedures.spare_part.sub_parts', 'procedures.options'),
            'stations' => Station::all('id', 'name_ar', 'name_en')->loadMissing('equipment'),
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
        $hse = Hse::find($form['hse']['id']);
        $process = $hse->processes()->create([
            'station_id' => $form['station']['id'],
            'equipment_id' => $form['equipment'] ? $form['equipment']['id'] : null,
            'timestamp' => $form['date'],
            'created_by_id' => Auth::id(),
            'updated_by_id' => Auth::id(),
        ]);
        foreach ($form['procedures'] as $key => $value) {
            if($value && $value['option']) {
                $process->details()->create([
                    'procedure_id' => $key,
                    'option_id' => $value['option']['id'],
                    'spare_sub_part_id' => $value['spare'] ? $value['spare']['id'] : null,
                    'value' => $value['val'],
                ]);
            } 
        }
        // HseProcess::create(
        //     // Request::validate([
        //     //     'first_name' => ['required', 'max:50'],
        //     //     'last_name' => ['required', 'max:50'],
        //     //     'email' => ['required', 'max:50', 'email'],
        //     // ])
        // );

        return Redirect::route('hse.index');
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