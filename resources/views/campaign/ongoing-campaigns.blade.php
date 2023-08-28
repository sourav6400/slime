@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-body">
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">Ongoing Campaigns</h4>
                            <!--<a href="#" class="btn btn-primary mt-1">Duplicate Campaign</a>-->
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
                                    @foreach($campaigns as $key=>$campaign)
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
                                        <td><span class="badge rounded-pill badge-light-warning">2.5k</span></td>
                                        <td class="">
                                            @php
                                            $influencers = DB::table('campaign_influencer')->where('campaign_id', $campaign->id)->get();
                                            @endphp
                                            
                                            @foreach($influencers as $key=>$influencer)
                                                @php
                                                $influencerDetail = DB::table('influencer')->where('id', $influencer->influencer_id)->first();
                                                @endphp
                                                
                                                @if($influencerDetail)
                                                <span class="badge rounded-pill badge-light-info link-bottom">{{ $influencerDetail->name }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td><span class="badge rounded-pill badge-light-primary me-1">{{ $campaign->status }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="check1" class="form-check-input">
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
                                </tfoot>
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