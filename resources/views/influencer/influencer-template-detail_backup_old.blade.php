@extends('layouts.app')

@section('title') {{ 'Influencer Template Detail' }} @endsection

@section('content')

<style>
/*thead, tbody, tr { display: block; }*/

/*tbody {*/
    /*height: 100px;       /* Just for the demo          
    overflow-y: auto;    /* Trigger vertical scroll    
    overflow-x: hidden;  /* Hide the horizontal scroll 
/*}*/

table.scrolldown {
            width: 100%;
              
            /* border-collapse: collapse; */
            border-spacing: 0;
            border: 1px solid black;
        }
          
        /* To display the block as level element */
        table.scrolldown tbody, table.scrolldown thead {
            display: block;
        } 
          
        thead tr th {
            height: 40px; 
            line-height: 40px;
        }
          
        table.scrolldown tbody {
              
            /* Set the height of table body */
            height: 200px; 
              
            /* Set vertical scroll */
            overflow-y: auto;
              
            /* Hide the horizontal scroll */
            overflow-x: hidden; 
        }
          
        tbody { 
            border-top: 2px solid black;
        }
          
        tbody td, thead th {
            width : 200px;
            border-right: 2px solid black;
        }
        td {
            text-align:left;
        }
</style>
<!-- BEGIN: Content-->
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        
    </div>

    <div class="content-body">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="col-12 col-md-6">
                        <h4 class="card-title">Template Name : <span class="text-success">{{ $influencer_template_detail->template_name }}</span></h4>
                    </div>
                </div>
            </div>
        </section>
        
        <div>
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

        <section>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1"><span id="n_of_influencer"></span></h2>
                            <p class="card-text"><b>Total Influencers</b></p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1"><span id="total_follower"></span></h2>
                            <p class="card-text"><b>Total Followers</b></p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1"><span id="total_price"></span></h2>
                            <p class="card-text"><b>Total Cost</b></p>
                        </div>
                        <div id="kol-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1"><span id="total_action"></span></h2>
                            <p class="card-text"><b>Total Action</b></p>
                        </div>
                        <div id="media-chart"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1">{{ number_format($influencer_template_detail->clients_budget) }}</h2>
                            <p class="card-text"><b>Clients Budget</b></p>
                        </div>
                        <div id="gained-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1">{{ number_format($influencer_template_detail->profit_margin) }}</h2>
                            <p class="card-text"><b>Profit Margin (%)</b></p>
                        </div>
                        <div id="order-chart"></div>
                    </div>
                </div>
                @php
                if(($influencer_template_detail->clients_budget) != null && ($influencer_template_detail->profit_margin) != null)
                {
                    $tagated_profit = (($influencer_template_detail->profit_margin)*($influencer_template_detail->clients_budget))/100;
                    $tagated_profit = number_format($tagated_profit);
                }
                else
                {
                    $tagated_profit = 0;
                }
                @endphp
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1">{{ $tagated_profit }}</h2>
                            <p class="card-text"><b>Profit Target</b></p>
                        </div>
                        <div id="kol-chart"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header flex-column align-items-start pb-0">
                            <h2 class="fw-bolder mt-1"><span id="profit_achieved_val"></span></h2>
                            <p class="card-text"><b>Profit Achieved</b></p>
                        </div>
                        <div id="kol-chart"></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">Influencers</h4>
                            <div class="dt-action-buttons text-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item edit-tag" data-bs-toggle="modal" data-bs-target="#editTemplate">
                                            <i data-feather="edit" class="me-50"></i>
                                            <span>Edit Template Basics</span>
                                        </a>
                                        <a href="{{ url('add-influencer-to-template/'.$influencer_template_detail->id) }}" class="dropdown-item">
                                            <i data-feather="plus" class="me-50"></i><span>Add Influencer to this template</span>
                                        </a>
                                        <a class="dropdown-item" onclick="ExportToExcel('xlsx')"
                                            tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                            aria-haspopup="true" aria-expanded="false"><span><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-share font-small-4 me-50">
                                                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                                <polyline points="16 6 12 2 8 6"></polyline>
                                                <line x1="12" y1="2" x2="12" y2="15"></line>
                                            </svg>Export as Excel</span>
                                        </a>
                                    </div>
                                </div>
                                <!--<div class="dt-buttons d-inline-flex">-->
                                <!--    <a href="{{ url('add-influencer-to-template/'.$influencer_template_detail->id) }}"-->
                                <!--        title="Add Influencer" class="btn btn-primary me-2">-->
                                <!--        Add Influencer to this template-->
                                <!--    </a>-->
                                <!--    <button onclick="ExportToExcel('xlsx')"-->
                                <!--        class="dt-button buttons-collection btn btn-outline-secondary dropdown-toggle me-2"-->
                                <!--        tabindex="0" aria-controls="DataTables_Table_0" type="button"-->
                                <!--        aria-haspopup="true" aria-expanded="false"><span><svg-->
                                <!--                xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                                <!--                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                                <!--                stroke-linecap="round" stroke-linejoin="round"-->
                                <!--                class="feather feather-share font-small-4 me-50">-->
                                <!--                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>-->
                                <!--                <polyline points="16 6 12 2 8 6"></polyline>-->
                                <!--                <line x1="12" y1="2" x2="12" y2="15"></line>-->
                                <!--            </svg>Export as Excel</span>-->
                                <!--    </button>-->
                                <!--</div>-->
                            </div>
                        </div>
                        <!--Search Form -->
                        
                        <hr class="my-0" />
                        <div class="row" id="advanced-search-datatable">
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    @php
                                        $total_price = 0;
                                        $i = 0;
                                        $total_follower = 0;
                                        $total_action = 0;
                                        $influencers = $influencer_template_detail->influencers;
                                        $influencers = json_decode($influencers, true);
                                        $influencers2 = $influencers;
                                        @endphp
                                    
                                        <table id="table_to_export" style="display: none;">
                                            <tr>
                                                <th>Name</th>
                                                <th>TG Handle</th>
                                                <th>Total Followers</th>
                                                <th>Regions</th>
                                                <th>Socials</th>
                                                <th>Contents</th>
                                            </tr>
                                            @foreach($influencers as $inf_id)
                                                @php $inf = DB::table('influencer')->where('id', $inf_id)->first(); @endphp
                                                @if($inf)
                                                    <tr>
                                                        <td>{{ $inf->name }}</td>
                                                        <td>{{ $inf->telegram }}</td>
                                                        <td>{{ $inf->total_follower }}</td>
                                                        <td>
                                                            @php
                                                            $influencer_id = $inf->id;
                                                            $all_regions = DB::table('influencer_regions')
                                                                ->where('influencer_id', $influencer_id)
                                                                ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')
                                                                ->get();
                                                            @endphp
                
                                                            @foreach($all_regions as $key=>$region)
                                                                <span>{{ $key+1 }}. {{ $region->region }}</span><br>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @php
                                                            $influencer_id = $inf->id;
                                                            $all_socials = DB::table('influencer_socials')
                                                                ->where('influencer_id', $influencer_id)
                                                                ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                                                ->get();
                                                            @endphp
                                                            @foreach($all_socials as $key=>$val)
                                                                <span>{{ $key+1 }}. {{ $val->social_address }}</span>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @php
                                                            $influencer_id = $inf->id;
                                                            $all_contents = DB::table('influencer_contents')
                                                                ->where('influencer_id', $influencer_id)
                                                                ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                                ->get();
                                                            @endphp
                                                            @foreach($all_contents as $key=>$content)
                                                                <span>{{ $key+1 }}. {{$content->short_name}}-{{$content->price}}</span>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    <!--/*thead, tbody, tr { display: block; }*/-->
                                    
                                    <table class="scrolldown table table-striped table-bordered">
                                        <!-- Table head content -->
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Content-Quantity</th>
                                                <th>Price</th>
                                                <th>Followers</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                          
                                        <!-- Table body content -->
                                        <tbody>
                                            @foreach($influencers as $key=>$influencer)

                                            @php $influencer_detail = DB::table('influencer')->where('id',
                                            $influencer)->first(); @endphp
    
                                            @if($influencer_detail)
                                                @php
                                                $i++;
        
                                                $total_follower = $total_follower + $influencer_detail->total_follower;
                                                $all_contents = DB::table('influencer_contents')
                                                    ->where('influencer_id', $influencer_detail->id)
                                                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                    ->get();
        
                                                $price = 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            @if($influencer_detail->dp_url != null)
                                                            <img src="{{ $influencer_detail->dp_url }}" class="me-75"
                                                                height="40" width="40" alt="Not Found" />
                                                            @else
                                                            <img src="{{ asset('images/profile.png') }}" class="me-75"
                                                                height="40" width="40" alt="Not Found" />
                                                            @endif
                                                            <br>
                                                            <span class="fw-bold text-light">{{ $influencer_detail->name }}</span>
                                                        </a>
                                                    </td>
                                                    <td class="">
                                                        @if($all_contents)
                                                        @foreach($all_contents as $key=>$content)
                                                        @php
                                                        $template_id = $influencer_template_detail->id;
                                                        $templateContentDetail = DB::table('ifluencer_template_content')
                                                        ->where('template_id', $template_id)
                                                        ->where('influencer_id', $influencer_detail->id)
                                                        ->where('content_id', $content->id)
                                                        ->first();
                                                        if($templateContentDetail)
                                                        {
                                                        $quantity = $templateContentDetail->content_quantity;
                                                        }
                                                        else
                                                        {
                                                        $quantity = 1;
                                                        }
                                                        @endphp
        
                                                        @if($quantity > 0)
                                                        <span class="badge rounded-pill badge-light-info link-bottom">
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                                {{$content->short_name}}-{{ $content->price }}
                                                            </span>
                                                            <b>-</b>
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                                {{ $quantity }}
                                                            </span>
                                                        </span>
                                                        @endif
                                                        @php
                                                        $price = $price + ($content->price)*$quantity;
                                                        $total_action = $total_action + $quantity;
                                                        @endphp
                                                        @endforeach
                                                        @php $total_price = $total_price + $price; @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ number_format($price) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($influencer_detail->total_follower) }}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                                data-bs-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item edit-tag"
                                                                    onclick="contentModal({{ $influencer_detail->id }})">
                                                                    <i data-feather="edit-2" class="me-50"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                                <a class="dropdown-item delete-influencer"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deletePermissionModal"
                                                                    data-influencer_id="{{ $influencer_detail->id }}">
                                                                    <i data-feather="trash" class="me-50"></i>
                                                                    <span>Remove</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Content-Quantity</th>
                                                <th>Price</th>
                                                <th>Followers</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($influencers as $key=>$influencer)

                                            @php $influencer_detail = DB::table('influencer')->where('id',
                                            $influencer)->first(); @endphp
    
                                            @if($influencer_detail)
                                                @php
                                                $i++;
        
                                                $total_follower = $total_follower + $influencer_detail->total_follower;
                                                $all_contents = DB::table('influencer_contents')
                                                    ->where('influencer_id', $influencer_detail->id)
                                                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                    ->get();
        
                                                $price = 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            @if($influencer_detail->dp_url != null)
                                                            <img src="{{ $influencer_detail->dp_url }}" class="me-75"
                                                                height="40" width="40" alt="Not Found" />
                                                            @else
                                                            <img src="{{ asset('images/profile.png') }}" class="me-75"
                                                                height="40" width="40" alt="Not Found" />
                                                            @endif
                                                            <span class="fw-bold text-light">{{ $influencer_detail->name
                                                                }}</span>
                                                        </a>
                                                    </td>
                                                    <td class="">
                                                        @if($all_contents)
                                                        @foreach($all_contents as $key=>$content)
                                                        @php
                                                        $template_id = $influencer_template_detail->id;
                                                        $templateContentDetail = DB::table('ifluencer_template_content')
                                                        ->where('template_id', $template_id)
                                                        ->where('influencer_id', $influencer_detail->id)
                                                        ->where('content_id', $content->id)
                                                        ->first();
                                                        if($templateContentDetail)
                                                        {
                                                        $quantity = $templateContentDetail->content_quantity;
                                                        }
                                                        else
                                                        {
                                                        $quantity = 1;
                                                        }
                                                        @endphp
        
                                                        @if($quantity > 0)
                                                        <span class="badge rounded-pill badge-light-info link-bottom">
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                                {{$content->short_name}}-{{ $content->price }}
                                                            </span>
                                                            <b>-</b>
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                                {{ $quantity }}
                                                            </span>
                                                        </span>
                                                        @endif
                                                        @php
                                                        $price = $price + ($content->price)*$quantity;
                                                        $total_action = $total_action + $quantity;
                                                        @endphp
                                                        @endforeach
                                                        @php $total_price = $total_price + $price; @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ number_format($price) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($influencer_detail->total_follower) }}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                                data-bs-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item edit-tag"
                                                                    onclick="contentModal({{ $influencer_detail->id }})">
                                                                    <i data-feather="edit-2" class="me-50"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                                <a class="dropdown-item delete-influencer"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deletePermissionModal"
                                                                    data-influencer_id="{{ $influencer_detail->id }}">
                                                                    <i data-feather="trash" class="me-50"></i>
                                                                    <span>Remove</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>

                                        <!--<tfoot>-->
                                        <!--    <tr>-->
                                        <!--        <th></th>-->
                                        <!--        <th></th>-->
                                        <!--        <th>Total Price: {{ number_format($total_price) }}</th>-->
                                        <!--        <th></th>-->
                                        <!--        <th></th>-->
                                        <!--    </tr>-->
                                        <!--</tfoot>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Select2 End -->
    </div>
