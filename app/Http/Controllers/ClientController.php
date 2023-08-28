<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
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
     
    public function add_new_client_view()
    {
        $all_tags = DB::table('tags')->get();
        return view('client.add-new-client', compact('all_tags'));
    }
    
    public function add_new_client(Request $req)
    {
        $username = $req->username;
        $name = $req->name;
        $password = $req->password;
        $confirm_password = $req->confirm_password;
        if($password == $confirm_password)
        {
            $email = $req->email;
            $company_name = $req->company_name;
            $address = $req->address;
            $telegram = $req->telegram;
            $vat = $req->vat;
            $tags = $req->tags;
            $note = $req->note;
            
            $user = DB::table('users')->insert([
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'role' => 'Client',
                'password' => Hash::make($password),
                'status' => 1,
                'created_by' => Auth::user()->id,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);
            $user_id = DB::getPdo()->lastInsertId();
    
            $new_client = DB::table('clients')->insert([
                'user_id' => $user_id,
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'comany_name' => $company_name,
                'address' => $address,
                'telegram' => $telegram,
                'vat_no' =>  $vat,
                'note' => $note,
                'created_by' => Auth::user()->id,
                'created_at' => now()->format('Y-m-d H:i:s')
            ]);
            
            $client_id = DB::getPdo()->lastInsertId();
            
            if($client_id)
            {
                foreach($tags as $tag){
                    DB::table('client_tags')->insert([
                        'client_id' => $client_id,
                        'tag_id' => $tag
                    ]);
                }
            }
            
            return redirect()->back()->with('status', 'One Client Added Successfully!');
        }
        else
            return redirect()->back()->with('error', 'Password mismatched!');
    }
    
    public function all_clients()
    {
        $all_clients = DB::table('clients')->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;

        return view('client.all-clients', compact('all_clients', 'all_tags', 'all_tags_profile'));
    }
    
    public function all_fav_clients()
    {
        $all_clients = DB::table('clients')->where('is_favourite', 1)->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;

        return view('client.all-fav-clients', compact('all_clients', 'all_tags', 'all_tags_profile'));
    }
    
    public function change_client_fav_status($id)
    {
        $user_id = Auth::user()->id;
        $client_id = $id;
        $query = DB::table('clients')->where('id', $client_id)->first();

        $fav_status = $query->is_favourite;

        if ($fav_status == 1) {
            $fav_status_now = 0;
            $msg = 'One Influencer removed from favourite list!';
        } elseif ($fav_status == 0) {
            $fav_status_now = 1;
            $msg = 'One Influencer added to favourite list!';
        }

        $query = DB::table('clients')->where('id', $client_id)
            ->update([
                'is_favourite' => $fav_status_now,
                'updated_by' => $user_id,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);
        if ($query) {
            return redirect()->back()->with('status', $msg);
            // return redirect('/all-influencers')->with('status', $msg);
        } else
            return redirect('/all-clients')->with('error', 'Something went wrong!');
    }
    
    public function client_filter(Request $req)
    {
        $name = $req->name;
        $email = $req->email;
        $telegram = $req->telegram;
        $tags = $req->tags;
        
        $all_clients = [];
        $client_array = [];
        $client_tags_array = [];
        
        if($tags)
        {
            $i = 0;
            foreach($tags as $tag){
                $client_tags = DB::table('client_tags')
                    ->select('client_id')
                    ->where('tag_id', $tag)
                    ->get();
            }
            foreach($client_tags as $tag)
            {
                $client_tags_array[$i] = $tag->client_id;
                $i++;
            }
        }
        
        $client_array = $client_tags_array;
        
        $all_clients = DB::table('clients')
            ->where('name', 'LIKE', '%' . $name . '%')
            ->where('email', 'LIKE', '%' . $email . '%')
            ->where('telegram', 'LIKE', '%' . $telegram . '%')
            ->get();
        ?>
        <!--All Influencer Table starts here-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <div class="card-datatable table-responsive" id="all_influencers" style="display: block;">
            <table class="dt-advanced-search table table-striped">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="" id="select-all">
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Telegram</th>
                        <th>Tags</th>
                        <th>Favourite</th>
                        <th>VAT No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_clients as $key => $client) : ?>
                        <?php $client_id = $client->id; ?>
                        <?php // if(sizeof($influencer_array) > 0): ?>
                        <?php if($tags): ?>
                            <?php if(in_array($client_id, $client_array)): ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" name="" id="" class="form-check-input">
                                    </div>
                                </td>
                                <td><?php echo $client->name; ?></td>
                                <td><?php echo $client->comany_name; ?></td>
                                <td><?php echo $client->address; ?></td>
                                <td><?php echo $client->email; ?></td>
                                <td><a href="<?php echo $client->telegram; ?>" target="_blank"><?php echo $client->telegram; ?></a></td>
                                <td class="">
                                    <?php
                                    $client_id = $client->id;
                                    $all_tags = DB::table('client_tags')
                                        ->where('client_id', $client_id)
                                        ->join('tags', 'client_tags.tag_id', '=', 'tags.id')
                                        ->get();
                                            
                                    foreach($all_tags as $key=>$tag): ?>
                                        <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $tag->tag; ?></span>
                                    <?php endforeach ?>
                                </td>
                                <td class="text-center">
                                    <?php if($client->is_favourite == 1): ?>
                                        <input type="checkbox" class="form-check-input" onchange="window.location.href='<?php echo url('change-client-fav-status/'.$client->id); ?>'" checked>
                                    <?php elseif($client->is_favourite == 0): ?>
                                        <input type="checkbox" class="form-check-input"
                                            onchange="window.location.href='<?php echo url('change-client-fav-status/'.$client->id); ?>'">
                                    <?php endif ?>
                                </td>
                                <td><?php echo $client->vat_no; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a type="button" class="dropdown-item" onclick="">
                                                <i class="fa fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" name="" id="" class="form-check-input">
                                    </div>
                                </td>
                                <td><?php echo $client->name; ?></td>
                                <td><?php echo $client->comany_name; ?></td>
                                <td><?php echo $client->address; ?></td>
                                <td><?php echo $client->email; ?></td>
                                <td><a href="<?php echo $client->telegram; ?>" target="_blank"><?php echo $client->telegram; ?></a></td>
                                <td class="">
                                    <?php
                                    $client_id = $client->id;
                                    $all_tags = DB::table('client_tags')
                                        ->where('client_id', $client_id)
                                        ->join('tags', 'client_tags.tag_id', '=', 'tags.id')
                                        ->get();
                                            
                                    foreach($all_tags as $key=>$tag): ?>
                                        <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $tag->tag; ?></span>
                                    <?php endforeach ?>
                                </td>
                                <td class="text-center">
                                    <?php if($client->is_favourite == 1): ?>
                                    <input type="checkbox" class="form-check-input"
                                        onchange="window.location.href='<?php echo url('change-client-fav-status/'.$client->id); ?>'" checked>
                                    <?php elseif($client->is_favourite == 0): ?>
                                        <input type="checkbox" class="form-check-input"
                                            onchange="window.location.href='<?php echo url('change-client-fav-status/'.$client->id); ?>'">
                                    <?php endif ?>
                                </td>
                                <td><?php echo $client->vat_no; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a type="button" class="dropdown-item"
                                                onclick="">
                                                <i class="fa fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input type="checkbox" name="" id="" class="form-check-input">
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Telegram</th>
                        <th>Tags</th>
                        <th>Favourite</th>
                        <th>VAT No</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!--All Client Table ends here-->
    <?php
    }
    
    public function client_edit(Request $req)
    {
        $client_id = $req->client_id;
        $client_details = DB::table('clients')->where('id', $client_id)->first();
        
        $all_tags = DB::table('tags')->get();
        $client_tags = DB::table('client_tags')->where('client_id', $client_id)->get();
        $tag_array = [];
        foreach($client_tags as $tag_data){
            $tag_array[] = $tag_data->tag_id;
        }
        ?>
        
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Edit Client Information</h1>
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return true" method="POST" action="<?php echo route('client_edit_submit'); ?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserFirstName" style="font-size: 15px;"><b>Name</b></label>
                            <span class="form-control"><?php echo $client_details->name; ?></span>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Email</b></label>
                            <span class="form-control"><?php echo $client_details->email; ?></span>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Company Name</b></label>
                            <input type="text" class="form-control" value="<?php echo $client_details->comany_name; ?>" name="company_name" />
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Address</b></label>
                            <input type="text" class="form-control" value="<?php echo $client_details->address; ?>" name="client_address" />
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Telegram</b></label>
                            <input type="url" class="form-control" value="<?php echo $client_details->telegram; ?>" name="client_telegram" />
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Vat No.</b></label>
                            <input type="text" class="form-control" value="<?php echo $client_details->vat_no; ?>" name="client_vat_no" />
                        </div>
                        
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Note</b></label>
                            <textarea class="form-control" name="client_note"><?php echo $client_details->note; ?></textarea>
                        </div>
                        
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditkol" style="font-size: 15px;"><b>Tags</b></label><br>
                            <?php foreach($all_tags as $tag): ?>
                                <?php if(in_array($tag->id, $tag_array)): ?>
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $tag->id; ?>" 
                                    id="flexCheckDefault" checked style="padding: 5px;"> <label class="form-label"> <?php echo $tag->tag; ?></label>
                                <?php else: ?>
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $tag->id; ?>" 
                                    id="flexCheckDefault" style="padding: 5px;"> <label class="form-label"> <?php echo $tag->tag; ?></label>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Update</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    
    public function client_edit_submit(Request $req)
    {
        $client_id = $req->client_id;
        $company_name = $req->company_name;
        $client_address = $req->client_address;
        $client_telegram = $req->client_telegram;
        $client_vat_no = $req->client_vat_no;
        $client_note = $req->client_note;
        $tags = $req->tags;
        
        if($tags){
            DB::table('client_tags')->where('client_id', $client_id)->delete();
            
            foreach($tags as $tag){
                DB::table('client_tags')->insert([
                    'client_id' => $client_id,
                    'tag_id' => $tag
                ]);
            }
        }
        
        $query = DB::table('clients')->where('id', $client_id)
            ->update([
                'comany_name' => $company_name,
                'address' => $client_address,
                'telegram' => $client_telegram,
                'vat_no' => $client_vat_no,
                'note' => $client_note
            ]);
        
        return redirect()->back()->with('status', 'One Client Information Updated!');
    }
    
    public function delete_client(Request $req)
    {
        $client_id_to_delete = $req->client_id_to_delete;
        DB::table('clients')->where('id', $client_id_to_delete)->delete();
        DB::table('client_tags')->where('client_id', $client_id_to_delete)->delete();
        
        return redirect()->back()->with('error', 'One Client has been deleted!');
    }
}

?>