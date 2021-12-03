<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;
use Mail;
use DB;
use App\Models\Breakdown;
use App\Models\Equipment;
use App\Models\Station;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\State;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

       //   echo Auth::user()->level_id;

       // return view('Admin');

      
         if(Auth::user()->level_id==1)
        {
            return redirect()->action('AdminController@index');
        }

       
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
        ->orderBy( 'tickets.id','DESC')
        ->limit(10)
        ->get();
        $arr7['showteamleader'] = DB::table( 'users' )
        ->select( 'users.*')
        ->where('users.level_id',3)
        ->orderBy( 'users.name')
        ->get();
    
    
           return view('Dashboard')->with($arr)->with($arr2)->with($arr3)->with($arr4)->with($arr7);
    
            
          

          
        }
         if(Auth::user()->level_id==3)
        {
                 
            $arr['showdata'] = DB::table( 'tickets' )
        ->join( 'stations', 'stations.id', '=', 'tickets.station_id' )
        ->join( 'breakdowns', 'breakdowns.id', '=', 'tickets.breakdown_id' )
        ->join( 'equipment', 'equipment.id', '=', 'tickets.equipment_id' )
        ->select( 'tickets.*', 
            'stations.name_en as station_en', 'stations.name_ar as station_ar', 
            'equipment.name_en as equipment_en', 'equipment.name_ar as equipment_ar',
            'breakdowns.name_en as breakdown_en', 'breakdowns.name_ar as breakdown_ar')
        ->where('tickets.teamleader_id',Auth::user()->id)
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
    ->where('tickets.status_id',6)
    ->where('tickets.teamleader_id',Auth::user()->id)
    ->orderBy( 'tickets.id','DESC')
    ->limit(10)
    ->get();
    $arr7['showteamleader'] = DB::table( 'users' )
    ->select( 'users.*')
    ->where('users.level_id',3)
    ->orderBy( 'users.name')
    ->get();
  
       return view('Dashboard')->with($arr)->with($arr2)->with($arr3)->with($arr4)->with($arr7);

        }
         if(Auth::user()->level_id==4)
        { 
          //  return redirect()->action('DealerController@index');
      
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
       return view('Dashboard')->with($arr)->with($arr2)->with($arr3)->with($arr4);
    

        }
         if(Auth::user()->level_id==5)
        {
           
           // return redirect()->action('ClientController@index');
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

          return view('Dashboard')->with($arr)->with($arr2)->with($arr3)->with($arr4);
        }
       
    }
}
