<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['name' => 'Name', 'email' => 'Email address', 'created_at' => 'Created At'];

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

        $users = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedSorts(array_keys($columns))
            ->allowedFilters(array_merge(array_keys($columns), [
                $globalSearch,
                AllowedFilter::exact('current_team_id'),
                AllowedFilter::scope('createdBetween'),
            ]))
            ->paginate()
            ->withQueryString();

        $users->getCollection()->transform(function ($item) {
            $item->var = "Test";
            return $item;
        });

        return Inertia::render('Users/Index', [
            'data' => $users,
        ])->table(function (InertiaTable $table) use($columns) {
            $table->addSearchRows($columns)
                ->addColumns($columns)
                ->addFilter('current_team_id', 'Team', Team::all()->pluck('name', 'id')->all());
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'levels' => User::levels(),
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'level' => ['required', 'string'],
        ]);
        
        $form =  $request->all();
        // dd($request->all());
        $def = "12345678";
        User::create([
            'name' => $form['name'],
            'email' => $form['email'],
            'level' => $form['level'],
            'company_id' => 1,
            'password' => Hash::make($def),
        ]);
        
        return Redirect::route('users.index');
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
