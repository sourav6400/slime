<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContentController extends Controller
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
        $all_contents = DB::table('contents')->get();
        return view('business-settings.contents', compact('all_contents', 'all_socials'));
    }
    
    public function add_content(Request $req)
    {
        $user_id = Auth::user()->id;
        $content_name = $req->content_name;
        $short_name = $req->short_name;
        $social_id = $req->social_id;
        
        $new_content = DB::table('contents')->insert([
            'content_name' => $content_name,
            'short_name' => $short_name,
            'social_id' => $social_id,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
            
        $content_id = DB::getPdo()->lastInsertId();
        if($content_id)
            return redirect('/content')->with('status', 'New Content Has Been Added Successfully!');
    }
    
    public function edit_content(Request $req)
    {
        $user_id = Auth::user()->id;
        $content_id = $req->content_id;
        $content_name = $req->content_name;
        $short_name = $req->short_name;
        $social_id = $req->social_id;
        
        $query = DB::table('contents')->where('id', $content_id)
                    ->update([
                        'content_name' => $content_name,
                        'short_name' => $short_name,
                        'social_id' => $social_id,
                        'updated_by' => $user_id,
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
        if($query)
            return redirect('/content')->with('status', 'Content Updated Successfully!');
    }
    
    public function delete_content(Request $req)
    {
        $content_id = $req->content_id_to_delete;
        $query = DB::table('contents')->where('id', $content_id)->delete();
        DB::table('influencer_contents')->where('content_id', $content_id)->delete();
        DB::table('ifluencer_package_content')->where('content_id', $content_id)->delete();
        DB::table('ifluencer_template_content')->where('content_id', $content_id)->delete();
        DB::table('campaign_content_custom_price')->where('content_id', $content_id)->delete();
        
        if($query)
            return redirect('/content')->with('status', 'Content Deleted Successfully!');
    }
}
