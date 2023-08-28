<?php

namespace App\Http\Controllers;

require_once 'vendor/autoload.php';
use App\TwitterService\TwitterWrapper;

use Abraham\TwitterOAuth\TwitterOAuth;

use App\Models\Influencer;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class InfluencerController extends Controller
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
        $all_regions = DB::table('regions')->get();
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();
        $all_wallets = DB::table('wallets')->get();
        return view('influencer.add-new', compact('all_tags', 'all_regions', 'all_socials', 'all_contents', 'all_wallets'));
    }
    
    public function api_integrate()
    {
        return view('influencer.api-integrate');
    }
    
    public function influencer_packages()
    {
        $influencer_packages = DB::table('influencer_package')->orderBy('id', 'DESC')->get();
        return view('influencer.influencer-packages', compact('influencer_packages'));
    }
    public function influencer_packages_template($id)
    {
        $influencer_packages = DB::table('influencer_package')->orderBy('id', 'DESC')->get();
        return view('influencer.influencer-template-packages', compact('influencer_packages','id'));
    }
    public function add_package_to_template(Request $req)
    {
        $template_id = $req->template_id;
        $influencer_template_detail = DB::table('influencer_template')->where('id', $template_id)->first();
        
        $packages = $influencer_template_detail->packages;
        
        if($packages == NULL)
        {
            $package_union = $req->packages;
        }
        else
        {
            $existing_influencers = json_decode($packages, true);
            $new_packages = $req->packages;
            
            $package_union =  array_merge(
                array_intersect($existing_influencers, $new_packages),
                array_diff($existing_influencers, $new_packages),     
                array_diff($new_packages, $existing_influencers)      
            );
        }
        
        DB::table('influencer_template')->where('id', $template_id)->update(['packages' => $package_union]);
        return redirect('/influencer-template-detail/'.$template_id)->with('status', 'Influencer Template Updated');
        
        // var_dump($template_id);
        // var_dump($packages);
        
        
        // $influencer_template_id = $req->influencer_template_id;
        // $influencer_template_detail = DB::table('influencer_template')->where('id', $influencer_template_id)->first();
        // $influencers = $influencer_template_detail->influencers;
        // $existing_influencers = json_decode($influencers, true);
        // $new_influencers = $req->influencer_id;
        
        // $influencer_union =  array_merge(
        //     array_intersect($existing_influencers, $new_influencers),
        //     array_diff($existing_influencers, $new_influencers),     
        //     array_diff($new_influencers, $existing_influencers)      
        // );
        // $influencer_union = json_encode($influencer_union);
        
        // DB::table('influencer_template')->where('id', $influencer_template_id)->update(['influencers' => $influencer_union]);
        
        // return redirect('/influencer-template-detail/'.$influencer_template_id)->with('status', 'Influencer Template Updated');
        
    }
    public function create_new_package()
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');

        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');


        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_influencers = DB::table('influencer')->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;
        $all_regions = DB::table('regions')->get();
        $all_regions_profile = $all_regions;
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();

        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
        $youtubeId = DB::table('socials')->where('social', 'Youtube')->first()->id;
        $youtube_api_key = env('YOUTUBE_API_KEY');
        return view('influencer.create-new-package', compact('all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'all_tags_profile', 'all_regions_profile', 'connection', 'twitterId', 'youtubeId', 'youtube_api_key'));
    }
    public function create_package(Request $req)
    {
        $influencer_id = $req->influencer_id;
        if($influencer_id == null)
        {
            return redirect()->back()->with('status', 'One Influencer must be selected.');
        }
        else
        {
            $influencer_id = $influencer_id[0];
            $package_name = $req->package_name;
            $package_price = $req->package_price;
            
            $query = DB::table('influencer_package')->insert([
                'package_name' => $package_name,
                'influencer_id' => $influencer_id,
                'price' => $package_price
            ]);
                
            $package_id = DB::getPdo()->lastInsertId();
                
            if($package_id)
            {
                $package = DB::table('influencer_package')->where('id', $package_id)->first();
                return view('influencer.packages-content-customize', compact('package'));
            }
        }
    }
    public function package_content_modal(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $package_id = $req->package_id;
        
        $package_detail = DB::table('influencer_package')->where('id', $package_id)->first();
        
        $ifluencer_package_content_qry = DB::table('ifluencer_package_content')
            ->where('influencer_id', $influencer_id)
            ->where('package_id', $package_id)->first();
        
        $influencer_socials = DB::table('influencer_socials')->where('influencer_id', $influencer_id)->get(['social_id']);
        
        $influencer_social_array = [];
        foreach($influencer_socials as $key=>$social)
        {
            $influencer_social_array[$key] = $social->social_id;
        }
        
        $influencer_contents = DB::table('contents')->get();
        ?>
        
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2 pb-100">
                        <h1 class="mb-1">Edit Package</h1>
                    </div>
                    <hr />                          
                    <div class="row d-flex align-items-end">
                        <form id="addPermissionForm" class="row" method="POST" action="/influencer-package-content-edit" novalidate="novalidate">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first-name-column"><b>Package Name</b></label>
                                        <input type="text" placeholder="Enter Package Name" name="package_name" class="form-control" value="<?php echo $package_detail->package_name; ?>" />
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first-name-column"><b>Package Price</b></label>
                                        <input type="number" placeholder="Enter Package Price" name="package_price" class="form-control" value="<?php echo $package_detail->price; ?>" />
                                    </div>
                                </div>
                            </div>
                                            
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Content Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($influencer_contents as $key=>$content):
                                        if(in_array($content->social_id, $influencer_social_array))
                                        {
                                            $content_id = $content->id;
                                            if($ifluencer_package_content_qry)
                                            {
                                                $existing_influencer_content = DB::table('ifluencer_package_content')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->where('package_id', $package_id)
                                                    ->where('content_id', $content_id)->first();
                                            }
                                            else{
                                                $existing_influencer_content = DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)->first();
                                            }
                                            
                                            $packageContentDetail = DB::table('ifluencer_package_content')
                                                ->where('package_id', $package_id)
                                                ->where('influencer_id', $influencer_id)
                                                ->where('content_id', $content_id)
                                                ->first();
                                                
                                            if($existing_influencer_content)
                                            {
                                                $content_price = $existing_influencer_content->price;
                                                if($packageContentDetail)
                                                    $quantity = $packageContentDetail->content_quantity;
                                                else
                                                    $quantity = 1;
                                            }
                                            else
                                            {
                                                $quantity = null;
                                                $content_price = null;
                                            }
                                            
                                            ?>
                                            <tr>
                                                <input type="hidden" name="influencer_id" class="influencer-<?php echo $content_id; ?>" value="<?php echo $influencer_id; ?>" />
                                                <input type="hidden" name="package_id" value="<?php echo $package_id; ?>" />
                                                <input type="hidden" name="content_ids[]" value="<?php echo $content_id; ?>" />
                                                <td>
                                                    <div class="form-check">
                                                        <?php if(isset($existing_influencer_content->id)){ ?>
                                                            <input type="checkbox" name="checkbox[]" value="<?php echo $key; ?>" id="check-<?php echo $content_id; ?>" class="form-check-input" onclick="editAccess(<?php echo $content_id; ?>)" checked>
                                                        <?php } else { ?>
                                                            <input type="checkbox" name="checkbox[]" value="<?php echo $key; ?>" id="check-<?php echo $content_id; ?>" class="form-check-input" onclick="editAccess(<?php echo $content_id; ?>)" />
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span><?php echo $content->content_name; ?></span>
                                                </td>
                                                <td>
                                                    <?php if(isset($existing_influencer_content->id)): ?>
                                                        <input type="number" name="quantity[]" class="form-control" value="<?php echo $quantity; ?>" id="quantity-<?php echo $content_id; ?>" />
                                                    <?php else: ?>
                                                        <input type="number" name="quantity[]" class="form-control" value="<?php echo $quantity; ?>" id="quantity-<?php echo $content_id; ?>" readonly />
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                                                        
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1">Save</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    public function influencer_template()
    {
        $influencer_templates = DB::table('influencer_template')->orderBy('id', 'DESC')->get();
        
        return view('influencer.influencer-template', compact('influencer_templates'));
    }
    public function influencer_template_detail($id)
    {
        $influencer_template_detail = DB::table('influencer_template')->where('id', $id)->first();
        return view('influencer.influencer-template-detail', compact('influencer_template_detail'));
    }
    public function add_campaign_from_template($id)
    {
        if(Auth::user()->role == 'Client')
            $clients = DB::table('clients')->where('user_id', Auth::user()->id)->get();
        else
            $clients = DB::table('clients')->get();
        
        $all_regions = DB::table('regions')->get();
        $influencer_template_detail = DB::table('influencer_template')->where('id', $id)->first();
        return view('influencer.add-campaign-from-template', compact('influencer_template_detail', 'clients', 'all_regions'));
    }
    public function add_influencer_to_template($id)
    {
        $all_influencers = DB::table('influencer')->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;
        $all_regions = DB::table('regions')->get();
        $all_regions_profile = $all_regions;
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();
        
        return view('influencer.add-influencer-to-template', compact('id', 'all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'all_tags_profile', 'all_regions_profile'));
    }
    public function edit_template_basics(Request $req)
    {
        $clients_budget = $req->clients_budget;
        $total_cost = $req->total_cost;
        if($total_cost > $clients_budget)
        {
            return redirect()->back()->with('error', 'Total cost exceeded clients budget. Increase Clients budget or reduce cost.');
        }
        else
        {
            $template_id = $req->template_id;
            $template_name = $req->template_name;
            $profit_margin = $req->profit_margin;
            
            DB::table('influencer_template')->where('id', $template_id)->update([
                'template_name' => $template_name,
                'clients_budget' => $clients_budget,
                'profit_margin' => $profit_margin
            ]);
            
            return redirect()->back()->with('status', 'Influencer Template Updated');
        }
    }
    public function post_influencer_to_template(Request $req)
    {
        $influencer_template_id = $req->influencer_template_id;
        $influencer_template_detail = DB::table('influencer_template')->where('id', $influencer_template_id)->first();
        $influencers = $influencer_template_detail->influencers;
        $existing_influencers = json_decode($influencers, true);
        $new_influencers = $req->influencer_id;
        
        $influencer_union =  array_merge(
            array_intersect($existing_influencers, $new_influencers),
            array_diff($existing_influencers, $new_influencers),     
            array_diff($new_influencers, $existing_influencers)      
        );
        $influencer_union = json_encode($influencer_union);
        
        DB::table('influencer_template')->where('id', $influencer_template_id)->update(['influencers' => $influencer_union]);
        
        return redirect('/influencer-template-detail/'.$influencer_template_id)->with('status', 'Influencer Template Updated');
    }
    public function remove_influencer_from_template(Request $req)
    {
        $influencer_template_id = $req->influencer_template_id;
        $influencer_id_to_remove = $req->influencer_id_to_remove;
        
        $influencer_template_detail = DB::table('influencer_template')->where('id', $influencer_template_id)->first();
        $influencers = $influencer_template_detail->influencers;
        $existing_influencers = json_decode($influencers, true);
        
        foreach($existing_influencers as $key=>$influencer)
        {
            if($influencer == $influencer_id_to_remove)
            {
                unset($existing_influencers[$key]);
                break;
            }
        }
        $influencers = json_encode($existing_influencers);
        DB::table('influencer_template')->where('id', $influencer_template_id)->update(['influencers' => $influencers]);
        
        return redirect('/influencer-template-detail/'.$influencer_template_id)->with('status', 'One Influencer Removed from Template.');
    }
    
    public function remove_package(Request $req)
    {
        $influencer_package_id = $req->influencer_package_id;
        
        DB::table('influencer_package')->where('id', $influencer_package_id)->delete();
        
        DB::table('ifluencer_package_content')->where('package_id', $influencer_package_id)->delete();
        
        return redirect()->back()->with('status', 'One Package Deleted.');
    }
    
    public function remove_package_from_template(Request $req)
    {
        $influencer_template_id = $req->influencer_template_id;
        $package_id_to_remove = $req->package_id_to_remove;
        
        $influencer_template_detail = DB::table('influencer_template')->where('id', $influencer_template_id)->first();
        $packages = $influencer_template_detail->packages;
        $existing_packages = json_decode($packages, true);
        
        foreach($existing_packages as $key=>$package)
        {
            if($package == $package_id_to_remove)
            {
                unset($existing_packages[$key]);
                break;
            }
        }
        $packages = json_encode($existing_packages);
        DB::table('influencer_template')->where('id', $influencer_template_id)->update(['packages' => $packages]);
        
        return redirect('/influencer-template-detail/'.$influencer_template_id)->with('status', 'One Package Removed from Template.');
    }
    
    public function influencer_template_content_edit(Request $req)
    {
        // $post = $req->post();
        // dd($post);
        // exit;
        
        $template_id = $req->template_id;
        $influencer_id = $req->influencer_id;
        $checkbox = $req->checkbox;
        $content_ids = $req->content_ids;
        $quantity = $req->quantity;
        $price = $req->price;
        
        $old_data = DB::table('ifluencer_template_content')
            ->where('template_id', $template_id)
            ->where('influencer_id', $influencer_id)
            ->delete();
        
        if($checkbox)
        {
            foreach($checkbox as $data=>$index)
            {
                $content_id = $content_ids[$index];
                $content_quantity = $quantity[$index];
                $content_price = $price[$index];
                
                // $query = DB::table('ifluencer_template_content')
                //     ->where('template_id', $template_id)
                //     ->where('influencer_id', $influencer_id)
                //     ->where('content_id', $content_id)
                //     ->first();
                
                // if($query)
                // {
                //     $query = DB::table('ifluencer_template_content')
                //     ->where('template_id', $template_id)
                //     ->where('influencer_id', $influencer_id)
                //     ->where('content_id', $content_id)
                //     ->update([
                //         'content_quantity' => $content_quantity,
                //         'price' => $content_price
                //     ]);
                // }
                // else
                // {
                //     $query = DB::table('ifluencer_template_content')->insert([
                //         'template_id' => $template_id,
                //         'influencer_id' => $influencer_id,
                //         'content_id' => $content_id,
                //         'content_quantity' => $content_quantity,
                //         'price' => $content_price
                //     ]);
                // }
                
                $query = DB::table('ifluencer_template_content')->insert([
                    'template_id' => $template_id,
                    'influencer_id' => $influencer_id,
                    'content_id' => $content_id,
                    'content_quantity' => $content_quantity,
                    'price' => $content_price
                ]);
            }
            
            return redirect('/influencer-template-detail/'.$template_id)->with('status', 'Influencer Template Updated');
        }
        else
            return redirect()->back()->with('status', 'Select At least One Content');
    }
    
    public function package_detail($id)
    {
        $package = DB::table('influencer_package')->where('id', $id)->first();
        return view('influencer.packages-content-customize', compact('package'));
    }
    
    public function influencer_package_content_edit(Request $req)
    {
        $package_id = $req->package_id;
        $package_name = $req->package_name;
        $package_price = $req->package_price;
        
        DB::table('influencer_package')->where('id', $package_id)
            ->update([
                'package_name' => $package_name,
                'price' => $package_price
            ]);
                        
        $influencer_id = $req->influencer_id;
        $checkbox = $req->checkbox;
        $content_ids = $req->content_ids;
        $quantity = $req->quantity;
        
        $old_data = DB::table('ifluencer_package_content')
            ->where('package_id', $package_id)
            ->where('influencer_id', $influencer_id)
            ->delete();
        
        foreach($checkbox as $data=>$index)
        {
            $content_id = $content_ids[$index];
            $content_quantity = $quantity[$index];
            
            $query = DB::table('ifluencer_package_content')->insert([
                'package_id' => $package_id,
                'influencer_id' => $influencer_id,
                'content_id' => $content_id,
                'content_quantity' => $content_quantity
            ]);
        }
        
        return redirect('/package-detail/'.$package_id)->with('status', 'Package Updated');
        // return redirect()->back()->with('status', 'Package Updated');
    }
    
    public function delete_influencer_template(Request $req)
    {
        $template_id = $req->influencer_template_id;
        
        $del1 = DB::table('influencer_template')
            ->where('id', $template_id)
            ->delete();
        $del2 = DB::table('ifluencer_template_content')
            ->where('template_id', $template_id)
            ->delete();
            
        return redirect()->back()->with('status', 'One Template Deleted.');
    }
    public function template_content_modal(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $template_id = $req->template_id;
        
        $influencer_socials = DB::table('influencer_socials')->where('influencer_id', $influencer_id)->get(['social_id']);
        
        $influencer_social_array = [];
        foreach($influencer_socials as $key=>$social)
        {
            $influencer_social_array[$key] = $social->social_id;
        }
        $influencer_contents = DB::table('contents')->get();
        ?>
        
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2 pb-100">
                        <h1 class="mb-1">Edit Content Price & Quantity</h1>
                    </div>
                    <hr />                             
                    <div class="row d-flex align-items-end">
                        <form id="addPermissionForm" class="row" method="POST" action="/influencer-template-content-edit" novalidate="novalidate">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Content Name</th>
                                        <th>Quantity</th>
                                        <th>Price/Unit</th>
                                        <th>Base Price Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $chk_i = 0;
                                    foreach($influencer_contents as $key=>$content):
                                        if(in_array($content->social_id, $influencer_social_array))
                                        {
                                            $content_id = $content->id;
                                            $existing_influencer_content = DB::table('ifluencer_template_content')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->where('template_id', $template_id)
                                                    ->where('content_id', $content_id)->first();
                                            
                                            $templateContentDetail = DB::table('ifluencer_template_content')
                                                ->where('template_id', $template_id)
                                                ->where('influencer_id', $influencer_id)
                                                ->where('content_id', $content_id)
                                                ->first();
                                                
                                            if($existing_influencer_content)
                                            {
                                                $content_price = $existing_influencer_content->price;
                                                if($templateContentDetail)
                                                    $quantity = $templateContentDetail->content_quantity;
                                                else
                                                    $quantity = 1;
                                            }
                                            else
                                            {
                                                $quantity = null;
                                                $content_price = null;
                                            }
                                            
                                            ?>
                                            <tr>
                                                <input type="hidden" name="influencer_id" class="influencer-<?php echo $content_id; ?>" value="<?php echo $influencer_id; ?>" />
                                                <input type="hidden" name="template_id" value="<?php echo $template_id; ?>" />
                                                <input type="hidden" name="content_ids[]" value="<?php echo $content_id; ?>" />
                                                <td>
                                                    <div class="form-check">
                                                        <?php if(isset($existing_influencer_content->id)){ ?>
                                                            <input type="checkbox" name="checkbox[]" value="<?php echo $chk_i; ?>" id="check-<?php echo $content_id; ?>" class="form-check-input" onclick="editAccess(<?php echo $content_id; ?>)" checked>
                                                        <?php } else { ?>
                                                            <input type="checkbox" name="checkbox[]" value="<?php echo $chk_i; ?>" id="check-<?php echo $content_id; ?>" class="form-check-input" onclick="editAccess(<?php echo $content_id; ?>)" />
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span><?php echo $content->content_name; ?></span>
                                                </td>
                                                <td>
                                                    <?php if(isset($existing_influencer_content->id)): ?>
                                                        <input type="number" name="quantity[]" class="form-control" value="<?php echo $quantity; ?>" id="quantity-<?php echo $content_id; ?>" />
                                                    <?php else: ?>
                                                        <input type="number" name="quantity[]" class="form-control" value="<?php echo $quantity; ?>" id="quantity-<?php echo $content_id; ?>" readonly />
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($existing_influencer_content->id)): ?>
                                                        <input type="number" name="price[]" class="form-control" value="<?php echo $content_price; ?>" id="price-<?php echo $content_id; ?>" />
                                                    <?php else: ?>
                                                        <input type="number" name="price[]" class="form-control" value="<?php echo $content_price; ?>" id="price-<?php echo $content_id; ?>" readonly />
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($existing_influencer_content->id)): ?>
                                                        <button class="btn btn-sm btn-primary" id="btn-<?php echo $content_id; ?>" type="button" onclick="update_content_price(<?php echo $content_id; ?>)">Update</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-primary" id="btn-<?php echo $content_id; ?>" type="button" onclick="update_content_price(<?php echo $content_id; ?>)" disabled>Update</button>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php 
                                            $chk_i++;
                                        } ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                                                        
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1">Save</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    public function integrate_twitter()
    {
        $influencers = DB::table('influencer')->get();
        
        foreach($influencers as $key=>$influencer)
        {
            $influencer_id = $influencer->id;
            $twitter_detail = DB::table('influencer_socials')
                ->where('influencer_id', $influencer_id)
                ->where('social_id', 6)
                ->first();
                                            
            $twitter_followers_count = null;
            $twitter_profile_image_url = null;
            
            if($twitter_detail){
                $twitter_link= $twitter_detail->social_address;
                $twitter_arr = explode('/', $twitter_link);
                $twitter_arr = array_reverse($twitter_arr);
                $twitter_username = $twitter_arr[0];
                                            
                if($twitter_username){
                                                
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        // CURLOPT_URL => 'http://209.97.162.57/twitter?username='.$twitter_username,
                        CURLOPT_URL => 'http://178.128.55.233/twitter?username='.$twitter_username,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));
                                                
                    $response = curl_exec($curl);
                    curl_close($curl);
                    
                    $response = json_decode($response, true);
                                                
                    if($response)
                    {
                        $twitter_profile_image_url = $response['profile_image_url'];
                        $twitter_followers_count = $response['followers_count'];
                        $youtube_follower = $influencer->youtube_follower;
                        
                        $total_follower = $twitter_followers_count + $youtube_follower;
                        DB::table('influencer')->where('id', $influencer_id)->update([
                            'dp_url' => $twitter_profile_image_url,
                            'twitter_follower' => $twitter_followers_count,
                            'total_follower' => $total_follower
                        ]);
                    }
                }
            }
        }
        
        return redirect()->back()->with('status', 'Twitter data integrated');
    }
    
    public function integrate_youtube()
    {
        $influencers = DB::table('influencer')->get();
        
        $social = DB::table('socials')->where('social', 'Youtube')->first();
        $social_id = $social->id;
        
        // foreach($influencers as $key=>$influencer)
        // {
            // $influencer_id = $influencer->id;
            // $twitter_detail = DB::table('influencer_socials')
            //     ->where('influencer_id', $influencer_id)
            //     ->where('social_id', $social_id)
            //     ->first();
                                            
            // $twitter_followers_count = null;
            // $twitter_profile_image_url = null;
            
            $twitter_detail = 1;
            
            if($twitter_detail){
                $url = 'https://www.youtube.com/@EliasHossain';
                
                // $parsed = parse_url(rtrim($url, '/'));
                // if (isset($parsed['path']) && preg_match('/^\/channel\/(([^\/])+?)$/', $parsed['path'], $matches)) {
                //     $channel_id = $matches[1];
                // }
                
                $html = file_get_contents($url);
                preg_match("'<meta itemprop=\"channelId\" content=\"(.*?)\"'si", $html, $match);
                if($match && $match[1]);
                $channel_id = $match[1];
                // else
                //     $channel_id = null;
                
                var_dump($channel_id);
                                            
                if($channel_id!=null){
                                                
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_id.'&key=AIzaSyDfsApzGNXz4W4jH7MrfLZx9qq6NcM_2cI',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                    ));
                    
                    $response = curl_exec($curl);
                    
                    curl_close($curl);
                    echo $response;
                                                
                    if($response)
                    {
                        // $twitter_profile_image_url = $response['profile_image_url'];
                        // $twitter_followers_count = $response['followers_count'];
                        // $youtube_follower = $influencer->youtube_follower;
                        
                        // $total_follower = $twitter_followers_count + $youtube_follower;
                        // DB::table('influencer')->where('id', $influencer_id)->update([
                        //     'dp_url' => $twitter_profile_image_url,
                        //     'twitter_follower' => $twitter_followers_count,
                        //     'total_follower' => $total_follower
                        // ]);
                    }
                }
            }
        // }
        
        // return redirect()->back()->with('status', 'Twitter data integrated');
    }
    
    public function add_new_influencer(Request $req)
    {
        $user_id = Auth::user()->id;
        $name = $req->name;
        $contact_type = $req->contact_type;
        $contact = $req->contact;
        $email = $req->email;

        $regions = $req->regions;
        $tags = $req->tags;
        $socials = $req->social;
        $contents = $req->content;
        $wallets = $req->wallet;

        $note = $req->note;

        $new_influencer = DB::table('influencer')->insert([
            'name' => $name,
            'contact_type' => $contact_type,
            'contact' => $contact,
            'email' => $email,
            'note' => $note,
            'created_by' => $user_id,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);

        $influencer_id = DB::getPdo()->lastInsertId();

        if ($influencer_id) {
            if ($regions) {
                foreach ($regions as $region) {
                    DB::table('influencer_regions')->insert([
                        'influencer_id' => $influencer_id,
                        'region_id' => $region
                    ]);
                }
            }

            if ($tags) {
                foreach ($tags as $tag) {
                    DB::table('influencer_tags')->insert([
                        'influencer_id' => $influencer_id,
                        'tag_id' => $tag
                    ]);
                }
            }

            if ($socials) {
                foreach ($socials as $social) {
                    DB::table('influencer_socials')->insert([
                        'influencer_id' => $influencer_id,
                        'social_id' => $social['name'],
                        'social_address' => $social['address']
                    ]);
                    
                    if($social['name'] == 6)
                    {
                        $twitter_link= $social['address'];
                        $twitter_arr = explode('/', $twitter_link);
                        $twitter_arr = array_reverse($twitter_arr);
                        $twitter_username = $twitter_arr[0];
                        
                        $followers_count = null;
                        $profile_image_url = null;
                                
                        if($twitter_username)
                        {
                            $API_KEY = 'jfgwP46BbyIExEiVCK3ES4GJs';
                            $API_SECRET = 'YCiS3H8As5MZV8SLq1Q2MwL67wldcnsrnWEZTVf3JQ368OqIes';
                            
                            $ACCESS_TOKEN = "849552149432467457-9b4gZDCZM8D0P1gUHZO7OxvkmwponU3";
                            $ACCESS_TOKEN_SECRET = "eeADmqskvSC0oGeG5105o53wZdOvyeq2C3ZLr1i0NLNPo";
                            $BEARER_TOKEN = "AAAAAAAAAAAAAAAAAAAAALSdpQEAAAAAHljxOglUCxteud%2F67KSC%2FjqUdC8%3DAbjItTloqlmQi2Vj5xpQBUCpW29vlSEd6saa5Vw098YxYsMcRP";
                            
                            $twitterClient = new TwitterWrapper($API_KEY, $API_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);
                            
                            $result = $twitterClient->getUserByUsername($twitter_username);
                            
                            // echo "<h3>//Twitter API Response//</h3>";
                            // echo '<pre>';
                            // print_r($result);
                            // echo '</pre>';
                            
                            // exit;
                            
                            if(isset($result->data))
                            {
                                $followers_count = $result->data->public_metrics->followers_count;
                                $profile_image_url = $result->data->profile_image_url;
                            }
                        }
                        
                        $search = DB::table('influencer')->where('id', $influencer_id)->first();
                        $total_follower = $search->total_follower;
                        
                        $query = DB::table('influencer')->where('id', $influencer_id)
                            ->update([
                                'dp_url' => $profile_image_url,
                                'twitter_follower' => $followers_count,
                                'total_follower' => $total_follower + $followers_count
                            ]);
                    }
                }
            }
            if ($contents) {
                foreach ($contents as $content) {
                    DB::table('influencer_contents')->insert([
                        'influencer_id' => $influencer_id,
                        'content_id' => $content['content'],
                        'price' => $content['price']
                    ]);
                }
            }
            if ($wallets) {
                foreach ($wallets as $wallet) {
                    DB::table('influencer_wallets')->insert([
                        'influencer_id' => $influencer_id,
                        'wallet_id' => $wallet['type'],
                        'wallet_address' => $wallet['address']
                    ]);
                }
            }
            return redirect('/all-influencers')->with('status', 'New Influencer Added Successfully!');
        } else
            return redirect('/all-influencers')->with('error', 'Something went wrong!');
        // } else
        //     return redirect('/all-influencers')->with('error', 'Password not matched!');
    }

    public function test(Request $r)
    {
        $all_inf = DB::table('influencer_tags')->select('influencer_id')
            ->whereIn('tag_id', $r->tags)
            ->get();
        //            ->pluck('influencer_id');
        return $all_inf;
        //        return $r->tags;
    }
    public function getData(Request $r)
    {
        $all_influencers = Influencer::select('*');
        if ($r->name) {
            $all_influencers = $all_influencers->where('name', 'like', '%' . $r->name . '%');
        }
        if ($r->follower_number) {
            $all_influencers = $all_influencers->where('total_follower', '>=', $r->follower_number);
        }
        if ($r->regions) {
            //  $all_inf= DB::table('influencer_regions')->select('influencer_id')
            //      ->whereIn('region_id',$r->regions)
            //      ->get()
            //      ->pluck('influencer_id');
            //  $all_influencers=$all_influencers->whereIn('id',$all_inf);

            $all_inf = DB::table('influencer_regions')
                ->whereIn('region_id', $r->regions)
                ->groupBy('influencer_id')
                ->havingRaw('COUNT(DISTINCT region_id) =' . count($r->regions))
                ->select('influencer_id')
                ->get()->pluck('influencer_id');
            $all_influencers = $all_influencers->whereIn('id', $all_inf);
        }
        if ($r->socials) {
            // $all_inf = DB::table('influencer_socials')->select('influencer_id')
            //     ->whereIn('social_id', $r->socials)
            //     ->get()
            //     ->pluck('influencer_id');
            // $all_influencers = $all_influencers->whereIn('id', $all_inf);
            
            $all_inf = DB::table('influencer_socials')
                ->whereIn('social_id', $r->socials)
                ->groupBy('influencer_id')
                ->havingRaw('COUNT(DISTINCT social_id) =' . count($r->socials))
                ->select('influencer_id')
                ->get()->pluck('influencer_id');
            $all_influencers = $all_influencers->whereIn('id', $all_inf);
        }

        if ($r->tags) {
            // $all_inf = DB::table('influencer_tags')->select('influencer_id')
            //     ->whereIn('tag_id', $r->tags)
            //     ->get()
            //     ->pluck('influencer_id');
            // $all_influencers = $all_influencers->whereIn('id', $all_inf);
            
            $all_inf = DB::table('influencer_tags')
                ->whereIn('tag_id', $r->tags)
                ->groupBy('influencer_id')
                ->havingRaw('COUNT(DISTINCT tag_id) =' . count($r->tags))
                ->select('influencer_id')
                ->get()->pluck('influencer_id');
            $all_influencers = $all_influencers->whereIn('id', $all_inf);
        }
        if ($r->contents) {
            // $all_inf = DB::table('influencer_contents')->select('influencer_id')
            //     ->whereIn('content_id', $r->contents)
            //     ->get()
            //     ->pluck('influencer_id');
            // $all_influencers = $all_influencers->whereIn('id', $all_inf);
            
            $all_inf = DB::table('influencer_contents')
                ->whereIn('content_id', $r->contents)
                ->groupBy('influencer_id')
                ->havingRaw('COUNT(DISTINCT content_id) =' . count($r->contents))
                ->select('influencer_id')
                ->get()->pluck('influencer_id');
            $all_influencers = $all_influencers->whereIn('id', $all_inf);
        }

        $all_regions = DB::table('influencer_regions')
            ->leftJoin('regions', 'influencer_regions.region_id', 'regions.id')
            ->get();

        $all_tags = DB::table('influencer_tags')
            ->leftJoin('tags', 'influencer_tags.tag_id', 'tags.id')
            ->get();

        $all_socials = DB::table('influencer_socials')
            ->leftJoin('socials', 'influencer_socials.social_id', 'socials.id')
            ->get();

        $all_contents = DB::table('influencer_contents')
            ->leftJoin('contents', 'influencer_contents.content_id', 'contents.id')
            ->get();

        $datatables = Datatables::of($all_influencers)
            ->addColumn('regions', function ($data) use ($all_regions) {
                $user_reginons = $all_regions->where('influencer_id', $data->id);
                $reg = '';
                foreach ($user_reginons as $data) {
                    $reg .= '<span class="badge rounded-pill badge-light-info link-bottom">' . $data->region . '</span>';
                }
                return $reg;
            })
            ->addColumn('tags', function ($data) use ($all_tags) {
                $all_tags = $all_tags->where('influencer_id', $data->id);
                $reg = '';
                foreach ($all_tags as $data) {
                    $reg .= '<span class="badge rounded-pill badge-light-info link-bottom">' . $data->tag . '</span>';
                }
                return $reg;
            })
            ->addColumn('socials', function ($data) use ($all_socials) {
                $all_socials = $all_socials->where('influencer_id', $data->id);
                $reg = '';
                foreach ($all_socials as $data) {
                    // $social_id = $data->social_id;
                    // $social = DB::table('socials')->where('id', $social_id)->first();
                    $social_media = $data->social;
                                                        
                    if($social_media == 'Twitter'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #00acee;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    elseif($social_media == 'Youtube'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #CD201F;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    elseif($social_media == 'Facebook'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #3b5998;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    elseif($social_media == 'Linkedin'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #0072b1;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    elseif($social_media == 'TikTok'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #ff0050;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    elseif($social_media == 'Instagram'):
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '" style="background-color: #962fbf;"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    else:
                        $reg .= '<a class="badge rounded-pill link-bottom" target="_blank" href="' . $data->social_address . '"><span style="color: #ffffff;">' . $data->social . '</span></a>';
                    endif;
                    
                    // $reg .= $social_media;
                    // $reg .= '<a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="' . $data->social_address . '">' . $data->social . '</a>';
                }
                return $reg;
            })
            ->addColumn('contents', function ($data) use ($all_contents) {
                $all_contents = $all_contents->where('influencer_id', $data->id);
                $reg = '';
                foreach ($all_contents as $data) {
                    $content_id = $data->content_id;
                    $content = DB::table('contents')->where('id', $content_id)->first();
                    $social_media = null;
                    if($content->social_id != null)
                    {
                        $social = DB::table('socials')->where('id', $content->social_id)->first();
                        $social_media = $social->social;
                    }
                                                        
                    if($social_media == 'Twitter'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #00acee;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    elseif($social_media == 'Youtube'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #CD201F;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    elseif($social_media == 'Facebook'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #3b5998;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    elseif($social_media == 'Linkedin'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #0072b1;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    elseif($social_media == 'TikTok'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #ff0050;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    elseif($social_media == 'Instagram'):
                        $reg .= '<span class="badge rounded-pill link-bottom" style="background-color: #962fbf;"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    else:
                        $reg .= '<span class="badge rounded-pill badge-light-info link-bottom"><span style="color: #ffffff;">' . $data->short_name . ' - ' . $data->price . '</span></span>';
                    endif;
                    
                    // $reg .= '<span class="badge rounded-pill badge-light-info link-bottom">' . $data->short_name . ' - ' . $data->price . '</span>';
                }
                return $reg;
            })
            ->rawColumns(['regions', 'tags', 'socials', 'contents']);

        return $datatables->make(true);
    }

    public function all_influencers()
    {

        //        $all_inf= DB::table('influencer_regions')->select('influencer_id')->where('region_id',6)->get()->pluck('influencer_id');
        //        return $all_inf;
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');

        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');


        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_influencers = DB::table('influencer')->get();

        //        $datatables = Datatables::of($all_influencers);
        //        return $datatables->make(true);
        //        return $all_influencers;
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;
        $all_regions = DB::table('regions')->get();
        $all_regions_profile = $all_regions;
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();

        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
        $youtubeId = DB::table('socials')->where('social', 'Youtube')->first()->id;
        $youtube_api_key = env('YOUTUBE_API_KEY');
        return view('influencer.all', compact('all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'all_tags_profile', 'all_regions_profile', 'connection', 'twitterId', 'youtubeId', 'youtube_api_key'));
    }

    public function all_influencers2()
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');

        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_influencers = DB::table('influencer')->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;
        $all_regions = DB::table('regions')->get();
        $all_regions_profile = $all_regions;
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();

        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
        $youtubeId = DB::table('socials')->where('social', 'Youtube')->first()->id;
        $youtube_api_key = env('YOUTUBE_API_KEY');
        return view('influencer.all-influencers2', compact('all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'all_tags_profile', 'all_regions_profile', 'connection', 'twitterId', 'youtubeId', 'youtube_api_key'));
    }


    public function add_to_fav(Request $req)
    {
        $user_id = Auth::user()->id;
        $influencer_id = $req->influencer_id_not_fav;
        $fav_status = $req->fav_status_false;

        if ($fav_status == 0) {
            $query = DB::table('influencer')->where('id', $influencer_id)
                ->update([
                    'is_favourite' => 1,
                    'updated_by' => $user_id,
                    'updated_at' => now()->format('Y-m-d H:i:s')
                ]);
            if ($query)
                return redirect('/all-influencers')->with('status', 'One Influencer added to favourite list!');

            else
                return redirect('/all-influencers')->with('error', 'Something went wrong!');
        }
    }

    public function change_fav_status($id)
    {
        $user_id = Auth::user()->id;
        $influencer_id = $id;
        $query = DB::table('influencer')->where('id', $influencer_id)->first();

        $fav_status = $query->is_favourite;

        if ($fav_status == 1) {
            $fav_status_now = 0;
            $msg = 'One Influencer removed from favourite list!';
        } elseif ($fav_status == 0) {
            $fav_status_now = 1;
            $msg = 'One Influencer added to favourite list!';
        }

        $query = DB::table('influencer')->where('id', $influencer_id)
            ->update([
                'is_favourite' => $fav_status_now,
                'updated_by' => $user_id,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);
            
        return redirect()->back();
        //        if ($query) {
        //            return redirect()->back()->with('status', $msg);
        //            // return redirect('/all-influencers')->with('status', $msg);
        //        } else
        //            return redirect('/all-influencers')->with('error', 'Something went wrong!');
    }

    public function favourite_influencers()
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');

        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;

        $fav_influencers = DB::table('influencer')->where('is_favourite', 1)->get();

        return view('influencer.fav-influencers', compact('fav_influencers', 'connection', 'twitterId'));
    }

    public function influencer_profile($id)
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_tags_profile = DB::table('tags')->get();
        $all_regions_profile = DB::table('regions')->get();

        $influencer_details = DB::table('influencer')->where('id', $id)->get();
        $influencer_details = json_decode($influencer_details, true);
        $influencer_details = $influencer_details[0];

        return view('influencer.influencer-profile', compact('influencer_details', 'all_tags_profile', 'all_regions_profile', 'connection'));
    }

    public function edit_profile(Request $req)
    {
        $user_id = Auth::user()->id;
        $influencer_id = $req->influencer_id;
        $influencer_name = $req->influencer_name;
        $influencer_telegram = $req->influencer_telegram;
        $influencer_email = $req->influencer_email;

        $query = DB::table('influencer')->where('id', $influencer_id)
            ->update([
                'name' => $influencer_name,
                'telegram' => $influencer_telegram,
                'email' => $influencer_email,
                'updated_by' => $user_id,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);

        $influencer_regions = $req->influencer_regions;
        $influencer_tags = $req->influencer_tags;
        if ($influencer_regions && $influencer_tags) {
            DB::table('influencer_regions')->where('influencer_id', $influencer_id)->delete();
            DB::table('influencer_tags')->where('influencer_id', $influencer_id)->delete();
        }

        foreach ($influencer_regions as $region) {
            DB::table('influencer_regions')->insert([
                'influencer_id' => $influencer_id,
                'region_id' => $region
            ]);
        }

        foreach ($influencer_tags as $tag) {
            DB::table('influencer_tags')->insert([
                'influencer_id' => $influencer_id,
                'tag_id' => $tag
            ]);
        }
        // return redirect('/influencer-profile/'.$influencer_id)->with('status', 'Profile Updated');
        return redirect()->back()->with('status', 'Profile Updated');
    }

    public function influencer_billing($id)
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');
        // DB::table('influencer_wallets')->where('influencer_id', $influencer_id_to_delete)->delete();
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_contents_profile = DB::table('contents')->get();
        $all_wallets_profile = DB::table('wallets')->get();
        $all_tags_profile = DB::table('tags')->get();
        $all_regions_profile = DB::table('regions')->get();
        $influencer_details = DB::table('influencer')->where('id', $id)->get();
        $influencer_details = json_decode($influencer_details, true);
        $influencer_details = $influencer_details[0];

        return view('influencer.billing', compact('influencer_details', 'all_tags_profile', 'all_regions_profile', 'all_wallets_profile', 'all_contents_profile', 'connection'));
    }

    public function add_new_influencer_wallet(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $wallet_id = $req->wallet_id;
        $wallet_address = $req->wallet_address;

        DB::table('influencer_wallets')->insert([
            'influencer_id' => $influencer_id,
            'wallet_id' => $wallet_id,
            'wallet_address' => $wallet_address
        ]);

        return redirect('/influencer/billing/' . $influencer_id)->with('status', 'New Wallet Added');
    }

    public function add_new_influencer_content(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $content_id = $req->content_id;
        $price = $req->price;
        
        $search = DB::table('influencer_contents')->where([
            'influencer_id' => $influencer_id,
            'content_id' => $content_id
        ])->first();
        
        if($search == null)
        {
            DB::table('influencer_contents')->insert([
                'influencer_id' => $influencer_id,
                'content_id' => $content_id,
                'price' => $price
            ]);
    
            return redirect()->back()->with('status', 'New Content Added');
        }
        else
        {
            return redirect()->back()->with('status', 'Content already exists.');
        }
    }

    public function influencer_connections($id)
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_socials_profile = DB::table('socials')->get();
        $all_tags_profile = DB::table('tags')->get();
        $all_regions_profile = DB::table('regions')->get();
        $influencer_details = DB::table('influencer')->where('id', $id)->get();
        $influencer_details = json_decode($influencer_details, true);
        $influencer_details = $influencer_details[0];

        return view('influencer.connections', compact('influencer_details', 'all_tags_profile', 'all_regions_profile', 'all_socials_profile', 'connection'));
    }

    public function add_new_influencer_social(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $social_id = $req->social_id;
        $social_address = $req->social_address;

        $duplicate_check = DB::table('influencer_socials')->where('influencer_id', $influencer_id)->where('social_id', $social_id)->first();

        if ($duplicate_check == null) {
            DB::table('influencer_socials')->insert([
                'influencer_id' => $influencer_id,
                'social_id' => $social_id,
                'social_address' => $social_address
            ]);

            return redirect()->back()->with('status', 'One Connection Added');
        } else
            return redirect()->back()->with('error', 'This Connection Already Exists!');
    }

    public function influencer_notification($id)
    {
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $all_tags_profile = DB::table('tags')->get();
        $all_regions_profile = DB::table('regions')->get();
        $influencer_details = DB::table('influencer')->where('id', $id)->get();
        $influencer_details = json_decode($influencer_details, true);
        $influencer_details = $influencer_details[0];

        return view('influencer.notification', compact('influencer_details', 'all_tags_profile', 'all_regions_profile', 'connection'));
    }

    public function influencer_security($id)
    {
        $all_tags_profile = DB::table('tags')->get();
        $all_regions_profile = DB::table('regions')->get();
        $influencer_details = DB::table('influencer')->where('id', $id)->get();
        $influencer_details = json_decode($influencer_details, true);
        $influencer_details = $influencer_details[0];

        return view('influencer.security', compact('influencer_details', 'all_tags_profile', 'all_regions_profile'));
    }

    public function delete_influencer(Request $req)
    {
        $influencer_id_to_delete = $req->influencer_id_to_delete;
        $delete_influencer = DB::table('influencer')->where('id', $influencer_id_to_delete)->delete();
        
        if($delete_influencer)
        {
            DB::table('campaign_content_custom_price')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('campaign_influencer')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('campaign_influencer')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('influencer_contents')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('influencer_regions')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('influencer_socials')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('influencer_tags')->where('influencer_id', $influencer_id_to_delete)->delete();
            
            DB::table('influencer_wallets')->where('influencer_id', $influencer_id_to_delete)->delete();
        }

        return redirect('/all-influencers')->with('error', 'One Influencer has been deleted!');
    }

    public function edit_influencer_wallet(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $wallet_id = $req->wallet_id;
        $wallet_address = $req->wallet_address;

        DB::table('influencer_wallets')
            ->where('influencer_id', $influencer_id)
            ->where('wallet_id', $wallet_id)
            ->update([
                'wallet_address' => $wallet_address
            ]);

        return redirect('/influencer/billing/' . $influencer_id)->with('status', 'Wallet Updated');
    }

    public function delete_influencer_wallet(Request $req)
    {
        $wallet_id_to_delete = $req->wallet_id_to_delete;
        $influencer_id_to_delete = $req->influencer_id_to_delete;

        DB::table('influencer_wallets')->where('influencer_id', $influencer_id_to_delete)->where('wallet_id', $wallet_id_to_delete)->delete();

        return redirect('/influencer/billing/' . $influencer_id_to_delete)->with('status', 'One Wallet Deleted!');
    }

    public function delete_influencer_social(Request $req)
    {
        $social_id_delete = $req->social_id_delete;
        $influencer_id_to_delete = $req->influencer_id_to_delete;

        DB::table('influencer_socials')->where('influencer_id', $influencer_id_to_delete)->where('social_id', $social_id_delete)->delete();

        return redirect()->back()->with('status', 'One Social Deleted!');
    }

    public function delete_influencer_content(Request $req)
    {
        $content_id_to_delete = $req->content_id_to_delete;
        $influencer_id_to_delete = $req->influencer_id_to_delete;

        DB::table('influencer_contents')->where('influencer_id', $influencer_id_to_delete)->where('content_id', $content_id_to_delete)->delete();

        return redirect()->back()->with('status', 'One Content Deleted!');
    }

    public function influencer_filter(Request $req)
    {
        $name = $req->name;
        $email = $req->email;
        $regions = $req->regions;
        $socials = $req->socials;
        $tags = $req->tags;
        $contents = $req->contents;

        $all_influencers = [];
        $influencer_array = [];
        $influencer_regions_array = [];
        $influencer_tags_array = [];
        $influencer_socials_array = [];
        $influencer_contents_array = [];
        if ($regions) {
            $i = 0;
            foreach ($regions as $region) {
                $influencer_regions = DB::table('influencer_regions')
                    ->select('influencer_id')
                    ->where('region_id', $region)
                    ->get();
            }
            foreach ($influencer_regions as $region) {
                $influencer_regions_array[$i] = $region->influencer_id;
                $i++;
            }
        }

        if ($tags) {
            $i = 0;
            foreach ($tags as $tag) {
                $influencer_tags = DB::table('influencer_tags')
                    ->select('influencer_id')
                    ->where('tag_id', $tag)
                    ->get();
            }
            foreach ($influencer_tags as $tag) {
                $influencer_tags_array[$i] = $tag->influencer_id;
                $i++;
            }
        }

        if ($socials) {
            $i = 0;
            foreach ($socials as $social) {
                $influencer_socials = DB::table('influencer_socials')
                    ->select('influencer_id')
                    ->where('social_id', $social)
                    ->get();
            }
            foreach ($influencer_socials as $social) {
                $influencer_socials_array[$i] = $social->influencer_id;
                $i++;
            }
        }

        if ($contents) {
            $i = 0;
            foreach ($contents as $content) {
                $influencer_contents = DB::table('influencer_contents')
                    ->select('influencer_id')
                    ->where('content_id', $content)
                    ->get();
            }
            foreach ($influencer_contents as $content) {
                $influencer_contents_array[$i] = $content->influencer_id;
                $i++;
            }
        }

        $influencer_array1 = array_merge($influencer_regions_array, $influencer_socials_array, $influencer_tags_array, $influencer_contents_array);
        $influencer_array2 = array_unique(array_diff_assoc($influencer_array1, array_unique($influencer_array1)));

        // var_dump($influencer_array1);
        // var_dump($influencer_array2);
        // exit;

        if (sizeof($influencer_array2) == 0)
            $influencer_array = $influencer_array1;
        else
            $influencer_array = $influencer_array2;

        // var_dump($influencer_array);


        $all_influencers = DB::table('influencer')
            ->where('name', 'LIKE', '%' . $name . '%')
            // ->where('email', 'LIKE', '%' . $email . '%')
            ->get();
        // var_dump($all_influencers);


        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);

        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
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
                        <th>Favourite</th>
                        <th>Name</th>
                        <th>TG Handle</th>
                        <th>Region</th>
                        <th>Tags</th>
                        <th>Social</th>
                        <th>Content</th>
                        <th>Total Flowers</th>
                        <!--<th>Status</th>-->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_influencers as $key => $influencer) : ?>
                        <?php $influencer_id = $influencer->id; ?>

                        <?php $twitter_detail = DB::table('influencer_socials')
                            ->where('influencer_id', $influencer_id)
                            ->where('social_id', $twitterId)
                            ->first();
                        $followers_count = null;
                        $twitter_profile_image_url = null;
                        if ($twitter_detail) {
                            $twitter_link = $twitter_detail->social_address;
                            $twitter_arr = explode('/', $twitter_link);
                            $twitter_arr = array_reverse($twitter_arr);
                            $twitter_username = $twitter_arr[0];

                            if ($twitter_username) {
                                $response = $connection->get("users/search", ["q" => $twitter_username]);
                                if (isset($response[0]->id)) {
                                    $twitter_profile_image_url = str_replace('_normal', '', $response[0]->profile_image_url_https);
                                    $followers_count = $response[0]->followers_count;
                                }
                            }
                        }
                        ?>

                        <?php if ($followers_count >= $email) : ?>
                            <?php if ($regions || $tags || $socials || $contents) : ?>
                                <?php if (in_array($influencer_id, $influencer_array)) : ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="check1" class="form-check-input">
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($influencer->is_favourite == 1) : ?>
                                                <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'" style="color: red;"></i>
                                            <?php elseif ($influencer->is_favourite == 0) : ?>
                                                <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'"></i>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <a target="_blank" onclick="window.location.href='<?php echo url("influencer-profile/" . $influencer_id) ?>'">
                                                <?php if ($twitter_profile_image_url != null) { ?>
                                                    <img src="<?php echo $twitter_profile_image_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                                <?php } else { ?>
                                                    <img src="<?php echo asset('images/profile.png'); ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                                <?php } ?>
                                                <span class="fw-bold text-light"><?php echo $influencer->name; ?></span>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="<?php echo $influencer->telegram; ?>">Telegram</i></a>
                                        </td>
                                        <td class="">
                                            <?php
                                            $all_regions = DB::table('influencer_regions')
                                                ->where('influencer_id', $influencer_id)
                                                ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')->get();
                                            foreach ($all_regions as $key => $region) : ?>
                                                <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $region->region; ?></span>
                                            <?php endforeach ?>
                                        </td>
                                        <td class="">
                                            <?php
                                            $all_tags = DB::table('influencer_tags')
                                                ->where('influencer_id', $influencer_id)
                                                ->join('tags', 'influencer_tags.tag_id', '=', 'tags.id')
                                                ->get();
                                            foreach ($all_tags as $key => $tag) : ?>
                                                <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $tag->tag; ?></span>
                                            <?php endforeach ?>
                                        </td>
                                        <td class="">
                                            <?php
                                            $all_socials = DB::table('influencer_socials')
                                                ->where('influencer_id', $influencer_id)
                                                ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                                ->get();

                                            foreach ($all_socials as $key => $social) : ?>
                                                <a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="<?php echo $social->social_address; ?>"><?php echo $social->social; ?></a>
                                            <?php endforeach ?>
                                        </td>
                                        <td class="">
                                            <?php
                                            $all_contents = DB::table('influencer_contents')
                                                ->where('influencer_id', $influencer_id)
                                                ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                ->get();
                                            foreach ($all_contents as $key => $content) : ?>
                                                <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $content->short_name . ' - ' . $content->price; ?></span>
                                            <?php endforeach ?>
                                        </td>
                                        <td>
                                            <h5><?php echo $followers_count; ?></h5>
                                        </td>
                                        <!--<td><span class="badge rounded-pill badge-light-primary me-1">Active</span></td>-->
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a type="button" class="dropdown-item" onclick="quickEdit(<?php echo $influencer->id; ?>)">
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
                            <?php else : ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="" id="check1" class="form-check-input">
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($influencer->is_favourite == 1) : ?>
                                            <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'" style="color: red;"></i>
                                        <?php elseif ($influencer->is_favourite == 0) : ?>
                                            <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'"></i>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a target="_blank" onclick="window.location.href='<?php echo url("influencer-profile/" . $influencer_id) ?>'">
                                            <?php if ($twitter_profile_image_url != null) { ?>
                                                <img src="<?php echo $twitter_profile_image_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                            <?php } else { ?>
                                                <img src="<?php echo asset('images/profile.png'); ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                            <?php } ?>
                                            <span class="fw-bold text-light"><?php echo $influencer->name; ?></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="<?php echo $influencer->telegram; ?>">Telegram</i></a>
                                    </td>
                                    <td class="">
                                        <?php
                                        $all_regions = DB::table('influencer_regions')
                                            ->where('influencer_id', $influencer_id)
                                            ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')->get();
                                        foreach ($all_regions as $key => $region) : ?>
                                            <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $region->region; ?></span>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="">
                                        <?php
                                        $all_tags = DB::table('influencer_tags')
                                            ->where('influencer_id', $influencer_id)
                                            ->join('tags', 'influencer_tags.tag_id', '=', 'tags.id')
                                            ->get();
                                        foreach ($all_tags as $key => $tag) : ?>
                                            <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $tag->tag; ?></span>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="">
                                        <?php
                                        $all_socials = DB::table('influencer_socials')
                                            ->where('influencer_id', $influencer_id)
                                            ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                            ->get();

                                        foreach ($all_socials as $key => $social) : ?>
                                            <a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="<?php echo $social->social_address; ?>"><?php echo $social->social; ?></a>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="">
                                        <?php
                                        $all_contents = DB::table('influencer_contents')
                                            ->where('influencer_id', $influencer_id)
                                            ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                            ->get();
                                        foreach ($all_contents as $key => $content) : ?>
                                            <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $content->short_name . ' - ' . $content->price; ?></span>
                                        <?php endforeach ?>
                                    </td>
                                    <td>
                                        <h5><?php echo $followers_count; ?></h5>
                                    </td>

                                    <!--<td><span class="badge rounded-pill badge-light-primary me-1">Active</span></td>-->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a type="button" class="dropdown-item" onclick="quickEdit(<?php echo $influencer->id; ?>)">
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
                        <th>Favourite</th>
                        <th>Name</th>
                        <th>TG Handle</th>
                        <th>Region</th>
                        <th>Tags</th>
                        <th>Social</th>
                        <th>Content</th>
                        <th>Total Flowers</th>
                        <!--<th>Status</th>-->
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!--All Influencer Table ends here-->
    <?php
    }

    public function edit_influencer_content(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $content_id = $req->content_id;
        $content_price = $req->content_price;

        $query = DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)
            ->update([
                'price' => $content_price
            ]);

        if ($query)
            return redirect()->back()->with('status', 'One Content Price Updated!');
    }

    public function edit_influencer_social(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $social_id = $req->social_id;
        $social_address = $req->social_address;

        $query = DB::table('influencer_socials')->where('influencer_id', $influencer_id)->where('social_id', $social_id)
            ->update([
                'social_address' => $social_address
            ]);

        if ($query)
            return redirect()->back()->with('status', 'One Social Address Updated!');
    }

    public function quick_edit_update(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $regions = $req->regions;
        $tags = $req->tags;
        $content_ids = $req->content_ids;
        $prices = $req->prices;
        $social_ids = $req->social_ids;
        $urls = $req->urls;

        if ($regions) {
            DB::table('influencer_regions')->where('influencer_id', $influencer_id)->delete();
            foreach ($regions as $region) {
                DB::table('influencer_regions')->insert([
                    'influencer_id' => $influencer_id,
                    'region_id' => $region
                ]);
            }
        }

        if ($tags) {
            DB::table('influencer_tags')->where('influencer_id', $influencer_id)->delete();
            foreach ($tags as $tag) {
                DB::table('influencer_tags')->insert([
                    'influencer_id' => $influencer_id,
                    'tag_id' => $tag
                ]);
            }
        }

        if ($content_ids && $prices) {
            foreach ($content_ids as $key => $id) {
                DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $id)
                    ->update([
                        'price' => $prices[$key]
                    ]);
            }
        }

        if ($social_ids && $urls) {
            foreach ($social_ids as $key => $id) {
                DB::table('influencer_socials')->where('influencer_id', $influencer_id)->where('social_id', $id)
                    ->update([
                        'social_address' => $urls[$key]
                    ]);
            }
        }

        return redirect()->back()->with('status', 'One Influencer Updated!');
    }
    public function quick_edit(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $influencer_details = DB::table('influencer')->where('id', $influencer_id)->first();

        $all_regions = DB::table('regions')->get();
        $influencer_regions = DB::table('influencer_regions')->where('influencer_id', $influencer_id)->get();
        $region_array = [];
        foreach ($influencer_regions as $region_data) {
            $region_array[] = $region_data->region_id;
        }

        $all_tags = DB::table('tags')->get();
        $influencer_tags = DB::table('influencer_tags')->where('influencer_id', $influencer_id)->get();
        $tag_array = [];
        foreach ($influencer_tags as $tag_data) {
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
                        <h1 class="mb-1">Edit Influencer Information</h1>
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return true" method="POST" action="<?php echo route('quick_edit_update'); ?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="influencer_id" value="<?php echo $influencer_id; ?>">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserFirstName" style="font-size: 15px;"><b>Name</b></label>
                            <span class="form-control"><?php echo $influencer_details->name; ?></span>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditUserName" style="font-size: 15px;"><b>Email</b></label>
                            <span class="form-control"><?php echo $influencer_details->email; ?></span>
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditkol" style="font-size: 15px;"><b>Regions</b></label><br>
                            <?php foreach ($all_regions as $region) : ?>
                                <?php if (in_array($region->id, $region_array)) : ?>
                                    <input class="form-check-input" type="checkbox" name="regions[]" value="<?php echo $region->id; ?>" id="flexCheckDefault" checked> <label class="form-label"> <?php echo $region->region; ?></label>
                                <?php else : ?>
                                    <input class="form-check-input" type="checkbox" name="regions[]" value="<?php echo $region->id; ?>" id="flexCheckDefault"> <label class="form-label"> <?php echo $region->region; ?></label>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditkol" style="font-size: 15px;"><b>Tags</b></label><br>
                            <?php foreach ($all_tags as $tag) : ?>
                                <?php if (in_array($tag->id, $tag_array)) : ?>
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $tag->id; ?>" id="flexCheckDefault" checked style="padding: 5px;"> <label class="form-label"> <?php echo $tag->tag; ?></label>
                                <?php else : ?>
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="<?php echo $tag->id; ?>" id="flexCheckDefault" style="padding: 5px;"> <label class="form-label"> <?php echo $tag->tag; ?></label>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditkol" style="font-size: 15px;"><b>Contents</b></label><br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Content</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $all_contents = DB::table('influencer_contents')
                                        ->where('influencer_id', $influencer_id)
                                        ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                        ->get();
                                    ?>

                                    <?php foreach ($all_contents as $key => $content) : ?>
                                        <tr>
                                            <td>
                                                <span class="fw-bold"><?php echo $content->short_name; ?></span>
                                                <input type="hidden" name="content_ids[]" value="<?php echo $content->id; ?>" />
                                            </td>
                                            <td><input class="price-change" name="prices[]" value="<?php echo $content->price; ?>"></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="modalEditkol" style="font-size: 15px;"><b>Socials</b></label><br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $all_socials = DB::table('influencer_socials')
                                        ->where('influencer_id', $influencer_id)
                                        ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                        ->get();
                                    ?>

                                    <?php foreach ($all_socials as $key => $social) : ?>
                                        <tr>
                                            <td>
                                                <span class="fw-bold"><?php echo $social->social; ?></span>
                                                <input type="hidden" name="social_ids[]" value="<?php echo $social->id; ?>" />
                                            </td>
                                            <td><input class="form-control" name="urls[]" value="<?php echo $social->social_address; ?>"></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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
    
    public function packageSelectedInfluencer(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $influencer = DB::table('influencer')->where('id', $influencer_id)->first();
        ?>
            
        <tr class="trt-<?php echo $influencer_id; ?> inf-row">
            <td>
                <div class="form-check">
                    <input type="checkbox" name="influencer_id[]" value="<?php echo $influencer_id; ?>" id="" class="form-check-input" onclick="removethis(<?php echo $influencer_id; ?>)" checked>
                </div>
            </td>
            <td>
                <a href="#">
                    <?php if($influencer->dp_url != null){ ?>
                        <img src="<?php echo $influencer->dp_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
                    <?php } else { ?>
                        <img src="<?php echo asset('images/profile.png'); ?>" class="me-75" height="50" width="50" alt="Not Found" />
                    <?php } ?>
                    <span class="fw-bold text-light"><?php echo $influencer->name; ?></span>
                </a>
            </td>
            <td>
                <?php
                $all_contents = DB::table('influencer_contents')
                    ->where('influencer_id', $influencer_id)
                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                    ->get();
                foreach($all_contents as $key=>$content): ?>
                    <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $content->short_name; ?></span>
                <?php endforeach ?>
            </td>
        </tr>
    <?php
    }
}
