<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;
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

         // echo Auth::user()->level;

       // return view('Admin');

      
      
        if(Auth::user()->level==1)
        {
            return view('Admin');
        }
         if(Auth::user()->level==2)
        {
            return view('Supervisor');
        }
         if(Auth::user()->level==3)
        {
            return view('Teamleader');
        }
         if(Auth::user()->level==5)
        {
            return view('Client');
        }
       
    }
}