</div>

<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h3 class="mb-1">Do you want to remove this Influencer from template?</h3>
                </div>

                <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate"
                    action="{{ route('remove_influencer_from_template') }}" method="POST">
                    @csrf
                    <input type="hidden" name="influencer_template_id" value="{{ $influencer_template_detail->id }}" />
                    <input type="hidden" id="influencer_id_to_remove" name="influencer_id_to_remove" value="" />

                    <div class="col-sm-12 ps-sm-0 text-center">
                        <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes,
                            Remove</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal"
                            aria-label="Close">
                            No, Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
        <div class="modal fade" id="editTemplate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reload()"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Edit Template Basics</h1>
                        </div>
                        
                        <form id="editPermissionForm" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('edit_template_basics') }}" method="POST">
                            @csrf
                            <input type="hidden" id="total_cost" name="total_cost" value="{{ $total_price }}" />
                            <input type="hidden" id="template_id" name="template_id" value="{{ $influencer_template_detail->id }}" />
                            <div class="col-sm-12 modal-input">
                                <label class="form-label" for="editPermissionName">Template Name</label>
                                <input type="text" name="template_name" class="form-control" value="{{ $influencer_template_detail->template_name }}" placeholder="Enter a Template name">
                            </div>
                            <div class="col-sm-6 modal-input">
                                <label class="form-label" for="editPermissionName">Clients Budget</label>
                                <input type="text" name="clients_budget" class="form-control" value="{{ $influencer_template_detail->clients_budget }}" placeholder="Clients Budget">
                            </div>
                            <div class="col-sm-6 modal-input">
                                <label class="form-label" for="editPermissionName">Profit Margin (%)</label>
                                <input type="text" name="profit_margin" class="form-control" value="{{ $influencer_template_detail->profit_margin }}" placeholder="Profit Margin">
                            </div>
                            <div class="col-sm-12 ps-sm-0 text-center">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Update</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit Permission Modal -->
