<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegionController extends Controller
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
        $all_regions = DB::table('regions')->get();
        return view('business-settings.regions', compact('all_regions'));
    }
    
    public function add_region(Request $req)
    {
        $user_id = Auth::user()->id;
        $region_name = $req->region_name;
        
        $new_tag = DB::table('regions')->insert([
            'region' => $region_name,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
            
        $region_id = DB::getPdo()->lastInsertId();
        if($region_id)
            return redirect('/region')->with('status', 'New Region Has Been Added Successfully!');
    }
    
    public function edit_region(Request $req)
    {
        $user_id = Auth::user()->id;
        $region_id = $req->region_id;
        $region_name = $req->region_name;
        
        $query = DB::table('regions')->where('id', $region_id)
                    ->update([
                        'region' => $region_name,
                        'updated_by' => $user_id,
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
        if($query)
            return redirect('/region')->with('status', 'Region Updated Successfully!');
    }
    
    public function delete_region(Request $req)
    {
        $region_id = $req->region_id_to_delete;
        $query = DB::table('regions')->where('id', $region_id)->delete();
        
        if($query)
            return redirect('/region')->with('status', 'Region Deleted Successfully!');
    }
}
