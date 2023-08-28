@extends('layouts.app')

@section('title') {{ 'Dashboard' }} @endsection

@section('content')

@php
$n_influencer = DB::table('influencer')->get()->count();
$kol_followers = DB::table('influencer')->sum('total_follower');
@endphp
    <!-- BEGIN: Content-->
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section>
                    <div class="row">
                        <!-- Subscribers Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">0</h2>
                                    <p class="card-text"> Total Media audience </p>
                                </div>
                                <div id="gained-chart"></div>
                            </div>
                        </div>
                        <!-- Subscribers Chart Card ends -->
                        <!-- Orders Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="package" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">0</h2>
                                    <p class="card-text">Total Media</p>
                                </div>
                                <div id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-info p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="package" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">{{ $n_influencer }}</h2>
                                    <p class="card-text">Total Influencers</p>
                                </div>
                                <div id="kol-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-success p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="package" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">{{ $kol_followers }}</h2>
                                    <p class="card-text">Total KOL Audience</p>
                                </div>
                                <div id="media-chart"></div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom d-flex justify-content-between">
                                    <h4 class="card-title">Ongoing Campaign</h4>
                                    <a href="{{ route('new_campaign') }}" class="btn btn-primary mt-1">Start a new Campaign</a>
                                </div>
                                <!--Search Form -->
                                <div class="card-datatable table-responsive">
                                    <table class="dt-advanced-search table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="" id="select-all">
                                                    </div>
                                                </th>
                                                <th>Campaign Name</th>
                                                <th>Client Name</th>
                                                <th>KPI</th>
                                                <th>Budget</th>
                                                <th>Total Reach</th>
                                                <th>Influencer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ongoingCampaigns as $campaign)
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-danger">
                                                        <input type="checkbox" name="" id="check1" class="form-check-input">
                                                    </div>
                                                </td>
                                                <td><a href="{{ url('campaign-details/'.$campaign->id) }}">{{ $campaign->campaign_name }}</a></td>
                                                <td>
                                                    @php
                                                    $client = DB::table('clients')->where('id', $campaign->client_id)->first();
                                                    @endphp
                                                    <a href="#">
                                                        <!--<img src="app-assets/images/portrait/small/avatar-s-3.jpg" class="me-75" height="40" width="40" alt="Angular" />-->
                                                        <span class="fw-bold text-light">{{ $client->name }}</span>
                                                    </a>
                                                </td>
                                                <td>{{ $campaign->kpi }}</td>
                                                <td class="">
                                                    <span class="badge rounded-pill badge-light-success">{{ $campaign->budget }}</span>
                                                </td>
                                                <td><span class="badge rounded-pill badge-light-warning">{{ $campaign->total_reach }}</span></td>
                                                <td class="">
                                                    @php
                                                    $influencers = DB::table('campaign_influencer')->where('campaign_id', $campaign->id)->get();
                                                    @endphp
                                                    
                                                    @foreach($influencers as $key=>$influencer)
                                                        @php $influencerDetail = DB::table('influencer')->where('id', $influencer->influencer_id)->first(); @endphp
                                                        
                                                        @if($influencerDetail)
                                                        <span class="badge rounded-pill badge-light-info link-bottom">{{ $influencerDetail->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td><span class="badge rounded-pill badge-light-primary me-1">{{ $campaign->status }}</span></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <!-- END: Content-->
@endsection
