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
use App\Notifications\TicketOpened2;
use App\Models\Breakdown;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\Company;
use App\Models\Ticket;
use App\State;
use App\Models\User;
use App\Models\MaintenanceDetail;
use App\Models\MaintenanceProcedure;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\SparePart;
use DB;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level_id==2)
        {     
        $arr['showdata'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
               ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
              ->orderBy( 'tickets.id','DESC')
        ->get();
      $arr2['statedata'] = State::all();
      $arr3['equipmentdata'] = Equipment::all();
  
 //print_r($arr);


       return view('Supervisor')->with($arr)->with($arr2)->with($arr3);

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
            'id' => ['required', 'string'],
            'number' => ['required', 'string'],
            ]
        );
       print_r($request->all());

    /* 
    $res=Ticket::assign([
    'id'=>$request->id,
    'number'=>$request->number,
    'station_id'=>$request->station_id,
    'breakdown_id'=>$request->breakdown_id,
    'equipment_id'=>$request->equipment_id,
    'state_id'=>$request->state_id,
    'open_description'=>$request->open_description,
    'type'=>$request->type,
    'trade'=>$request->trade,
    'priority'=>$request->priority,
    'teamleader_id'=>$request->teamleader_id]
     );

     print_r($res);
   // $request->session()->flash('result','Ticket Assign Successfully');

     // return back();
        
      */  

    
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
        if(Auth::user()->level_id==2)
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
        $arr7['showteamleader'] = DB::table( 'users' )
        ->select( 'users.*')
        ->where('users.level_id',3)
        ->orderBy( 'users.name')
        ->get();
        return view('Supervisor')->with($arr)->with($arr2)->with($arr3)->with($arr4)->with($arr5)->with($arr6)->with($arr7);
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
        $Row->updated_by_id = $request->updated_by_id;
        $Row->updated_at = $request->updated_at;
        $Row->equipment_id = $request->equipment_id;
        $Row->state_id = $request->state_id;
        $Row->status_id = 6;
        $Row->trade_id = $request->trade;
        $Row->type_id = $request->type;
        $Row->priority_id = $request->priority;
        $Row->teamleader_id = $request->teamleader_id;
        $Row->work_description = $request->work_description;
       if ( $Row->save() ) {
            $request->session()->flash( 'result', 'Ticket Assined Successfully' );
             return back();


        }

      /*  Ticket::assign([
            'id'=>$request->id,
            'state_id'=>$request->state_id,
            'number'=>$request->number,
            'station_id'=>$request->station_id,
            'breakdown_id'=>$request->breakdown_id,
            'open_description' => $request->open_description,
            'equipment_id'=>$request->equipment_id,
            'state_id'=>$request->state_id,
            'updated_at'=>$request->updated_at,  
            'trade_id'=>$request->trade_id,
            'type_id'=>$request->type_id,
            'priority_id'=>$request->priority_id,
            'teamleader_id'=>$request->teamleader_id]);

            $request->session()->flash( 'result', 'Ticket Assined Successfully' );
            return back();
            */

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
    
    public function breakdown()
    {
        // whereHas('status', function($q) {
        //     $q->where("key", "closed");
        //  })->get()
        $arr['tickets'] = Ticket::onType('breakdown')->orderBy('id','DESC')->get()->loadMissing(
            "equipment",
            "breakdown",
            "station",
            "timeline",
            "timeline.status",
            "created_by",
            "type",
        );
        $arr['stations'] = Station::all('id', 'name_ar', 'name_en');
        $arr['equipment'] = Equipment::all('id', 'name_ar', 'name_en');
        $arr['status'] = TicketStatus::all('id', 'name_ar', 'name_en');
        $arr['breakdowns'] = Breakdown::all('id', 'name_ar', 'name_en', 'equipment_id');
        
        return view('breakdown-report')->with($arr);
    }
    
    public function maintenance()
    {
        $arr['maintenance_details'] = MaintenanceDetail::whereHas('procedure', function($q) {
            $q->where("type_id", MaintenanceProcedure::getTypeId("replace"));
         })->get()
         ->loadMissing(
            "spare_sub_part",
            "procedure", 
            "procedure.spare_part",
            "process.equipment",
            "process.timeline.status",
            "process.ticket.equipment",
            "process.ticket.station",
            "process.ticket.type",
            "process.ticket.teamleader",
        );
        
        $arr['stations'] = Station::all();
        $arr['equipment'] = Equipment::all('id', 'name_ar', 'name_en');
        $arr['types'] = TicketType::all('id', 'name_ar', 'name_en');
        $arr['spareparts'] = SparePart::all('id', 'name_ar', 'name_en');
        return view('maintenance-report')->with($arr);
    }
    
    public function procedures()
    {
        $procedures = [];
        
        $maintenanceProcedure = MaintenanceProcedure::where("type_id", MaintenanceProcedure::getTypeId("replace"));
        foreach ($maintenanceProcedure as $procedure) {
            $procedureDetails = MaintenanceDetail::where('procedure_id', $procedure->id);
            
            if ($procedure->spare_part->sub_parts) {
                foreach ($procedure->spare_part->sub_parts as $sub_part) {
                    $row = [
                        $sub_part->name,

                    ];
                }
            } else {
                $row = [
                    $procedure->spare_part ? $procedure->spare_part->name : $procedure->name,
                    $procedureDetails->where()->count
                ];
            }
            $procedures[] = $row;
        }
        $arr['procedures'] = MaintenanceDetail::whereHas('procedure', function($q) {
            $q->where("type_id", MaintenanceProcedure::getTypeId("replace"));
         })->get()
         ->loadMissing(
            "spare_sub_part",
            "procedure", 
            "procedure.spare_part",
            "process.equipment",
            "process.ticket.equipment",
            "process.ticket.station",
            "process.ticket.type",
            "process.ticket.teamleader",
        );
        
        $arr['stations'] = Station::all();
        $arr['equipment'] = Equipment::all('id', 'name_ar', 'name_en');
        $arr['types'] = TicketType::all('id', 'name_ar', 'name_en');
        $arr['spareparts'] = SparePart::all('id', 'name_ar', 'name_en');
        return view('maintenance-report')->with($arr);
    }
    
    public function pm()
    {
        $obj = [];
        try {
            $json = file_get_contents('https://ham.sd/system/pms.php');
            $obj = json_decode($json);
        } catch (\Throwable $th) {
            $arr['errors'][] = "Server Error No Data";
        }
        
        if($obj) {
            $arr['equipment'] = $obj->equipment ?? [];
            $arr['stations'] = $obj->stations ?? [];
            $arr['pms'] = $obj->data ?? [];
        } else {
            $arr['equipment'] =  [];
            $arr['stations'] = [];
            $arr['pms'] = [];
        }
        return view('pm-report')->with($arr);
    }
    
    public function pm_fireexting()
    {
        $obj = [];
        try {
            $json = file_get_contents('https://ham.sd/system/api/fireexting.php');
            $obj = json_decode($json);
        } catch (\Throwable $th) {
            $arr['errors'][] = "Server Error No Data";
        }
        
        if($obj) {
            $arr['stations'] = $obj->stations ?? [];
            $arr['fires'] = $obj->data ?? [];
        } else {
            $arr['stations'] = [];
            $arr['fires'] = [];
        }
        return view('pm-fireexting-report')->with($arr);
    }
    
}
