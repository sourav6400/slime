@extends('layouts.app')

@section('title') {{ 'All Influencers' }} @endsection

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
    
    <div class="modal fade" id="templateDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 pb-5">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Template</h1>
                    </div>
                    <div class="col-12 mb-1">
                        <label class="form-label" for="modalPermissionName">Template Name</label>
                        <input type="text" id="template_name" class="form-control" placeholder="Template Name" autofocus="" data-msg="Please enter template name">
                    </div>
                    <div class="row">
                        <div class="col-sm-6 modal-input">
                            <label class="form-label" for="editPermissionName">Clients Budget</label>
                            <input type="text" id="clients_budget" class="form-control" placeholder="Clients Budget">
                        </div>
                        <div class="col-sm-6 modal-input">
                            <label class="form-label" for="editPermissionName">Profit Margin (%)</label>
                            <input type="text" id="profit_margin" class="form-control" placeholder="Profit Margin">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" id="save_template" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light">Save</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <form action="{{ route('new_camp_s1') }}" method="POST" id="campaign_and_template">
            @csrf
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">Advanced Filter</h4>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <button
                                        onclick="ExportToExcel('xlsx')"
                                        class="dt-button buttons-collection btn btn-outline-secondary dropdown-toggle me-2"
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
                                    </button>
                                    
                                    <table id="table_to_export" style="display: none;">
                                        <tr>
                                            <th>Name</th>
                                            <th>TG Handle</th>
                                            <th>Total Followers</th>
                                            <th>Regions</th>
                                            <th>Socials</th>
                                            <th>Contents</th>
                                        </tr>
                                        @foreach($all_influencers as $inf)
                                        <tr>
                                            <td>{{ $inf->name }}</td>
                                            <td>{{ $inf->telegram }}</td>
                                            <td>{{ $inf->total_follower }}</td>
                                            <td>
                                                @php
                                                $influencer_id = $inf->id;
                                                $regions = DB::table('influencer_regions')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')
                                                    ->get();
                                                @endphp
    
                                                @foreach($regions as $key=>$region)
                                                    <span>{{ $key+1 }}. {{ $region->region }}</span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                $influencer_id = $inf->id;
                                                $socials = DB::table('influencer_socials')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                                    ->get();
                                                @endphp
                                                @foreach($socials as $key=>$val)
                                                    <span>{{ $key+1 }}. {{ $val->social_address }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                $influencer_id = $inf->id;
                                                $contents = DB::table('influencer_contents')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                    ->get();
                                                @endphp
                                                @foreach($contents as $key=>$content)
                                                    <span>{{ $key+1 }}. {{$content->short_name}}-{{$content->price}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>

                                    @php
                                    $role_id = Auth::user()->role;
                                    $influencer_permission = DB::table('influencer_permission')->where('role_id',
                                    $role_id)->first();
                                    @endphp

                                    @if($influencer_permission != null && $influencer_permission->create == 1)
                                    <a class="btn btn-primary me-2" href="{{ route('add_new_influencer') }}">Add New Influencer</a>
                                    
                                    <div class="create_new_campaign">
                                        <input type="hidden" name="create_new_campaign_val" id="create_new_campaign_val" value="" />
                                        <!--<button type="submit" class="btn btn-primary" onclick="setVal()">Create New Campaign</button>-->
                                        <button type="button" class="btn btn-primary" onclick="create_camp_template('Create New Campaign')">Create New Campaign</button>
                                        
                                        <input type="hidden" name="template_name" id="template_name_post" value="" />
                                        <input type="hidden" name="clients_budget" id="clients_budget_post" value="" />
                                        <input type="hidden" name="profit_margin" id="profit_margin_post" value="" />
                                        <input type="hidden" name="create_new_template_val" id="submit_from_all_inf" value="" />
                                        <button type="button" class="btn btn-primary" onclick="create_camp_template('Create New Template')">
                                            Create New Template
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--Search Form -->

                        <hr class="my-0" />
                        <div class="row" id="advanced-search-datatable">
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body mt-2">
                                        <div class="dt_adv_search">
                                            <div class="row g-1 mb-md-1">
                                                <div class="col-md-4">
                                                    <label class="form-label">Name:</label>
                                                    <input type="text" class="form-control dt-input dt-full-name"
                                                        id="name" onkeyup="reloadTable()" data-column="1"
                                                        placeholder="Alaric Beslier" data-column-index="0" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Minimum Number of Audiences</label>
                                                    <input type="number" class="form-control dt-input"
                                                        id="follower_number" onkeyup="reloadTable()" data-column="2"
                                                        placeholder="Minimum Number of Audiences" data-column-index="1" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="select3-basic">Region</label>
                                                    <select class="select2 form-select multiple-regions"
                                                        onchange="reloadTable()" id="select3-basic" multiple>
                                                        @foreach($all_regions as $region)
                                                        <option value="{{ $region->id }}">{{ $region->region }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row g-1">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="select0-multiple">Social</label>
                                                    <select class="select2 form-select multiple-socials"
                                                        id="select0-multiple" onchange="reloadTable()" multiple>
                                                        <optgroup label="Select Upto all">
                                                            @foreach($all_socials as $social)
                                                            <option value="{{ $social->id }}">{{ $social->social }}
                                                            </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="select5-multiple">Tags</label>
                                                    <select class="select2 form-select multiple-tags"
                                                        id="select5-multiple" onchange="reloadTable()" multiple>
                                                        <optgroup label="Select Upto all">
                                                            @foreach($all_tags as $tag)
                                                            <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="select6-multiple">Content</label>
                                                    <select class="select2 form-select multiple-contents"
                                                        onchange="reloadTable()" id="select6-multiple" multiple>
                                                        <optgroup label="Select Upto all">
                                                            @foreach($all_contents as $content)
                                                            <option value="{{ $content->id }}">{{ $content->short_name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="" id="" class="form-check-input">
                                                    </div>
                                                </th>
                                                <!--<th>Favourite</th>-->
                                                <th>Name</th>
                                                <!--<th>Contact</th>-->
                                                <th>Regions</th>
                                                <th>TAGS</th>
                                                <th>Socials</th>
                                                <th>Audiences</th>
                                                <th>Contents</th>
                                                @if($influencer_permission != null && $influencer_permission->edit == 1)
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="" id="" class="form-check-input">
                                                    </div>
                                                </th>
                                                <!--<th>Favourite</th>-->
                                                <th>Name</th>
                                                <!--<th>Contact</th>-->
                                                <th>Regions</th>
                                                <th>TAGS</th>
                                                <th>Socials</th>
                                                <th>Audiences</th>
                                                <th>Contents</th>
                                                @if($influencer_permission != null && $influencer_permission->edit == 1)
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-datatable table-responsive">
                                    <h3>Selected Influencers</h3>
                                    <table class="dt-advanced-search table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="" id="select-all">
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Content</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="append">  
                                        </tbody>
                                        
                                        <tfoot>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="" id="select-all">
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Content</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </form>
    </div>
</div>
<!-- END: Content-->

<!-- Edit User Modal -->
<div class="modal fade" id="editInfluencer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Edit User Information</h1>
                </div>
                <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return true" method="POST"
                    action="{{ route('edit_profile') }}">
                    @csrf
                    <input type="hidden" name="influencer_id" id="influencer_id" value="" />
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserFirstName">Name</label>
                        <input type="text" id="influencer_name" name="influencer_name" class="form-control" value=""
                            placeholder="Your Name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserLastName">Telegram</label>
                        <input type="text" id="influencer_telegram" name="influencer_telegram" class="form-control"
                            value="" placeholder="Your Telegram" />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="modalEditUserName">Email</label>
                        <input type="email" id="influencer_email" name="influencer_email" class="form-control" value=""
                            placeholder="example@gmail.com" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="select3-basic">Region</label>
                        <select class="select2 form-select" name="influencer_regions[]" id="region" multiple required>
                            @foreach($all_regions_profile as $region)
                            <option value="{{$region->id}}">{{$region->region}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="select3-basic">Tags</label>
                        <select class="select2 form-select" name="influencer_tags[]" id="tag" multiple required>
                            @foreach($all_tags_profile as $tag)
                            @if($tag->tag == 'Demo Tag' || $tag->tag == 'Test Tab')
                            <option value="{{$tag->id}}" selected>{{$tag->tag}}</option>
                            @else
                            <option value="{{$tag->id}}">{{$tag->tag}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Delete Influencer</h1>
                </div>

                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading">Confirmation!</h6>
                    <div class="alert-body">
                        Do you want to delete this Influencer?
                    </div>
                </div>

                <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate"
                    action="{{ route('delete_influencer') }}" method="POST">
                    @csrf
                    <input type="hidden" value="" id="influencer_id_to_delete" name="influencer_id_to_delete" />

                    <div class="col-sm-12 ps-sm-0 text-center">
                        <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes,
                            Delete it</button>
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
<!--/ Delete Modal -->

<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">

</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>


@endsection


@section('js')

<script>
    function create_camp_template(param)
    {
        if ($('.append').children().length === 0) {
          alert('At least one influencer must be selected.')
        }
        else
        {
            if(param == 'Create New Campaign')
            {
                $("#create_new_campaign_val").val('Create New Campaign');
                $("#campaign_and_template").submit();
            }
            else if(param == 'Create New Template')
            {
                $("#templateDetail").modal("show");
            }
        }
    }
    
    $("#save_template").click(function() {
        var template_name = $("#template_name").val();
        var clients_budget = $("#clients_budget").val();
        var profit_margin = $("#profit_margin").val();
        
        $("#template_name_post").val(template_name);
        $("#clients_budget_post").val(clients_budget);
        $("#profit_margin_post").val(profit_margin);
        $("#submit_from_all_inf").val('Create New Template');
        $("#campaign_and_template").submit();
    });
</script>
    
<script>
    // $(document).ready(function () {
    //     $('#example').DataTable();
    // });

    $(document).ready(function () {

        dataTable = $('#example').DataTable({

            responsive: true,
            processing: true,
            serverSide: true,
            Filter: true,
            stateSave: true,
            type: "POST",
            "ajax": {
                "url": "{!! route('influencers.getData') !!}",
                "type": "POST",
                data: function (d) {
                    d._token = "{{csrf_token()}}";
                    d.name = $("#name").val();
                    d.follower_number = $("#follower_number").val();
                    d.regions = $(".multiple-regions").val();
                    d.socials = $(".multiple-socials").val();
                    d.tags = $(".multiple-tags").val();
                    d.contents = $(".multiple-contents").val();

                },
            },
            columns: [

                {
                    "data": function (data) {
                        return '<div class="form-check">' +
                                '<input type="checkbox" name="" onclick="appendAtRight('+ data.id +')" id="check-influencer-'+data.id+'" class="form-check-input">' +
                                '</div>';
                        // if (data.dp_url != null) {
                        //     return '<div class="form-check">' +
                        //         '<input type="checkbox" name="" onclick="appendAtRight(' + data.id + ')" id="check-influencer-'+data.id+'" class="form-check-input">' +
                        //         '</div>';
                        //         // '<a onclick="viewProfile(' + data.id + ')">  <img src="' + data.dp_url + '" class="me-75" height="50" width="50" alt="Not Found" /> </a>';
                        // }
                        // else {
                        //     return '<div class="form-check">' +
                        //         '<input type="checkbox" name="" onclick="appendAtRight(' + data.id + ')" id="check-influencer-'+data.id+'" class="form-check-input">' +
                        //         '</div>';
                        //         // '<a onclick="viewProfile(' + data.id + ')">  <img src="{{ asset('images/profile.png') }}" class="me-75" height="50" width="50" alt="Not Found" /> </a>';
                        // }
                    },
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },

                // {
                //     "data": function (data) {
                //         if (data.is_favourite == 1) {
                //             return '<i class="fa fa-heart fav-btn" aria-hidden="true" onclick="changeFavoriteStatus('+data.id+')" style="color: red;"></i>';
                //         }
                //         else {
                //             return '<i class="fa fa-heart fav-btn" aria-hidden="true" onclick="changeFavoriteStatus(' + data.id + ')" ></i>';
                //         }
                //     },
                //     "orderable": false, "searchable": false, "name": "selected_rows"
                // },

                // { data: 'name', name: 'name' },
                
                {
                    "data": function (data) {
                        if (data.dp_url != null) {
                            return '<a onclick="viewProfile(' + data.id + ')"><img src="' + data.dp_url + '" class="" height="50" width="50" alt="Not Found" /></a>'+
                            '<br>'+
                            '<span><a onclick="viewProfile('+ data.id +')" class="badge badge-secondary" style="float: left;">'+ data.name +'</a><br><a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="' + data.telegram + '" title="Contact"><i class="fa fa-address-book" aria-hidden="true"></i></a></span>';
                        }
                        else {
                            return '<a onclick="viewProfile(' + data.id + ')"><img src="{{ asset('images/profile.png') }}" class="me-75" height="50" width="50" alt="Not Found" /></a>'+
                            '<br>'+
                            '<span><a onclick="viewProfile('+ data.id +')" class="badge badge-secondary" style="float: left;">'+ data.name +'</a><br><a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="' + data.telegram + '" title="Contact"><i class="fa fa-address-book" aria-hidden="true"></i></a></span>';
                        }

                    }, "orderable": true, "searchable": false, "name": "name"
                },

                // {
                //     "data": function (data) {
                //         return '<a class="badge rounded-pill badge-light-success link-bottom" target="_blank" href="' + data.telegram + '"><i class="fa fa-address-book" aria-hidden="true"></i></a>';

                //     }, "orderable": false, "searchable": false, "name": "selected_rows"
                // },
                
                {
                    "data": function (data) {
                        return data.regions;
                    }, "orderable": false, "searchable": false, "name": "selected_rows"
                },

                {
                    "data": function (data) {
                        return data.tags;
                    }, 
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },

                {
                    "data": function (data) {
                        return data.socials;
                    }, "orderable": false, "searchable": false, "name": "selected_rows"
                },
                // { data: 'total_follower', name: 'total_follower' },
                {
                    "data": function (data) {
                        return data.total_follower;
                    }, "orderable": true, "searchable": false, "name": "total_follower"
                },

                {
                    "data": function (data) {
                        return data.contents;
                    },
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },

                @if ($influencer_permission != null && $influencer_permission -> edit == 1) {
                "data": function(data) {
                    return '<a class="me-1" type="button" onclick="quickEdit(' + data.id + ' )"><i class="fas fa-edit" title="Quick Edit"></i></a>' +
                        '<a data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-influencer_id="' + data.id + '"><i class="fa fa-trash" aria-hidden="true" title="Remove"></i></a>'
                },
                "orderable": false, "searchable": false, "name": "selected_rows"
                },
                @endif

            ]
        });
    });
    function reloadTable() {
        dataTable.ajax.reload();
    }
</script>
<script>
    function removethis(id)
    {
        $( '.trt-'+id ).remove();
        $("#check-influencer-"+id).prop("checked", false);
        
        // if ($('.append').children().length === 0) {
        //   $(".create_new_campaign").hide();
        // }
    }
    
    function appendAtRight(id) {
        if($("#check-influencer-"+id).is(':checked'))
        {
            var influencer_id = id;
            $.ajax({
                type: 'POST',
                url: '/append-at-right',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    influencer_id: influencer_id
                },
                success: function (data) {
                    $(".append").append(data);
                    $(".create_new_campaign").show();
                    // $("#content-modal-body").html(data);
                    // $('#contentModal').modal('show');
                    // console.log(data)
                }
            });
        }
        else
        {
            $( '.trt-'+id ).remove();
            
            // if ($('.append').children().length === 0) {
            //     $(".create_new_campaign").hide();
            // }
        }
        var x = $("#select-content-name").val();
    }

    function viewProfile(id) {
        var url = "{{ route('influencer_billing', ":id") }}";
        url = url.replace(':id', id);
        // window.location.href = url;
        window.open(url);
    }
    function changeFavoriteStatus(id) {
        var url = "{{ route('change_fav_status', ":id") }}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'get',
            url: url,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                // name: name,
                // email: email,
                // regions: regions,
                // socials: socials,
                id: id
                // contents: contents
            },
            success: function (data) {
                // $("#all_influencers").hide()
                // $("#filtered_influencers").html(data);
                console.log(data)
                reloadTable();
            }
        });
    }
    function filterEvent() {
        var name = $("#name").val();
        var email = $("#email").val();
        var regions = $(".multiple-regions").val();
        var socials = $(".multiple-socials").val();
        var tags = $(".multiple-tags").val();
        var contents = $(".multiple-contents").val();

        console.log(tags)
        reloadTable();
        $.ajax({
            type: 'POST',
            url: '{!! route('influencers.test') !!}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                // name: name,
                // email: email,
                // regions: regions,
                // socials: socials,
                tags: tags
                // contents: contents
            },
            success: function (data) {
                // $("#all_influencers").hide()
                // $("#filtered_influencers").html(data);
                // console.log(data)
            }
        });
    }

    function quickEdit(id) {
        // var key = $(this).data('key')
        // alert(id)
        // $("#all-influencer-row-id").hide()
        // $("#influencer-quick-edit-id").show()
        // $("#telegram-main-"+id).hide()
        // $("#telegram-edit-"+id).show()

        var influencer_id = id;
        // console.log(id);

        $.ajax({
            type: 'POST',
            url: '/quick-edit',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: influencer_id
            },
            success: function (data) {
                $("#editUser").html(data);
                $("#editUser").modal("show");
                // console.log(data)
                // alert(data)
            }
        });
        // $("#editUser").modal("show");

        // $("mybtn").click(function () {
        //     $("#editUser").modal("show");
        // });
    }

    $(document).on("click", ".delete-influencer", function () {
        var influencer_id = $(this).data('influencer_id');
        $("#influencer_id_to_delete").val(influencer_id);
    });

    $(document).on("click", ".edit-influencer", function () {
        var influencer_id = $(this).data('influencer_id');
        var influencer_name = $(this).data('influencer_name');
        var influencer_email = $(this).data('influencer_email');
        var influencer_tg = $(this).data('influencer_tg');

        // console.log(influencer_id);
        // console.log(influencer_name);
        // console.log(influencer_email);
        // console.log(influencer_tg);

        $("#influencer_id").val(influencer_id);
        $("#influencer_name").val(influencer_name);
        $("#influencer_telegram").val(influencer_tg);
        $("#influencer_email").val(influencer_email);
    });
</script>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
    //   var elt = document.getElementById('example');
    var elt = document.getElementById('table_to_export');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
    XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
    XLSX.writeFile(wb, fn || ('All-Influencers.' + (type || 'xlsx')));
}
</script>
@endsection