<!-- END: Content-->

<div class="modal fade" id="contentModal">
    <div id="content-modal-body">
        
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    $('#example').DataTable({
        scrollY: '200px',
        scrollCollapse: true,
        paging: false,
    });
    function reload()
    {
        alert('Test');
    }
    function editAccess(content_id)
    {
        if($('#check-'+content_id).is(":checked")){
            $("#quantity-"+content_id).prop("readonly", false);
            $("#price-"+content_id).prop("readonly", false);
            $("#btn-"+content_id). attr("disabled", false);
        }
        else {
            $("#quantity-"+content_id).prop("readonly", true);
            $("#price-"+content_id).prop("readonly", true);
            $("#btn-"+content_id). attr("disabled", true);
        }
    }
    $(document).ready(function () {
        // $('#example').DataTable();
        var n_of_influencer = '<?php echo number_format($i); ?>';
        var total_price = '<?php echo number_format($total_price); ?>';
        var total_follower = '<?php echo number_format($total_follower); ?>';
        var total_action = '<?php echo number_format($total_action); ?>';
        
        var clients_budget = '<?php echo $influencer_template_detail->clients_budget; ?>';
        var expense = '<?php echo $total_price; ?>';
        if(clients_budget != null)
            profit_achieved = clients_budget - expense;
        else
            profit_achieved = null;

        $("#n_of_influencer").html(n_of_influencer);
        $("#total_price").html(total_price);
        $("#total_follower").html(total_follower);
        $("#total_action").html(total_action);
        $("#profit_achieved_val").html(profit_achieved);
    });

    $(document).on("click", ".delete-influencer", function () {
        var influencer_id = $(this).data('influencer_id');

        $("#influencer_id_to_remove").val(influencer_id);
    });

    function contentModal(id) {
        var template_id = '<?php echo $influencer_template_detail->id; ?>';
        $.ajax({
            type: 'POST',
            url: '/template-content-modal',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: id,
                template_id: template_id
            },
            success: function (data) {
                $("#content-modal-body").html(data);
                $('#contentModal').modal('show');
                // console.log(data)
            }
        });
    }

    function update_content_price(content_id) {
        var price = $("#price-" + content_id).val();
        var influencer_id = $(".influencer-" + content_id).val();
        var quantity = $("#quantity-" + content_id).val();
        var template_id = '<?php echo $influencer_template_detail->id; ?>';
        var clients_budget = '<?php echo $influencer_template_detail->clients_budget; ?>';
        var total_expense = '<?php echo $total_price; ?>';
        
        console.log("influencer_id: "+influencer_id);
        console.log("content_id: "+content_id);
        console.log("template_id: "+template_id);
        
        $.ajax({
            type: 'POST',
            url: '/content-custom-price',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: influencer_id,
                content_id: content_id,
                price: price,
                quantity: quantity,
                template_id: template_id,
                clients_budget: clients_budget,
                total_expense: total_expense
            },
            success: function (data) {
                alert(data);
            }
        });
    }
</script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
    function ExportToExcel(type, fn, dl) {
        //   var elt = document.getElementById('example');
        var elt = document.getElementById('table_to_export');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || ('Influencers.' + (type || 'xlsx')));
    }
</script>