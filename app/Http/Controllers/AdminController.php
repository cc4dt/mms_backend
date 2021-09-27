<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketOpened;
use App\Breakdown;
use App\Equipment;
use App\Station;
use App\Company;
use App\Ticket;
use App\State;
use App\User;
use DB;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level_id==1)
        {
       $arr1['userdata'] = User::all();
       $arr2['statedata'] = State::all();
       $arr3['equipmentdata'] = Equipment::all();
      // print_r($arr1->all());
       return view('Admin')->with($arr1)->with($arr2)->with($arr3);
    }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        $request->validate( [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ] );
    
        $Row = new User();
        $Row->name = $request->name;
        $Row->email = $request->email;
        $Row->username = $request->username;
        $Row->password = Hash::make( $request->password );
        $Row->level_id = $request->level_id;
        $Row->company_id = 1;
        

        if ( $Row->save() ) {
            $request->session()->flash( 'result', 'Operation Compelete Successfully' );
            return back();
        }
        
        


    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        {
        $arr1['userdata'] = DB::table( 'users' )
              ->select( 'users.*')
        ->orderBy( 'id','DESC')
        ->get();
        $arr2['statedata'] = State::all();
        $arr3['equipmentdata'] = Equipment::all();
        $arr4['showupdate'] = DB::table( 'users' )
              ->select( 'users.*')
        ->where('id',$id)
          ->get();
        $tickets = DB::table('tickets')->find($id);
        $arr5['stationdata']=DB::table('stations')
        ->select( 'stations.*')
              ->get();
        $arr6['breakdowndata']=DB::table('breakdowns')
        ->select( 'breakdowns.*')
       
        ->get();
        $arr7['shownew'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
        ->join( 'equipment', 'equipment.id', '=', 'tickets.equipment_id' )
        ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'equipment.name_en as equipment_en', 'equipment.name_ar as equipment_ar',
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
        ->where('tickets.status_id',1)
        ->where('tickets.created_by_id',Auth::user()->id)
        ->orderBy( 'tickets.id','DESC')
        ->limit(10)
        ->get();


       return view('Admin')->with($arr1)->with($arr2)->with($arr3)->with($arr4)->with($arr5)->with($arr6)->with($arr7);
    }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate(
            [
            'id' => ['required', 'string'],
            'name' => ['required', 'string'],
                        ]
        );

        

    

        $Row = User::find( $request->id );
        $Row->id = $request->id;
        $Row->name = $request->name;
        $Row->level_id = $request->level_id;
        $Row->password = $request->password;
              if ( $Row->save() ) {
            $request->session()->flash( 'result', 'User Updated Successfully' );
             return back();


        }





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


       // print_r($request->id);
         $user=User::find($request->id);
        
       if($user->delete()){
           $request->session()->flash('result','User Deleted Successfully');
            return back();
        }
     
    }
}
