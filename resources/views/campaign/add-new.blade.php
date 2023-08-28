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
                            <form class="form" method="POST" id="add_campaign" action="{{ route('add_new_campaign') }}">
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
                                                <h4 class="card-title">Select Influencer</h4>
                                            </div>
                                            <!--Search Form -->
                                            <div class="card-body mt-2">
                                                <div class="dt_adv_search" method="POST">
                                                    <div class="row g-1 mb-md-1">
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="nm">Name:</label>
                                                            <input type="text"
                                                                class="form-control dt-input dt-full-name" id="name"
                                                                onkeyup="reloadTable()" data-column="1"
                                                                placeholder="Alaric Beslier" data-column-index="0" />
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="em/tg">Number of
                                                                followers</label>
                                                            <input type="number" class="form-control dt-input"
                                                                id="follower_number" onkeyup="reloadTable()" data-column="2"
                                                                placeholder="Number of followers"
                                                                data-column-index="1" />
                                                        </div>
                                                        <div class="col-md-4 mb-1">
                                                            <label class="form-label" for="select3-basic">Region</label>
                                                            <select class="select2 form-select multiple-regions"
                                                                onchange="reloadTable()" id="select3-basic" multiple>
                                                                @foreach($all_regions as $region)
                                                                <option value="{{ $region->id }}">{{ $region->region }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-1">
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                for="select0-multiple">Social</label>
                                                            <select class="select2 form-select multiple-socials"
                                                                id="select0-multiple" onchange="reloadTable()" multiple>
                                                                <optgroup label="Select Upto all">
                                                                    @foreach($all_socials as $social)
                                                                    <option value="{{ $social->id }}">{{ $social->social
                                                                        }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                for="select5-multiple">Tags</label>
                                                            <select class="select2 form-select multiple-tags"
                                                                id="select5-multiple" onchange="reloadTable()" multiple>
                                                                <optgroup label="Select Upto all">
                                                                    @foreach($all_tags as $tag)
                                                                    <option value="{{ $tag->id }}">{{ $tag->tag }}
                                                                    </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                for="select6-multiple">Content</label>
                                                            <select class="select2 form-select multiple-contents"
                                                                onchange="reloadTable()" id="select6-multiple" multiple>
                                                                <optgroup label="Select Upto all">
                                                                    @foreach($all_contents as $content)
                                                                    <option value="{{ $content->id }}">{{
                                                                        $content->short_name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-0" />
                                            {{-- DATATABLE--}}
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="form-check">
                                                                <input type="checkbox" name="" id="" class="form-check-input">
                                                            </div>
                                                        </th>
                                                        <th>Name</th>
                                                        <th>contents</th>
                                                        <th>socials</th>
                                                        <th>Followers</th>
                                                        <th>Regions</th>
                                                        <th>TAGS</th>
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
                                                        <th>Name</th>
                                                        <th>contents</th>
                                                        <th>socials</th>
                                                        <th>Followers</th>
                                                        <th>Regions</th>
                                                        <th>TAGS</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-12 col-lg-12 mt-lg-5 pt-lg-1">
                                    <div class="card">
                                        <div class="card-datatable table-responsive">
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
                                
                                <div class="col-12 my-2">
                                    <input type="hidden" name="submit_type" id="submit_type" value="" />
                                    <button type="button" class="btn btn-primary mb-1 csm-25" id="create_btn">Create & Sent to Client</button>
                                    <button type="button" class="btn btn-primary ml-2 top-12" id="draft_btn">Create Draft</button>
                                    <!--<input type="submit" class="btn btn-primary mb-1 csm-25" name="submit_type" value="Create" />-->
                                    <!--<input type="submit" class="btn btn-primary ml-2 top-12" name="submit_type" value="draft" />-->
                                </div>
                            </form>
                        </div>
                        <!--/ Permission Table -->

                        <!-- Add Permission Modal -->
                        <div class="modal fade" id="contentModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-sm-5 pb-5">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">Edit Content</h1>
                                        </div>
                                        <div id="content-modal-body"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Add Permission Modal -->

                        <!-- Edit Permission Modal -->
                        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-3 pt-0">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">Edit Social</h1>
                                        </div>

                                        <div class="alert alert-warning" role="alert">
                                            <h6 class="alert-heading">Warning!</h6>
                                            <div class="alert-body">
                                                By editing the permission name, you might break the system permissions
                                                functionality. Please ensure you're
                                                absolutely certain before proceeding.
                                            </div>
                                        </div>

                                        <form id="editPermissionForm" class="row" onsubmit="return false"
                                            novalidate="novalidate">
                                            <div class="col-sm-9">
                                                <label class="form-label" for="editPermissionName">Social Name</label>
                                                <input type="text" id="editPermissionName" name="editPermissionName"
                                                    class="form-control" placeholder="Enter a Social name" tabindex="-1"
                                                    data-msg="Please enter permission name">
                                            </div>
                                            <div class="col-sm-3 ps-sm-0">
                                                <button type="submit"
                                                    class="btn btn-primary mt-2 waves-effect waves-float waves-light">Update</button>
                                            </div>
                                        </form>
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
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

@endsection
@section('js')
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
                    // d.status = $('#pending').val();
                    // d.created_at = $('#created_at').val();

                },
            },
            columns: [

                {
                    "data": function (data) {

                        if(data.dp_url != null){
                            return ' <div class="form-check">'+
                                '<input type="checkbox" name="" onclick="contentModal(' + data.id + ')" id="check-influencer-'+ data.id +'" class="form-check-input">'+
                                '</div> &nbsp;'+
                                '<a onclick="viewProfile('+data.id+')">  <img src="'+data.dp_url+'" class="me-75" height="50" width="50" alt="Not Found" /> </a>';
                        }
                        else{
                            return ' <div class="form-check">'+
                                '<input type="checkbox" name="" onclick="contentModal(' + data.id + ')" id="check-influencer-'+ data.id +'" class="form-check-input">'+
                                '</div> &nbsp;'+
                                '<a onclick="viewProfile('+data.id+')">  <img src="{{ asset('images/profile.png') }}" class="me-75" height="50" width="50" alt="Not Found" /> </a>';
                        }
                    },
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },

                { data: 'name', name: 'name' },
                
                {
                    "data": function (data) {
                        return data.contents;
                    },
                    "orderable": false, "searchable": false, "name": "selected_rows"
                },
                
                {
                    "data": function (data) {
                        return data.socials;
                    }, "orderable": false, "searchable": false, "name": "selected_rows"
                },
                
                { 
                    "data": function(data){
                        return data.total_follower;
                    }, 
                    "orderable": false, "searchable":false, "name":"selected_rows" 
                },
                
                {
                    "data": function (data) {
                        return data.regions;
                    }, "orderable": false, "searchable": false, "name": "selected_rows"
                },

                {
                    "data": function (data) {
                        return data.tags;
                    }, "orderable": false, "searchable": false, "name": "selected_rows"
                }
            ]
        });
    });
    function reloadTable() {
        dataTable.ajax.reload();
    }
