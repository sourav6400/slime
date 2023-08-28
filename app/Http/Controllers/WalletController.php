<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletController extends Controller
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
        $all_wallets = DB::table('wallets')->get();
        return view('business-settings.wallet', compact('all_wallets'));
    }
    
    public function add_wallet(Request $req)
    {
        $user_id = Auth::user()->id;
        $wallet_type = $req->wallet_type;
        
        $new_wallet = DB::table('wallets')->insert([
            'wallet_type' => $wallet_type,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
            
        $wallet_id = DB::getPdo()->lastInsertId();
        if($wallet_id)
            return redirect('/wallet')->with('status', 'New Wallet Added Successfully!');
    }
    
    public function edit_wallet(Request $req)
    {
        $user_id = Auth::user()->id;
        $wallet_id = $req->wallet_id;
        $wallet_type = $req->wallet_type;
        
        $query = DB::table('wallets')->where('id', $wallet_id)
                    ->update([
                        'wallet_type' => $wallet_type,
                        'updated_by' => $user_id,
                        'updated_at' => now()->format('Y-m-d H:i:s')
                    ]);
        if($query)
            return redirect('/wallet')->with('status', 'Wallet Updated Successfully!');
    }
    
    public function delete_wallet(Request $req)
    {
        $wallet_id = $req->wallet_id_to_delete;
        $query = DB::table('wallets')->where('id', $wallet_id)->delete();
        
        if($query)
            return redirect('/wallet')->with('status', 'Wallet Deleted Successfully!');
    }
}
