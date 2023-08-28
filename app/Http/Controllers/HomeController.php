<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
        $user_status = Auth::user()->status;
        if($user_status == 0){
            Session::flush();
            Auth::logout();
            return redirect('/')->with('error', 'Please wait for approval!');;
        }
        else
        {
            if(Auth::user()->role == 'Client'){
                $client_id = DB::table('clients')->where('user_id', Auth::user()->id)->first()->id;
                $ongoingCampaigns = DB::table('campaigns')->where('client_id', $client_id)->where('status', 'Ongoing')->get();
            }else{
                $ongoingCampaigns = DB::table('campaigns')->where('status', 'Ongoing')->get();
            }
            return view('dashboard', compact('ongoingCampaigns'));
        }
    }
}
