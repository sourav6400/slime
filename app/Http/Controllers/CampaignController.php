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
    
    public function appendAtRight(Request $req)
    {
        $influencer_id = $req->influencer_id;
        
        // $query = DB::table('campaign_influencer')->insert(['influencer_id' => $influencer_id]);
        
        // if($query)
        // {
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
        // }
    }
    
    public function draft_camp_influencer(Request $req)
    {
        $campaign_id = $req->campaign_id;
        $campaigns = DB::table('campaign_influencer')->where(['campaign_id' => $campaign_id])->get();
        
        if($campaigns)
        {
            foreach($campaigns as $key=>$campaign)
            {
                $influencer_id = $campaign->influencer_id;
                $influencer = DB::table('influencer')->where('id', $influencer_id)->first();
                if($influencer)
                {
                ?>
                    <tr class="trt-<?php echo $influencer_id; ?>">
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
        }
    }
    
    public function new_camp_s1(Request $req)
    {
        $influencers = $req->influencer_id;
        $create_new_campaign_val = $req->create_new_campaign_val;
        $create_new_template_val = $req->create_new_template_val;
        
        if($create_new_campaign_val == 'Create New Campaign' && $create_new_template_val == null)
        {
            $clients = DB::table('clients')->get();
            $all_tags = DB::table('tags')->get();
            $all_tags_profile = $all_tags;
            $all_regions = DB::table('regions')->get();
            $all_regions_profile = $all_regions;
            $all_socials = DB::table('socials')->get();
            $all_contents = DB::table('contents')->get();
            $contents = $all_contents;
            
            // print_r($influencers);
            return view('campaign.create-new', compact('influencers', 'clients', 'all_tags', 'all_regions', 'all_socials', 'all_contents'));
        }
        elseif($create_new_template_val == 'Create New Template' && $create_new_campaign_val == null)
        {
            $template_name = $req->template_name;
            $clients_budget = $req->clients_budget;
            $profit_margin = $req->profit_margin;
            $query = DB::table('influencer_template')->insert([
                'template_name' => $template_name,
                'influencers' => json_encode($influencers),
                'clients_budget' => $clients_budget,
                'profit_margin' => $profit_margin
            ]);
            
            $template_id_id = DB::getPdo()->lastInsertId();
            
            if($template_id_id)
            {
                return redirect('/influencer-template')->with('status', 'New Influencer Template has been added.');
            }
            
        }
    }
    
    public function remove_influencer(Request $req)
    {
        $influencer_id = $req->influencer_id;
        DB::table('campaign_influencer')->where('influencer_id', $influencer_id)->where('campaign_id', NULL)->delete();
        DB::table('campaign_content_custom_price')->where('influencer_id', $influencer_id)->where('campaign_id', NULL)->delete();
    }
    
    public function content_custom_price(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $content_id = $req->content_id;
        $price = $req->price;
        $quantity = $req->quantity;
        $template_id = $req->template_id;
        $clients_budget = $req->clients_budget;
        $total_expense = $req->total_expense;
        
        if($price == null || $quantity == null)
            return 'Price & Quantity both are required to update.';
        
        // $qry = DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)->first();
        
        $qry = DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)
            ->update([
                'price' => $price
        ]);
        
        if($qry)
        {
            return 'Base price updated.';
        }
        
        // if($qry){
        //     $search = DB::table('ifluencer_template_content')
        //         ->where('influencer_id', $influencer_id)
        //         ->where('content_id', $content_id)
        //         ->where('template_id', $template_id)
        //         ->first();
                
        //     if($search)
        //     {
        //         $previous_quantity = $search->content_quantity;
        //         $previous_rate_for_this_content = $previous_rate_per_unit*$previous_quantity;
        //         $total_expense_now = ($total_expense - $previous_rate_for_this_content) + ($price * $quantity);
                
        //         if($total_expense_now > $clients_budget)
        //             return 'Total Cost can not be exceeded Clients budget.';
                
        //         else
        //         {
        //             DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)->update(['price' => $price]);
        //             DB::table('ifluencer_template_content')
        //                 ->where('influencer_id', $influencer_id)
        //                 ->where('content_id', $content_id)
        //                 ->where('template_id', $template_id)
        //                 ->update(['content_quantity' => $quantity]);
                        
        //             return 'Content Price & Quantity Updated.';
        //         }
        //     }
                
        //     else
        //     {
        //         $total_expense_now = $total_expense + ($price * $quantity);
            
        //         if($total_expense_now > $clients_budget)
        //             return 'Total Cost can not be exceeded Clients budget.';
                
        //         else{
        //             DB::table('ifluencer_template_content')->insert([
        //                 'influencer_id' => $influencer_id,
        //                 'content_id' => $content_id,
        //                 'template_id' => $template_id,
        //                 'content_quantity' => $quantity
        //             ]);
                    
        //             return 'Content Price & Quantity Updated.';
        //         }
        //     }
        // }
            
        // else
        // {
        //     $total_expense_now = $total_expense + ($price * $quantity);
            
        //     if($total_expense_now > $clients_budget)
        //         return 'Total Cost can not be exceeded Clients budget.';
            
        //     else{
        //         DB::table('influencer_contents')->insert([
        //             'influencer_id' => $influencer_id,
        //             'content_id' => $content_id,
        //             'price' => $price
        //         ]);
                
        //         DB::table('ifluencer_template_content')->insert([
        //             'influencer_id' => $influencer_id,
        //             'content_id' => $content_id,
        //             'template_id' => $template_id,
        //             'content_quantity' => $quantity
        //         ]);
                
        //         return 'Content Price & Quantity Updated.';
        //     }
        // }
    }
    public function campaign_content_custom_price(Request $req)
    {
        $influencer_id = $req->influencer_id;
        $content_id = $req->content_id;
        $price = $req->price;
        
        DB::table('influencer_contents')->where('influencer_id', $influencer_id)->where('content_id', $content_id)->update([
            'price' => $price
        ]);
        
        if(isset($req->quantity) && isset($req->template_id))
        {
            $quantity = $req->quantity;
            $template_id = $req->template_id;
            
            $search = DB::table('ifluencer_template_content')
                ->where('influencer_id', $influencer_id)
                ->where('content_id', $content_id)
                ->where('template_id', $template_id)
                ->first();
                
            if($search)
            {
                DB::table('ifluencer_template_content')
                ->where('influencer_id', $influencer_id)
                ->where('content_id', $content_id)
                ->where('template_id', $template_id)
                ->update([
                    'content_quantity' => $quantity
                ]);
            }
            
            else
            {
                DB::table('ifluencer_template_content')->insert([
                    'influencer_id' => $influencer_id,
                    'content_id' => $content_id,
                    'template_id' => $template_id,
                    'content_quantity' => $quantity
                ]);
            }
        }
        
        // DB::table('campaign_content_custom_price')->insert([
        //     'influencer_id' => $influencer_id,
        //     'content_id' => $content_id,
        //     'price' => $price
        // ]);
    }
    public function add_new_campaign_from_template(Request $req)
    {
        $influencers = $req->influencers;
        $status = 'Pending';
        $campaign_name = $req->campaign_name;
        $strtdate = $req->strtdate;
        $enddate = $req->enddate;
        $client_id = $req->client_id;
        $budget = $req->budget;
        $kpi = $req->kpi;
        $asset = $req->asset;
        $brief = $req->brief;
        $description = $req->description;
        
        // dd($req->post());
        // exit;
        
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
            'status' => $status,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        $campaign_id = DB::getPdo()->lastInsertId();
        if($campaign_id){
            foreach($influencers as $influencer_id)
            {
                DB::table('campaign_influencer')->insert(['campaign_id' => $campaign_id, 'influencer_id' => $influencer_id]);
            }
            
            return redirect('/all-campaigns')->with('status', 'One new Campaign added!');   
        }
    }
    public function create_new_campaign(Request $req)
    {
        $influencers = $req->influencers;
        $camp_status = $req->camp_status;
        if($camp_status == 'Create & Sent to Client')
            $status = 'Pending';
        elseif($camp_status == 'Create Draft')
            $status = 'Draft';
            
        $campaign_name = $req->campaign_name;
        $strtdate = $req->strtdate;
        $enddate = $req->enddate;
        $client_id = $req->client_id;
        $budget = $req->budget;
        $kpi = $req->kpi;
        $asset = $req->asset;
        $brief = $req->brief;
        $description = $req->description;
        
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
            'status' => $status,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        $campaign_id = DB::getPdo()->lastInsertId();
        if($campaign_id){
            foreach($influencers as $influencer_id)
            {
                DB::table('campaign_influencer')->insert(['campaign_id' => $campaign_id, 'influencer_id' => $influencer_id]);
            }
            
            return redirect('/all-campaigns')->with('status', 'One new Campaign added!');   
        }
    }
    public function add_new_campaign(Request $req)
    {
        $submit_type = $req->submit_type;
        if($submit_type == 'create')
            $status = 'Pending';
        if($submit_type == 'draft')
            $status = 'Draft';
            
        $campaign_name = $req->campaign_name;
        $strtdate = $req->strtdate;
        $enddate = $req->enddate;
        $client_id = $req->client_id;
        $budget = $req->budget;
        $kpi = $req->kpi;
        $asset = $req->asset;
        $brief = $req->brief;
        $description = $req->description;
        
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
            'status' => $status,
            'created_at' => now()->format('Y-m-d H:i:s')
        ]);
        
        $campaign_id = DB::getPdo()->lastInsertId();
        if($campaign_id){
            
            $update1 = DB::table('campaign_content_custom_price')->where('campaign_id', NULL)->update(['campaign_id' => $campaign_id]);
            $update2 = DB::table('campaign_influencer')->where('campaign_id', NULL)->update(['campaign_id' => $campaign_id]);
            
            if($update2)
            {
                // return redirect()->back()->with('status', 'One new Campaign added!');
                $campaign = DB::table('campaigns')->where('id', $campaign_id)->first();
                return view('campaign.campaign-details', compact('campaign'));
            }
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
    
    public function draft_campaigns()
    {
        if(Auth::user()->role == 'Client'){
            $client_id = DB::table('clients')->where('user_id', Auth::user()->id)->first()->id;
            $campaigns = DB::table('campaigns')->where('client_id', $client_id)->where('status', 'Draft')->get();
        }else{
            $campaigns = DB::table('campaigns')->where('status', 'Draft')->get();
        }
        return view('campaign.draft-campaigns', compact('campaigns'));
    }
    
    public function approve_campaign()
    {
        return view('campaign.approve-campaign');
    }
    
    public function approve_campaign2(Request $req)
    {
        $campaign_id = $req->campaign_id;
        $status = $req->set_status;
        
        if($status == 'add_campaign_from_draft' || $status == 'duplicate_campaign')
        {
            $clients = DB::table('clients')->get();
            $all_influencers = DB::table('influencer')->get();
            $all_tags = DB::table('tags')->get();
            $all_tags_profile = $all_tags;
            $all_regions = DB::table('regions')->get();
            $all_regions_profile = $all_regions;
            $all_socials = DB::table('socials')->get();
            $all_contents = DB::table('contents')->get();
            $contents = $all_contents;
        
            // $twitterId = DB::table('socials')->where('social', 'Twitter')->first()->id;
            // $youtubeId = DB::table('socials')->where('social', 'Youtube')->first()->id;
            // $youtube_api_key = env('YOUTUBE_API_KEY');
        
            DB::table('campaign_influencer')->where('campaign_id', NULL)->delete();
            DB::table('campaign_content_custom_price')->where('campaign_id', NULL)->delete();
            
            $campaign_details = DB::table('campaigns')->where('id', $campaign_id)->first();
            return view('campaign.campaign-from-draft', compact('campaign_details', 'clients', 'all_influencers', 'all_tags', 'all_regions', 'all_socials', 'all_contents', 'contents', 'all_tags_profile', 'all_regions_profile'));
        }
        else
        {
            $query = DB::table('campaigns')->where('id', $campaign_id)->update(['status' => $status]);
            
            if($query)
                return redirect()->back()->with('status', 'Campaign Approved!');
        }
    }
    
    public function campaign_details($id)
    {
        $campaign = DB::table('campaigns')->where('id', $id)->first();
        return view('campaign.campaign-details', compact('campaign'));
    }
    
    public function add_campaign_info($id)
    {
        $campaign_id = $id;
        return view('campaign.add-campaign-info', compact('campaign_id'));
    }
    
    public function post_campaign_info(Request $req)
    {
        $campaign_id = $req->campaign_id;
        
        $total_reach = $req->total_reach;
        if($total_reach)
        {
            DB::table('campaigns')->where('id', $campaign_id)->update([
                'total_reach' => $total_reach
            ]);
        }
        
        $best_post_url = $req->best_post_url;
        $best_post_file = $req->best_post_file;
        
        if($best_post_file)
        {
            $bestPostImg = 'C'.$campaign_id.'.'.$req->best_post_file->extension();  
            $req->best_post_file->move(public_path('campaign_best_post'), $bestPostImg);
            $search = DB::table('campaign_best_post')->where('campaign_id', $campaign_id)->first();
            
            if($search)
            {
                DB::table('campaign_best_post')->insert([
                    'campaign_id' => $campaign_id,
                    'best_post_url' => $best_post_url,
                    'best_post_file' => $bestPostImg,
                    'created_by' => Auth::user()->id,
                    'created_at' => now()->format('Y-m-d H:i:s')
                ]);
            }
        }
        
        $articles = $req->article;
        
        var_dump($articles);
        exit;
        if($articles)
        {
            $count = DB::table('campaign_featured_article')->where('campaign_id', $campaign_id)->get()->count();
            foreach($articles as $key=>$article)
            {
                $count = $count+1;
                $featuredArticleImg = 'C'.$campaign_id.'S'.$count.'.'.$article['article_img']->extension();  
                $article['article_img']->move(public_path('campaign_featured_article'), $featuredArticleImg);
            
                DB::table('campaign_featured_article')->insert([
                    'campaign_id' => $campaign_id,
                    'article_url' => $article['article_url'],
                    'article_img' => $featuredArticleImg,
                    'created_by' => Auth::user()->id,
                    'created_at' => now()->format('Y-m-d H:i:s')
                ]);
            }
        }
        
        $videos = $req->video;
        if($videos)
        {
            $count = DB::table('campaign_featured_video')->where('campaign_id', $campaign_id)->get()->count();
            foreach($videos as $key=>$video)
            {
                $count = $count+1;
                $featuredVideo = 'C'.$campaign_id.'S'.$count.'.'.$video['featured_video_file']->extension();  
                $video['featured_video_file']->move(public_path('campaign_featured_video'), $featuredVideo);
            
                DB::table('campaign_featured_video')->insert([
                    'campaign_id' => $campaign_id,
                    'video_url' => $video['featured_video_url'],
                    'video_file' => $featuredVideo,
                    'created_by' => Auth::user()->id,
                    'created_at' => now()->format('Y-m-d H:i:s')
                ]);
            }
        }
        
        // return $req->all();
        
        return redirect()->back()->with('status', 'All Data has been saved.');
    }
}