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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-1">Add New Campaign</h4>
                            <div class="div d-none">
                                <a href="#" class="btn btn-primary mb-1">Going to managment view</a>
                                <a href="#" class="btn btn-primary mb-1">Generate Quoatation</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('create_new_campaign') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="campaignname">Campaign Name</label>
                                            <input type="text" id="campaignname" class="form-control"
                                                placeholder="Campaign Name" name="campaign_name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="strdate">Starting Date:</label>
                                            <input type="date" name="strtdate" id="strdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="enddate">Ending Date:</label>
                                            <input type="date" name="enddate" id="enddate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <label class="form-label" for="select5-basic">Select A Client</label>
                                        <select class="select2 form-select" id="select5-basic" name="client_id"
                                            required>
                                            <option value="">--Select One--</option>
                                            @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->email }}
                                                - {{ $client->username }}</span></option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select9-multiple">Select Region</label>
                                        <select class="select2 form-select" id="select9-multiple" multiple>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_regions as $key=>$region)
                                                <option value="{{ $region->id }}">{{ $region->region }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="budget" class="form-label">Define Your Budget</label>
                                        <input type="text" name="budget" id="budget" class="form-control"
                                            placeholder="Define Your Budget" required>
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="kpi" class="form-label">Define Your KPI :</label>
                                        <input type="text" name="kpi" id="kpi" class="form-control"
                                            placeholder="Define Your Kpi" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="asset" class="form-label">Asset</label>
                                            <input type="text" name="asset" id="asset" class="form-control"
                                                placeholder="Google Doc Link">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="brief" class="form-label">Client Brief</label>
                                            <input type="text" name="brief" id="brief" class="form-control"
                                                placeholder="Type here">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="exampleFormControlTextarea1">Client Brief
                                                Description</label>
                                            <textarea class="form-control" name="description"
                                                id="exampleFormControlTextarea1" rows="3"
                                                placeholder="Type here"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="advanced-search-datatable">
                                    <div class="col-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header border-bottom d-flex justify-content-between">
                                                <h4 class="card-title">Selected Influencers</h4>
                                            </div>
                                            
                                            
                                            <div class="card-datatable table-responsive">
                                                <table class="dt-advanced-search table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <!--<th>-->
                                                            <!--    <div class="form-check">-->
                                                            <!--        <input type="checkbox" class="form-check-input" name="" id="select-all">-->
                                                            <!--    </div>-->
                                                            <!--</th>-->
                                                            <th>Favourite</th>
                                                            <th>Name</th>
                                                            <th>TG Handle</th>
                                                            <th>Region</th>
                                                            <th>Tags</th>
                                                            <th>Social</th>
                                                            <th>Content</th>
                                                            <th>Total Flowers</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($influencers as $key=>$influencer_id)
                                                        @php
                                                        $influencer = DB::table('influencer')->where('id', $influencer_id)->first();
                                                        @endphp
                                                        
                                                        <input type="hidden" name="influencers[]" value="{{ $influencer_id }}" />
                                                        <tr>
                                                            <!--<td>-->
                                                            <!--    <div class="form-check">-->
                                                            <!--        <input type="checkbox" name="" id="check1" class="form-check-input">-->
                                                            <!--    </div>-->
                                                            <!--</td>-->
                                                            <td>
                                                                @if($influencer->is_favourite == 1)
                                                                <i class="fa fa-heart fav-btn" aria-hidden="true" style="color: red;"></i>
                                                                @elseif($influencer->is_favourite == 0)
                                                                <i class="fa fa-heart fav-btn" aria-hidden="true"></i>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('influencer-profile/'.$influencer->id) }}" target="_blank">
                                                                    @if($influencer->dp_url != null):
                                                                        <img src="{{ $influencer->dp_url }}" class="me-75" height="50" width="50" alt="Not Found" />
                                                                    @else
                                                                        <img src="{{ asset('images/profile.png') }}" class="me-75" height="50" width="50" alt="Not Found" />
                                                                    @endif
                                                                    <span class="fw-bold text-light">{{ $influencer->name }}</span>
                                                                </a>
                                                            </td>
                                                            <td><a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="{{ $influencer->telegram }}">Telegram</i></a></td>
                                                            <td>
                                                                @php
                                                                    $influencer_id = $influencer->id;
                                                                    $all_regions = DB::table('influencer_regions')
                                                                        ->where('influencer_id', $influencer_id)
                                                                        ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')
                                                                        ->get();
                                                                @endphp
                                                                
                                                                @foreach($all_regions as $key=>$region)
                                                                <span class="badge rounded-pill badge-light-info link-bottom">{{ $region->region }}</span>
                                                                @endforeach
                                                            </td>
                                                            <td class="">
                                                                @php
                                                                    $influencer_id = $influencer->id;
                                                                    $all_tags = DB::table('influencer_tags')
                                                                        ->where('influencer_id', $influencer_id)
                                                                        ->join('tags', 'influencer_tags.tag_id', '=', 'tags.id')
                                                                        ->get();
                                                                @endphp
                                                                @foreach($all_tags as $key=>$tag)
                                                                <span class="badge rounded-pill badge-light-info link-bottom">{{ $tag->tag }}</span>
                                                                @endforeach
                                                            </td>
                                                            <td class="">
                                                                @php
                                                                    $influencer_id = $influencer->id;
                                                                    $all_socials = DB::table('influencer_socials')
                                                                        ->where('influencer_id', $influencer_id)
                                                                        ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                                                        ->get();
                                                                @endphp
                                                                @foreach($all_socials as $key=>$val)
                                                                    <a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="{{$val->social_address}}">{{$val->social}}</a>
                                                                @endforeach
                                                            </td>
                                                            <td class="">
                                                                @php
                                                                    $influencer_id = $influencer->id;
                                                                    $all_contents = DB::table('influencer_contents')
                                                                        ->where('influencer_id', $influencer_id)
                                                                        ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                                        ->get();
                                                                @endphp
                                                                @foreach($all_contents as $key=>$content)
                                                                    <span class="badge rounded-pill badge-light-info link-bottom">{{$content->short_name}}- {{$content->price}}</span>
                                                                @endforeach
                                                                
                                                            </td>
                                                            <td><h5>{{ $influencer->total_follower }}</h5></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <!--<th>-->
                                                            <!--    <div class="form-check">-->
                                                            <!--        <input type="checkbox" name="" id="" class="form-check-input">-->
                                                            <!--    </div>-->
                                                            <!--</th>-->
                                                            <th>Favourite</th>
                                                            <th>Name</th>
                                                            <th>TG Handle</th>
                                                            <th>Region</th>
                                                            <th>Tags</th>
                                                            <th>Social</th>
                                                            <th>Content</th>
                                                            <th>Total Flowers</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            
                                            
                                            <div class="col-12 my-2">
                                                <input type="submit" class="btn btn-primary mb-1 csm-25" name="camp_status" value="Create & Sent to Client" />
                                                <input type="submit" class="btn btn-primary ml-2 top-12" name="camp_status" value="Create Draft" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/ Permission Table -->
                        
                    </div>
                </div>
        </section>
        <!-- Select2 End -->
    </div>
</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

@endsection