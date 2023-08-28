<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TagController extends Controller
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
        $all_tags = DB::table('tags')->get();
        return view('business-settings.tags', compact('all_tags'));
    }
    
    public function add_tag(Request $req)
    {
        $user_id = Auth::user()->id;
        $tag_name = $req->tag_name;
        
        $new_tag = DB::table('tags')->insert([
            'tag' => $tag_name,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
            
        $tag_id = DB::getPdo()->lastInsertId();
        if($tag_id)
            return redirect('/tag')->with('status', 'New Tag Added Successfully!');
    }
    
    public function edit_tag(Request $req)
    {
        $user_id = Auth::user()->id;
        $tag_id = $req->tag_id;
        $tag_name = $req->tag_name;
        
        $query = DB::table('tags')->where('id', $tag_id)
                    ->update([
                        'tag' => $tag_name,
                        'updated_by' => $user_id,
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
        if($query)
            return redirect('/tag')->with('status', 'Tag Updated Successfully!');
    }
    
    public function delete_tag(Request $req)
    {
        $tag_id = $req->tag_id_to_delete;
        $query = DB::table('tags')->where('id', $tag_id)->delete();
        
        if($query)
            return redirect('/tag')->with('status', 'Tag Deleted Successfully!');
    }
}
