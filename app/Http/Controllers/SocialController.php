<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
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
        $all_socials = DB::table('socials')->get();
        return view('business-settings.socials', compact('all_socials'));
    }
    
    public function add_social(Request $req)
    {
        $user_id = Auth::user()->id;
        $social_name = $req->social_name;
        
        $new_social = DB::table('socials')->insert([
            'social' => $social_name,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
            
        $social_id = DB::getPdo()->lastInsertId();
        if($social_id)
            return redirect('/social')->with('status', 'New Social Has Been Added Successfully!');
    }
    
    public function edit_social(Request $req)
    {
        $user_id = Auth::user()->id;
        $social_id = $req->social_id;
        $social_name = $req->social_name;
        
        $query = DB::table('socials')->where('id', $social_id)
                    ->update([
                        'social' => $social_name,
                        'updated_by' => $user_id,
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
        if($query)
            return redirect('/social')->with('status', 'Social Updated Successfully!');
    }
    
    public function delete_social(Request $req)
    {
        $social_id = $req->social_id_to_delete;
        $query = DB::table('socials')->where('id', $social_id)->delete();
        
        if($query)
            return redirect('/social')->with('status', 'Social Deleted Successfully!');
    }
}
