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


class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level_id==4)
        {
        $arr['showdata'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
        ->join( 'equipment', 'equipment.id', '=', 'tickets.equipment_id' )
        ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'equipment.name_en as equipment_en', 'equipment.name_ar as equipment_ar',
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
        ->where('tickets.created_by_id',Auth::user()->id)
        ->orderBy( 'tickets.id','DESC')
        ->get();
       $arr2['statedata'] = State::all();
       $arr3['equipmentdata'] = Equipment::all();
       $arr4['shownew'] = DB::table( 'tickets' )
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
       return view('Client')->with($arr)->with($arr2)->with($arr3)->with($arr4);
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
       

        $request->validate(
            [
            'state_id' => ['required', 'string'],
            'station_id' => ['required', 'string'],
            'equipment_id'=> ['required', 'string'],
            'breakdown_id'=> ['required', 'string'],
            'open_description'=> ['required', 'string'],
            ]
        );
    Ticket::open([
    'station_id'=>$request->station_id,
    'breakdown_id'=>$request->breakdown_id,
    'equipment_id'=>$request->equipment_id,
    'state_id'=>$request->state_id,
    'open_description'=>$request->open_description]
     );
    $request->session()->flash('result','Tickets Create Successfully');

      return back();
        
        


    
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
        if(Auth::user()->level_id==4)
        {
        $arr['showdata'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
        ->join( 'equipment', 'equipment.id', '=', 'tickets.equipment_id' )
        ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'equipment.name_en as equipment_en', 'equipment.name_ar as equipment_ar',
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
        ->where('tickets.created_by_id',Auth::user()->id)
        ->orderBy( 'tickets.id','DESC')
        ->get();
        $arr2['statedata'] = State::all();
        $arr3['equipmentdata'] = Equipment::all();
        $arr4['showupdate'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
        ->join( 'equipment', 'equipment.id', '=', 'tickets.equipment_id' )
        ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'equipment.name_en as equipment_en', 'equipment.name_ar as equipment_ar',
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
        ->where('tickets.id',$id)
        ->orderBy( 'tickets.id','DESC')
        ->get();
        $tickets = DB::table('tickets')->find($id);
        $arr5['stationdata']=DB::table('stations')
        ->select( 'stations.*')
        ->where('state_id',$tickets->state_id)
        ->get();
        $arr6['breakdowndata']=DB::table('breakdowns')
        ->select( 'breakdowns.*')
        ->where('equipment_id',$tickets->equipment_id)
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
        return view('Client')->with($arr)->with($arr2)->with($arr3)->with($arr4)->with($arr5)->with($arr6)->with($arr7);
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
            'state_id' => ['required', 'string'],
            'station_id' => ['required', 'string'],
            'equipment_id'=> ['required', 'string'],
            'breakdown_id'=> ['required', 'string'],
            'open_description'=> ['required', 'string'],
            ]
        );

        

    

        $Row = Ticket::find( $request->id );
        $Row->id = $request->id;
        $Row->number = $request->number;
        $Row->station_id = $request->station_id;
        $Row->breakdown_id = $request->breakdown_id;
        $Row->open_description = $request->open_description;
        $Row->status_id = $request->status_id;
        $Row->updated_by_id = $request->updated_by_id;
        $Row->updated_at = $request->updated_at;
        $Row->equipment_id = $request->equipment_id;
        $Row->state_id = $request->state_id;
        if ( $Row->save() ) {
            $request->session()->flash( 'result', 'Ticket Updated Successfully' );
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
         $user=Ticket::find($request->id);
        
       if($user->delete()){
           $request->session()->flash('result','Ticket Deleted Successfully');
            return back();
        }
     
    }
}
