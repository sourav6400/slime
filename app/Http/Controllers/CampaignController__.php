<?php

namespace App\Http\Controllers;

require 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CampaignController extends Controller
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
        define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
        define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
        
        define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
        define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');
        
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $connection->setTimeouts(10, 100);
        
        if(Auth::user()->role == 'Client')
            $clients = DB::table('clients')->where('user_id', Auth::user()->id)->get();
        else
            $clients = DB::table('clients')->get();
        $all_influencers = DB::table('influencer')->get();
        $all_tags = DB::table('tags')->get();
        $all_tags_profile = $all_tags;
        $all_regions = DB::table('regions')->get();
        $all_regions_profile = $all_regions;
        $all_socials = DB::table('socials')->get();
        $all_contents = DB::table('contents')->get();
        $contents = $all_contents;
        
        $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
        $youtubeId = DB::table('socials')->where('social', 'Youtube')->first()->id;
        $youtube_api_key = env('YOUTUBE_API_KEY');
        
        DB::table('campaign_influencer')->where('campaign_id', NULL)->delete();
        DB::table('campaign_content_custom_price')->where('campaign_id', NULL)->delete();
        
        return view('campaign.add-new', compact('clients', 'all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'contents', 'all_tags_profile', 'all_regions_profile', 'connection', 'twitterId', 'youtubeId', 'youtube_api_key'));
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
        if($regions)
        {
            $i = 0;
            foreach($regions as $region){
            $influencer_regions = DB::table('influencer_regions')
                ->select('influencer_id')
                ->where('region_id', $region)
                ->get();
            }
            foreach($influencer_regions as $region)
            {
                $influencer_regions_array[$i] = $region->influencer_id;
                $i++;
            }
        }
        
        if($tags)
        {
            $i = 0;
            foreach($tags as $tag){
                $influencer_tags = DB::table('influencer_tags')
                    ->select('influencer_id')
                    ->where('tag_id', $tag)
                    ->get();
            }
            foreach($influencer_tags as $tag)
            {
                $influencer_tags_array[$i] = $tag->influencer_id;
                $i++;
            }
        }
        
        if($socials)
        {
            $i = 0;
            foreach($socials as $social){
                $influencer_socials = DB::table('influencer_socials')
                    ->select('influencer_id')
                    ->where('social_id', $social)
                    ->get();
            }
            foreach($influencer_socials as $social)
            {
                $influencer_socials_array[$i] = $social->influencer_id;
                $i++;
            }
        }
        
        if($contents)
        {
            $i = 0;
            foreach($contents as $content){
                $influencer_contents = DB::table('influencer_contents')
                    ->select('influencer_id')
                    ->where('content_id', $content)
                    ->get();
            }
            foreach($influencer_contents as $content)
            {
                $influencer_contents_array[$i] = $content->influencer_id;
                $i++;
            }
        }
        
        $influencer_array1 = array_merge($influencer_regions_array, $influencer_socials_array, $influencer_tags_array, $influencer_contents_array);
        $influencer_array2 = array_unique(array_diff_assoc($influencer_array1, array_unique($influencer_array1)));
        
        // var_dump($influencer_array1);
        // var_dump($influencer_array2);
        // exit;
        
        if(sizeof($influencer_array2)==0)
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
                        <th>Name</th>
                        <th>Region</th>
                        <th>Tags</th>
                        <th>Social</th>
                        <th>Content</th>
                        <th>Total Flowers</th>
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
                        if($twitter_detail){
                            $twitter_link= $twitter_detail->social_address;
                            $twitter_arr = explode('/', $twitter_link);
                            $twitter_arr = array_reverse($twitter_arr);
                            $twitter_username = $twitter_arr[0];
                                                
                            if($twitter_username){
                                $response = $connection->get("users/search", ["q" => $twitter_username ]);
                                // if(isset($response[0]->id)){
                                //     $twitter_profile_image_url = str_replace('_normal','',$response[0]->profile_image_url_https);
                                //     $followers_count = $response[0]->followers_count;
                                // }
                            }
                        }
                        ?>
                        
                        <?php if($followers_count >= $email): ?>
                        <?php if($regions || $tags || $socials || $contents): ?>
                            <?php if(in_array($influencer_id, $influencer_array)): ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <!--<input type="checkbox" data-bs-toggle="modal" data-bs-target="#addPermissionModal" name="" id="check1" class="form-check-input">-->
                                        <input type="checkbox" onclick="contentModal(<?php echo $influencer_id; ?>)" name="" id="check1" class="form-check-input">
                                        <!--<input type="checkbox" data-bs-toggle="modal" data-bs-target="#testModal-<?php //echo $influencer_id; ?>" name="" id="check1" class="form-check-input">-->
                                    </div>
                                </td>
                                <td>
                                    <a target="_blank" onclick="window.location.href='<?php echo url("influencer-profile/" . $influencer_id) ?>'">
                                        <?php if($twitter_profile_image_url != null){ ?>
                                            <img src="<?php echo $twitter_profile_image_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                        <?php } else { ?>
                                            <img src="<?php echo asset('images/profile.png'); ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                        <?php } ?>
                                        <span class="fw-bold text-light"><?php echo $influencer->name; ?></span>
                                    </a>
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
                            </tr>
                            <?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <!--<input type="checkbox" data-bs-toggle="modal" data-bs-target="#addPermissionModal" name="" id="check1" class="form-check-input">-->
                                        <input type="checkbox" onclick="contentModal(<?php echo $influencer_id; ?>)" name="" id="check1" class="form-check-input">
                                        <!--<input type="checkbox" data-bs-toggle="modal" data-bs-target="#testModal-<?php //echo $influencer_id; ?>" name="" id="check1" class="form-check-input">-->
                                    </div>
                                </td>
                                <td>
                                    <a target="_blank" onclick="window.location.href='<?php echo url("influencer-profile/" . $influencer_id) ?>'">
                                        <?php if($twitter_profile_image_url != null){ ?>
                                            <img src="<?php echo $twitter_profile_image_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                        <?php } else { ?>
                                            <img src="<?php echo asset('images/profile.png'); ?>" class="me-75" height="50" width="50" alt="Not Found" />
                                        <?php } ?>
                                        <span class="fw-bold text-light"><?php echo $influencer->name; ?></span>
                                    </a>
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
                        <th>Name</th>
                        <th>Region</th>
                        <th>Tags</th>
                        <th>Social</th>
                        <th>Content</th>
                        <th>Total Flowers</th>
                    </tr>
                </tfoot>
            </table>
            
            <div class="col-12 my-2">
                <button type="submit" class="btn btn-primary mb-1 csm-25">Create & Sent to Client</button>
                <a href="#" class="btn btn-primary ml-2 top-12">Create draft</a>
            </div>
        </div>
        <!--All Influencer Table ends here-->
    <?php
    }
    public function content_modal(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $influencer_contents = DB::table('influencer_contents')->where('influencer_id', $influencer_id)->get();
    ?>
        <form id="addPermissionForm" class="row" onsubmit="return true" novalidate="novalidate">
            <div class="row">
                <div class="col-12">
                    <div class="form-control-repeater">
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    <form action="#" class="invoice-repeater">
                                        <div class="invoice-repeater">
                                            <div data-repeater-list="invoice">
                                                <div data-repeater-item>
                                                    <div class="row d-flex align-items-end">
                                                        <?php foreach($influencer_contents as $key=>$content): ?>
                                                            <?php
                                                            $content_id = $content->content_id;
                                                            $contentDetail = DB::table('contents')->where('id', $content_id)->first();
                                                            ?>
                                                            <div class="col-5">
                                                                <div class="mb-1">
                                                                    <label class="form-label" for="select-content-name">Content Name</label>
                                                                    <div class="top-25">
                                                                        <input type="text" class="form-control" value="<?php echo $contentDetail->content_name; ?>" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-5">
                                                                <div class="mb-1">
                                                                    <label for="price">Price</label>
                                                                    <div class="top-25">
                                                                        <input type="hidden" class="influencer-<?php echo $content->content_id; ?>" value="<?php echo $influencer_id; ?>" >
                                                                        <input type="number" class="price-change price-<?php echo $content->content_id; ?>" value="<?php echo $content->price; ?>" id="price">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <div class="mb-1">
                                                                    <button class="btn btn-outline-success text-nowrap" type="button" onclick="update_content_price(<?php echo $content->content_id; ?>)">
                                                                    Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="reset" onclick="test(<?php echo $influencer_id; ?>)" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Add</button>
                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">Discard</button>
            </div>
        </form>
        <?php
    }
    
    public function influencer_campaign(Request $req)
    {
        $influencer_id = $req->influencer_id;
        
        $query = DB::table('campaign_influencer')->insert(['influencer_id' => $influencer_id]);
        
        if($query)
        {
            define('CONSUMER_KEY', 'yyB3p5IZBgViP9wX4RQYBBIpn');
            define('CONSUMER_SECRET', 'Jc053XxysMrkRFK5FhOjGkX2hKxhfpeGfiY46jxqZ1W4iyLwNn');
            define('ACCESS_TOKEN', '4036453097-Brn1Rw4PnKyyVwdRLbOEmlx2XPQB3V0RnAcBsXu');
            define('ACCESS_TOKEN_SECRET', 'N5rIfUvLXeh0NPv5aalEbPF3qTVA6Sz3ZpovgyJxM3Vhm');
            
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
            $connection->setTimeouts(10, 100);
            
            $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
            
            $twitter_detail = DB::table('influencer_socials')
                ->where('influencer_id', $influencer_id)
                ->where('social_id', $twitterId)
                ->first();
            $twitter_profile_image_url = null;
            if($twitter_detail){
                $twitter_link= $twitter_detail->social_address;
                $twitter_arr = explode('/', $twitter_link);
                $twitter_arr = array_reverse($twitter_arr);
                $twitter_username = $twitter_arr[0];
                                                    
                if($twitter_username){
                    $response = $connection->get("users/search", ["q" => $twitter_username ]);
                    // if(isset($response[0]->id)){
                    //     $twitter_profile_image_url = str_replace('_normal','',$response[0]->profile_image_url_https);
                    // }
                }
            }
            $influencer = DB::table('influencer')->where('id', $influencer_id)->first();
            ?>
            
            <tr class="trt-<?php echo $influencer_id; ?>">
                <td>
                    <div class="form-check">
                        <input type="checkbox" name="" id="" class="form-check-input" onclick="removethis(<?php echo $influencer_id; ?>)" checked>
                    </div>
                </td>
                <td>
                    <a href="#">
                        <?php if($twitter_profile_image_url != null){ ?>
                            <img src="<?php echo $twitter_profile_image_url; ?>" class="me-75" height="50" width="50" alt="Not Found" />
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
                    $total_price = 0;
                    foreach($all_contents as $key=>$content): $total_price = $total_price + $content->price; ?>
                        <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $content->short_name.' - '.$content->price; ?></span>
                    <?php endforeach ?>
                </td>
                <td>
                    <span class="badge rounded-pill badge-light-info link-bottom"><?php echo $total_price; ?></span>
                </td>
            </tr>
        <?php
        }
    }
    
    public function remove_influencer(Request $req)
    {
        $influencer_id = $req->influencer_id;
        DB::table('campaign_influencer')->where('influencer_id', $influencer_id)->where('campaign_id', NULL)->delete();
        DB::table('campaign_content_custom_price')->where('influencer_id', $influencer_id)->where('campaign_id', NULL)->delete();
    }
    
    public function campaign_content_custom_price(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $content_id = $req->content_id;
        $price = $req->price;
        
        DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)->update([
            'price' => $price
        ]);
        
        // DB::table('campaign_content_custom_price')->insert([
        //     'influencer_id' => $influencer_id,
        //     'content_id' => $content_id,
        //     'price' => $price
        // ]);
    }
    public function add_new_campaign(Request $req)
    {
        $campaign_name = $req->campaign_name;
        $strtdate = $req->strtdate;
        $enddate = $req->enddate;
        $client_id = $req->client_id;
        $budget = $req->budget;
        $kpi = $req->kpi;
        $asset = $req->asset;
        $brief = $req->brief;
        $description = $req->description;
        
        // regions
        DB::table('campaigns')->insert([
            'campaign_name' => $campaign_name,
            'starting_date' => $strtdate,
            'ending_date' => $enddate,
            'client_id' => $client_id,
            'budget' => $budget,
            'kpi' => $kpi,
            'asset' => $asset,
            'client_brief' => $brief,
            'description' => $description,
            'status' => 'Pending',
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        $campaign_id = DB::getPdo()->lastInsertId();
        if($campaign_id){
            
            $update1 = DB::table('campaign_content_custom_price')->where('campaign_id', NULL)->update(['campaign_id' => $campaign_id]);
            $update2 = DB::table('campaign_influencer')->where('campaign_id', NULL)->update(['campaign_id' => $campaign_id]);
            
            if($update2)
                return redirect()->back()->with('status', 'One new Campaign added!');   
        }
    }
    public function all_campaign()
    {
        if(Auth::user()->role == 'Client'){
            $client_id = DB::table('clients')->where('user_id', Auth::user()->id)->first()->id;
            $campaigns = DB::table('campaigns')->where('client_id', $client_id)->get();
        }else{
            $campaigns = DB::table('campaigns')->get();
        }
        return view('campaign.all-campaigns', compact('campaigns'));
    }
    
    public function ongoing_campaigns()
    {
        if(Auth::user()->role == 'Client'){
            $client_id = DB::table('clients')->where('user_id', Auth::user()->id)->first()->id;
            $campaigns = DB::table('campaigns')->where('client_id', $client_id)->where('status', 'Ongoing')->get();
        }else{
            $campaigns = DB::table('campaigns')->where('status', 'Ongoing')->get();
        }
        return view('campaign.ongoing-campaigns', compact('campaigns'));
    }
    
    public function approve_campaign()
    {
        return view('campaign.approve-campaign');
    }
    
    public function approve_campaign2(Request $req)
    {
        $campaign_id = $req->campaign_id;
        $status = $req->set_status;
        $query = DB::table('campaigns')->where('id', $campaign_id)->update(['status' => $status]);
        
        if($query)
            return redirect()->back()->with('status', 'Campaign Approved!'); 
    }
    
    public function campaign_details($id)
    {
        $campaign = DB::table('campaigns')->where('id', $id)->first();
        return view('campaign.campaign-details', compact('campaign'));
    }
}