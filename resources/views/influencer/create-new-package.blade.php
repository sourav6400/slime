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

    <div class="content-body">
        <form action="{{ route('create_package') }}" method="POST">
            @csrf
            <section id="advanced-search-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title">Package Basic</h4>
                            </div>
                            <hr class="my-0" />
                            <div class="row" id="advanced-search-datatable">
                                <div class="col-12 col-lg-6">
                                    <div class="card-body row g-1 mb-md-1">
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Package Name</label>
                                            <input type="text" class="form-control dt-input dt-full-name" name="package_name" id="package_name" placeholder="Enter Package Name" required />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-lg-6">
                                    <div class="card-body row g-1 mb-md-1">
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Package Price</label>
                                            <input type="number" class="form-control dt-input dt-full-name" name="package_price" id="package_price" placeholder="Enter Package Price" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-header border-bottom d-flex justify-content-between">
                                <h4 class="card-title">Advanced Filter</h4>
                                <div class="dt-action-buttons text-end">
                                    <div class="dt-buttons d-inline-flex">
                                        <!--<button-->
                                        <!--    onclick="ExportToExcel('xlsx')"-->
                                        <!--    class="dt-button buttons-collection btn btn-outline-secondary dropdown-toggle me-2"-->
                                        <!--    tabindex="0" aria-controls="DataTables_Table_0" type="button"-->
                                        <!--    aria-haspopup="true" aria-expanded="false"><span><svg-->
                                        <!--            xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                                        <!--            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                                        <!--            stroke-linecap="round" stroke-linejoin="round"-->
                                        <!--            class="feather feather-share font-small-4 me-50">-->
                                        <!--            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>-->
                                        <!--            <polyline points="16 6 12 2 8 6"></polyline>-->
                                        <!--            <line x1="12" y1="2" x2="12" y2="15"></line>-->
                                        <!--        </svg>Export as Excel</span>-->
                                        <!--</button>-->
    
                                        @php
                                        $role_id = Auth::user()->role;
                                        $influencer_permission = DB::table('influencer_permission')->where('role_id',
                                        $role_id)->first();
                                        @endphp
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
                                                        <!--<div class="form-check">-->
                                                            <!--<input type="checkbox" name="" id="" class="form-check-input">-->
                                                        <!--</div>-->
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Regions</th>
                                                    <th>TAGS</th>
                                                    <th>Socials</th>
                                                    <th>Audiences</th>
                                                    <th>Contents</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
                                            </tbody>
    
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        <!--<div class="form-check">-->
                                                            <!--<input type="checkbox" name="" id="" class="form-check-input">-->
                                                        <!--</div>-->
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Regions</th>
                                                    <th>TAGS</th>
                                                    <th>Socials</th>
                                                    <th>Audiences</th>
                                                    <th>Contents</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    <div class="card-datatable table-responsive">
                                        <h3>Selected Influencer</h3>
                                        <table class="dt-advanced-search table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <!--<div class="form-check">-->
                                                            <!--<input type="checkbox" class="form-check-input" name="" id="select-all">-->
                                                        <!--</div>-->
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Contents</th>
                                                </tr>
                                            </thead>
                                            <tbody class="append">  
                                            </tbody>
                                            
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        <!--<div class="form-check">-->
                                                            <!--<input type="checkbox" class="form-check-input" name="" id="select-all">-->
                                                        <!--</div>-->
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Contents</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-md" type="submit">Add Package and Customize Contents</button>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
<!-- END: Content-->

<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">

</div>

<div class="modal fade" id="contentModal">
    <div id="content-modal-body">
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

@endsection

@section('js')

<script>
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
                                // '<input type="radio" name="influencer_id" onclick="appendAtRight('+ data.id +')" id="check-influencer-'+data.id+'" class="form-check-input">' +
                                '<input type="radio" name="influencer_id" onclick="appendAtRight('+ data.id +')" id="check-influencer-'+data.id+'" class="form-check-input">' +
                                '</div>';
                    },
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },
                
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
                }
            ]
        });
    });
    function reloadTable() {
        dataTable.ajax.reload();
    }
    
    function removethis(id)
    {
        $( '.trt-'+id ).remove();
        $("#check-influencer-"+id).prop("checked", false);
    }
    
    function appendAtRight(id) {
        $(".inf-row").remove();
        var influencer_id = id;
        $.ajax({
            type: 'POST',
            url: '/package-selected-influencer',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: influencer_id
            },
            success: function (data) {
                $(".append").append(data);
            }
        });
    }

    function viewProfile(id) {
        var url = "{{ route('influencer_billing', ":id") }}";
        url = url.replace(':id', id);
        // window.location.href = url;
        window.open(url);
    }
    
    function contentModal(id) {
        alert(id);
        // var template_id = '<?php //echo $influencer_template_detail->id; ?>';
        // $.ajax({
        //     type: 'POST',
        //     url: '/template-content-modal',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         influencer_id: id,
        //         template_id: template_id
        //     },
        //     success: function(data) {
        //         $("#content-modal-body").html(data);
        //         $('#contentModal').modal('show');
        //         // console.log(data)
        //     }
        // });
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
                tags: tags
            },
            success: function (data) {
            }
        });
    }
</script>
@endsection