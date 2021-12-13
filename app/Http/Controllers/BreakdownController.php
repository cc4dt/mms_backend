<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Equipment;
use App\Models\Breakdown;
use App\Models\State;
use App\Models\Company;
use App\Models\Station;
use App\Models\Ticket;
use App\Models\User;
use DB;


class BreakdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['showdata'] = Ticket::onType('breakdown')->orderBy('id','DESC')->get();
        $arr['shownew'] = Ticket::onType('breakdown')->onStatus('open')->orderBy('id','DESC')->limit(10)->get();
        $arr['statedata'] = State::all();
        $arr['equipmentdata'] = Equipment::all();
        $arr['showteamleader'] = User::teamleaders()->orderBy('name')->get();
       return view('breakdown')->with($arr);
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
        $arr['ticket'] = Ticket::find($id);
        return view('ticket')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arr['showdata'] = Ticket::onType('breakdown')->where('created_by_id', Auth::user()->id)->orderBy('id','DESC')->get();
        $arr['statedata'] = State::all();
        $arr['equipmentdata'] = Equipment::all();
        $arr['showupdate'] = Ticket::find($id);
        $tickets = Ticket::find($id);
        $arr['stationdata']= Station::where('state_id',$tickets->state_id)->get();
        $arr['breakdowndata']=Breakdown::where('equipment_id',$tickets->equipment_id)->get();
        $arr['shownew'] = Ticket::onType('breakdown')->onStatus('open')
        ->where('created_by_id', Auth::user()->id)
        ->orderBy('id','DESC')
        ->limit(10)
        ->get();
        return view('breakdown')->with($arr);
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
    $ticket = Ticket::find($request->id);
    
    if($ticket && $ticket->delete()){
        $request->session()->flash('result','Ticket Deleted Successfully');
        return back();
    }
     
    }
}
