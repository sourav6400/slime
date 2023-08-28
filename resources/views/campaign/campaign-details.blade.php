@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    
    <div class="content-body">
        <!-- Select2 Start  -->
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('approve_campaign2') }}" method="POST">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12 col-md-6">
                                @if($campaign->status == 'Ongoing' || $campaign == 'Clossed')
                                <a href="{{ url('add-campaign-info/'.$campaign->id) }}" class="btn btn-lg btn-info" style="margin-bottom: 10px;">Add Info</a>
                                @endif
                                <h4 class="card-title">Campaign Name : <span class="text-success">{{ $campaign->campaign_name }}</span></h4>
                            </div>
                            <div class="col-12 col-md-6 text-md-end mt-1">
                                <p>Starting Date : <span class="text-success">{{ $campaign->starting_date }}</span></p>
                                <p>Ending Date : <span class="text-success">{{ $campaign->ending_date }}</span></p>
                            </div>
                        </div>
                        <hr>
                        @php
                        $client = DB::table('clients')->where('id', $campaign->client_id)->first();
                        @endphp
                        <div class="card-body">
                            <h4 class="pb-1">Client Name : <span class="text-warning">{{ $client->name }}</span></h4>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Budget:</span>
                                                <span>{{ $campaign->budget }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Paid Amount:</span>
                                                <span>N/A</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Budget Remaining:</span>
                                                <span>N/A</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Region:</span>
                                                <span>Asia</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Campaign Goal:</span>
                                                <span>Reach {{ $campaign->total_reach }} users</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Main call to Action:</span>
                                                <span><a href="">google/meet.com</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 pt-2">
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <h4>Client Brif</h4>
                                        <p>{{ $campaign->client_brief }}</p>
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Asset:</span>
                                                <!--<a href=""><img src="images/drive.png" alt="" style="height: 20px; width: 20px;"></a>-->
                                                <p>{{ $campaign->asset }}</p>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Client Brief Link:</span>
                                                <a href="">#</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <h4>Influencer</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Content</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $campaign_id = $campaign->id;
                                                    $influencers = DB::table('campaign_influencer')->where('campaign_id', $campaign_id)->get();
                                                        
                                                    $total_price = 0;
                                                    @endphp
                                                    
                                                    @foreach($influencers as $key=>$influencer)
                                                    
                                                        @php $influencer_detail = DB::table('influencer')->where('id', $influencer->influencer_id)->first(); @endphp
                                                        
                                                        @if($influencer_detail)
                                                            @php
                                                            $all_contents = DB::table('influencer_contents')
                                                                ->where('influencer_id', $influencer_detail->id)
                                                                ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                                ->get();
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <a href="#">
                                                                        @if($influencer_detail->dp_url != null)
                                                                            <img src="{{ $influencer_detail->dp_url }}" class="me-75" height="40" width="40" alt="Not Found" />
                                                                        @else
                                                                            <img src="{{ asset('images/profile.png') }}" class="me-75" height="40" width="40" alt="Not Found" />
                                                                        @endif
                                                                        <span class="fw-bold text-light">{{ $influencer_detail->name }}</span>
                                                                    </a>
                                                                </td>
                                                                <td class="">
                                                                    @if($all_contents)
                                                                    @foreach($all_contents as $key=>$content)
                                                                    <span
                                                                        class="badge rounded-pill badge-light-info link-bottom">{{$content->short_name}}-
                                                                        {{ $content->price }}</span>
                                                                        @php $total_price = $total_price + $content->price; @endphp
                                                                    @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th>
                                                            Total Price: {{ $total_price }}
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                @php
                                $best_post = DB::table('campaign_best_post')->where('campaign_id', $campaign->id)->first();
                                @endphp
                                
                                @if($best_post)
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <h4>Best Post</h4>
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Screen Shot:</span>
                                                <a href="{{ $best_post->best_post_url }}" target="_blank">
                                                    <img src="{{ asset('campaign_best_post/'.$best_post->best_post_file) }}" alt="" style="width: 30rem;">
                                                </a>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">URL:</span>
                                                <a href="{{ $best_post->best_post_url }}">{{ $best_post->best_post_url }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                </div>
                                @endif
                                
                                @php
                                $articles = DB::table('campaign_featured_article')->where('campaign_id', $campaign->id)->get();
                                @endphp
                                
                                @if($articles)
                                    @foreach($articles as $key=>$article)
                                        <div class="col-12 col-md-6">
                                            <div class="custom-bg">
                                                <h4>Featured Article</h4>
                                                <ul class="list-unstyled">
                                                    <li class="mb-75">
                                                        <span class="fw-bolder me-25">Article Image:</span>
                                                        <a href="{{ $article->article_url }}" target="_blank">
                                                            <img src="{{ asset('campaign_featured_article/'.$article->article_img) }}" alt="" style="width: 30rem;">
                                                        </a>
                                                    </li>
                                                    <li class="mb-75">
                                                        <span class="fw-bolder me-25">URL:</span>
                                                        <a href="{{ $article->article_url }}">{{ $article->article_url }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                
                                @php
                                $videos = DB::table('campaign_featured_video')->where('campaign_id', $campaign->id)->get();
                                @endphp
                                
                                @if($videos)
                                    @foreach($videos as $key=>$video)
                                        <div class="col-12 col-md-6">
                                            <div class="custom-bg">
                                                <h4>Featured Video</h4>
                                                <ul class="list-unstyled">
                                                    <li class="mb-75">
                                                        <span class="fw-bolder me-25">Video:</span>
                                                        <a href="{{ $video->video_url }}" target="_blank">
                                                            <video width="420" height="240" controls>
                                                                <source src="{{ asset('campaign_featured_video/'.$video->video_file) }}" type="video/mp4">
                                                            </video>
                                                        </a>
                                                    </li>
                                                    <li class="mb-75">
                                                        <span class="fw-bolder me-25">URL:</span>
                                                        <a href="{{ $video->video_url }}">{{ $video->video_url }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                
                                
                            </div>
                            @if($campaign->status == 'Ongoing')
                                <input type="hidden" value="Clossed" name="set_status" />
                                <input type="submit" class="btn btn-primary mt-1" value="Close Campaign" />
                            @endif
                            @if(Auth::user()->role == 'Client' && $campaign->status == 'Approved')
                                <input type="hidden" value="Ongoing" name="set_status" />
                                <input type="submit" class="btn btn-primary mt-1" value="Accept Campaign" />
                            @elseif(Auth::user()->role != 'Client' && $campaign->status == 'Pending')
                                <input type="hidden" value="Approved" name="set_status" />
                                <input type="submit" class="btn btn-primary mt-1" value="Approve Campaign" />
                            @elseif($campaign->status == 'Draft')
                                <input type="hidden" value="add_campaign_from_draft" name="set_status" />
                                <input type="submit" class="btn btn-primary mt-1" value="Add Campaign & Send To Client" />
                            @endif
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Select2 End -->
    </div>
</div>
<!-- END: Content-->

@endsection