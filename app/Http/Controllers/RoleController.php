<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $user_id = Auth::user()->id;
        // $all_roles = DB::table('roles')->where(['created_by' => $user_id])->get();
        $all_roles = DB::table('roles')->get();
        return view('roles', compact('all_roles'));
    }
     
    public function add_new_role(Request $req)
    {
        $client_read = $req->client_read;
        $client_write = $req->client_write;
        $client_create = $req->client_create;
        $influencer_read = $req->influencer_read;
        $influencer_write = $req->influencer_write;
        $influencer_create = $req->influencer_create;
        $campaign_read = $req->campaign_read;
        $campaign_write = $req->campaign_write;
        $campaign_create = $req->campaign_create;
        $payment_read = $req->payment_read;
        $payment_write = $req->payment_write;
        $payment_create = $req->payment_create;
        $user_read = $req->user_read;
        $user_write = $req->user_write;
        $user_create = $req->user_create;
        
        $role = $req->RoleName;
        $user_id = Auth::user()->id;
        // $role_search = DB::table('roles')->where(['role' => $role, 'created_by' => $user_id])->first();
        $role_search = DB::table('roles')->where(['role' => $role])->first();
        
        if($role_search == null){
            $new_role = DB::table('roles')->insert([
                'role' => $role,
                'created_by' => $user_id,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);
            $role_id = DB::getPdo()->lastInsertId();
            if($role_id){
                DB::table('client_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $client_read,
                    'edit' => $client_write,
                    'create' => $client_create
                ]);
                
                DB::table('influencer_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $influencer_read,
                    'edit' => $influencer_write,
                    'create' => $influencer_create
                ]);
                
                DB::table('campaign_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $campaign_read,
                    'edit' => $campaign_write,
                    'create' => $campaign_create
                ]);
                
                DB::table('payment_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $payment_read,
                    'edit' => $payment_write,
                    'create' => $payment_create
                ]);
                
                DB::table('user_management_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $user_read,
                    'edit' => $user_write,
                    'create' => $user_create
                ]);
            }
            return redirect('/roles')->with('status', 'New Role Added Successfully!');
        }
        
        else{
            return redirect('/roles')->with('error', 'This role already exists!');
        }
    }
    
    public function edit_role(Request $req)
    {
        $role_id = $req->role_id;
        $role_name = $req->role_name;
        
        $client_read = $req->client_read;
        $client_write = $req->client_write;
        $client_create = $req->client_create;
        
        $client_permission = DB::table('client_permission')->where(['role_id' => $role_id])->first();
        
        if($client_permission == null)
        {
            DB::table('client_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $client_read,
                    'edit' => $client_write,
                    'create' => $client_create
                ]);
        }
        else
        {
            DB::table('client_permission')->where('role_id', $role_id)
                ->update([
                    'view' => $client_read,
                    'edit' => $client_write,
                    'create' => $client_create
            ]);
        }
        
        $influencer_read = $req->influencer_read;
        $influencer_write = $req->influencer_write;
        $influencer_create = $req->influencer_create;
        
        $influencer_permission = DB::table('influencer_permission')->where(['role_id' => $role_id])->first();
        
        if($influencer_permission == null)
        {
            DB::table('influencer_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $influencer_read,
                    'edit' => $influencer_write,
                    'create' => $influencer_create
                ]);
        }
        else
        {
            DB::table('influencer_permission')->where('role_id', $role_id)
                ->update([
                    'view' => $influencer_read,
                    'edit' => $influencer_write,
                    'create' => $influencer_create
            ]);
        }
        
        $campaign_read = $req->campaign_read;
        $campaign_write = $req->campaign_write;
        $campaign_create = $req->campaign_create;
        
        $campaign_permission = DB::table('campaign_permission')->where(['role_id' => $role_id])->first();
        
        if($campaign_permission == null)
        {
            DB::table('campaign_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $campaign_read,
                    'edit' => $campaign_write,
                    'create' => $campaign_create
                ]);
        }
        else
        {
            DB::table('campaign_permission')->where('role_id', $role_id)
                ->update([
                    'view' => $campaign_read,
                    'edit' => $campaign_write,
                    'create' => $campaign_create
            ]);
        }
        
        $payment_read = $req->payment_read;
        $payment_write = $req->payment_write;
        $payment_create = $req->payment_create;
        
        $payment_permission = DB::table('payment_permission')->where(['role_id' => $role_id])->first();
        
        if($payment_permission == null)
        {
            DB::table('payment_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $payment_read,
                    'edit' => $payment_write,
                    'create' => $payment_create
                ]);
        }
        else
        {
            DB::table('payment_permission')->where('role_id', $role_id)
                ->update([
                    'view' => $payment_read,
                    'edit' => $payment_write,
                    'create' => $payment_create
            ]);
        }
        
        $user_read = $req->user_read;
        $user_write = $req->user_write;
        $user_create = $req->user_create;
        
        $user_management_permission = DB::table('user_management_permission')->where(['role_id' => $role_id])->first();
        
        if($user_management_permission == null)
        {
            DB::table('user_management_permission')->insert([
                    'role_id' => $role_id,
                    'view' => $user_read,
                    'edit' => $user_write,
                    'create' => $user_create
                ]);
        }
        else
        {
            DB::table('user_management_permission')->where('role_id', $role_id)
                ->update([
                    'view' => $user_read,
                    'edit' => $user_write,
                    'create' => $user_create
            ]);
        }
        
        return redirect()->back()->with('status', 'One Role Information Updated Successfully!');
    }
}