</script>

<script>

    function viewProfile(id) {
        // alert(id);
        var url = "{{ route('influencer_profile', ":id") }}";
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
                id: id
            },
            success: function (data) {
                console.log(data)
                reloadTable();
            }
        });
    }

    function quickEdit(id) {
        var influencer_id = id;
        console.log(id);

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


<script>

    function test(id) {
        var influencer_id = id;
        $.ajax({
            type: 'POST',
            url: '/influencer-campaign',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: influencer_id
            },
            success: function (data) {
                $(".append").append(data);
            }
        });

        var x = $("#select-content-name").val();
    }

    function contentModal(id) {
        
        if($("#check-influencer-"+id).is(':checked'))
        {
            $.ajax({
                type: 'POST',
                url: '/content-modal',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    influencer_id: id
                },
                success: function (data) {
                    $("#content-modal-body").html(data);
                    $('#contentModal').modal('show');
                    // console.log(data)
                }
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: '/remove-influencer',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    influencer_id: id
                },
                success: function (data) {
                    $( '.trt-'+id ).remove();
                }
            });
        }
    }
    
    function removethis(id)
    {
        $.ajax({
            type: 'POST',
            url: '/remove-influencer',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: id
            },
            success: function (data) {
                $( '.trt-'+id ).remove();
                $("#check-influencer-"+id).prop("checked", false);
            }
        });
    }

    function update_content_price(content_id) {
        var price = $(".price-" + content_id).val();
        var influencer_id = $(".influencer-" + content_id).val();

        $.ajax({
            type: 'POST',
            url: '/campaign-content-custom-price',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                influencer_id: influencer_id,
                content_id: content_id,
                price: price
            },
            success: function (data) {
                alert('Price Updated for this Campaign.');
            }
        });

        console.log('Influencer: ' + influencer_id);
        console.log('Price: ' + price);
    }
    
    $(document).on("click", "#create_btn", function () {
        var value = 'create';
        $("#submit_type").val(value);
        $("#add_campaign").submit();
    });
                        
    $(document).on("click", "#draft_btn", function () {
        var value = 'draft';
        $("#submit_type").val(value);
        $("#add_campaign").submit();
    });
</script>
@endsection