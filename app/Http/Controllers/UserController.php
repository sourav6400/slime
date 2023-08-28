<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        
        // $all_users = User::join('roles', 'users.role_id', '=', 'roles.id')->get();
        // $all_users = DB::table('users')->join('roles', 'users.role_id', '=', 'roles.id')->where(['created_by' => $user_id])->get();
        // $all_users = DB::table('users')->where(['created_by' => $user_id])->get();
        $all_users = DB::table('users')->where(['status' => 1])->get();
        // $all_roles = DB::table('roles')->where(['created_by' => $user_id])->get();
        $all_roles = DB::table('roles')->get();
        return view('user-list', compact('all_roles', 'all_users'));
    }
     
    public function add_new_user(Request $req)
    {
        // $name = $req->name;
        // $username = $req->username;
        // $email = $req->email;
        // $user_contact = $req->user_contact;
        // $role_id = $req->role_id;
        // $plan = $req->plan;
        
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
        ]);

        $data = $req->all();
        $check = $this->create($data);
        
        return redirect('/user-list')->with('status', 'New User Added Successfully!');
    }
    
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['user_contact'],
            'username' => $data['username'],
            'role_id' => $data['role_id'],
            'plan' => $data['plan'],
            'password' => Hash::make($data['username']),
            'created_by' => Auth::user()->id,
        ]);
    }
    
    public function approval_requests(){
        if(Auth::user()->role != 6)
            return redirect('/dashboard');
            
        $all_requests = DB::table('users')->where(['status' => 0])->get();
        $all_roles = DB::table('roles')->get();
        return view('all-requests', compact('all_requests', 'all_roles'));
    }
    
    public function edit_user(Request $req)
    {
        $userid = $req->userid;
        $name = $req->name;
        $email = $req->email;
        $user_contact = $req->user_contact;
        $role_id = $req->role_id;
        
        $query = User::where('id', $userid)->update([
            'name' => $name,
            'email' => $email,
            'contact' => $user_contact,
            'role' => $role_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        if($query)
            return redirect()->back()->with('status', 'One User Updated Successfully!');
    }
    
    public function delete_user(Request $req)
    {
        $user_id_to_delete = $req->user_id_to_delete;
        User::where('id', $user_id_to_delete)->delete();
        
        return redirect()->back()->with('error', 'One User has been deleted!');
    }
    
    public function approve(Request $req){
        $user_id = $req->user_id;
        $role = $req->role;
        
        // var_dump($user_id);
        // var_dump($role);
        
        if($role)
        {
            User::where('id', $user_id)->update([
                'role' => $role,
                'status' => 1
            ]);
            
            return redirect('/approval-requests')->with('status', 'One User Approved Successfully!');
        }
        
        else
            return redirect('/approval-requests')->with('error', 'Role can not be blank!');
    }
}
