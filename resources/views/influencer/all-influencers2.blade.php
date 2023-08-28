@extends('layouts.app')

@section('content')

<style>
.fav-chk {
  display: none;
}

/* changes the color when selected */
input:checked ~ label {
  color: red;
}

/* for styling purpose only */
label {
  font-size: 2em;
}
</style>

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
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">Advanced Filter</h4>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <button
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
                                            </svg>Export</span></button>
                                            
                                    @php
                                    $role_id = Auth::user()->role;
                                    $influencer_permission = DB::table('influencer_permission')->where('role_id', $role_id)->first();
                                    @endphp
                                    
                                    @if($influencer_permission != null && $influencer_permission->create == 1)
                                    <a class="btn btn-primary" href="{{ route('add_new_influencer') }}">Add New Influencer</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--Search Form -->
                        <div class="card-body mt-2">
                            <form class="dt_adv_search" method="POST">
                                <div class="row g-1 mb-md-1">
                                    <div class="col-md-4">
                                        <label class="form-label">Name:</label>
                                        <input type="text" class="form-control dt-input dt-full-name" id="name"
                                            onkeyup="filterEvent()" data-column="1" placeholder="Alaric Beslier"
                                            data-column-index="0" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Number of followers</label>
                                        <input type="number" class="form-control dt-input" id="email"
                                            onkeyup="filterEvent()" data-column="2" placeholder="Number of followers"
                                            data-column-index="1" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select3-basic">Region</label>
                                        <select class="select2 form-select multiple-regions" onchange="filterEvent()"
                                            id="select3-basic" multiple>
                                            @foreach($all_regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-1">
                                    <div class="col-md-4">
                                        <label class="form-label" for="select0-multiple">Social</label>
                                        <select class="select2 form-select multiple-socials" id="select0-multiple"
                                            onchange="filterEvent()" multiple>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_socials as $social)
                                                <option value="{{ $social->id }}">{{ $social->social }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select5-multiple">Tags</label>
                                        <select class="select2 form-select multiple-tags" id="select5-multiple"
                                            onchange="filterEvent()" multiple>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select6-multiple">Content</label>
                                        <select class="select2 form-select multiple-contents" onchange="filterEvent()"
                                            id="select6-multiple" multiple>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_contents as $content)
                                                <option value="{{ $content->id }}">{{ $content->short_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr class="my-0" />
                        
                        <div>
                            @php
                            
                            @endphp
                        </div>

                        <!--All Influencer Table starts here-->
                        <div class="card-datatable table-responsive" id="all_influencers" style="display: block;">
                            <table class="dt-advanced-search table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="" id="select-all">
                                            </div>
                                        </th>
                                        <th>Favourite</th>
                                        <th>Name</th>
                                        <th>TG Handle / Email</th>
                                        <th>Region</th>
                                        <th>Tags</th>
                                        <th>Social</th>
                                        <th>Content</th>
                                        <th>Total Flowers</th>
                                        <th>Favourite</th>
                                        <!--<th>Status</th>-->
                                        @if($influencer_permission != null && $influencer_permission->edit == 1)
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_influencers as $key=>$influencer)
                                    <tr class="all-influencer-row" id="all-influencer-row-{{ $influencer->id }}">
                                        
                                        @php
                                        // Twitter API
                                        $influencer_id = $influencer->id;
                                        $twitter_detail = DB::table('influencer_socials')
                                            ->where('influencer_id', $influencer_id)
                                            ->where('social_id', $twitterId)
                                            ->first();
                                            
                                        $twitter_followers_count = null;
                                        $twitter_profile_image_url = null;
                                        if($twitter_detail){
                                            $twitter_link= $twitter_detail->social_address;
                                            $twitter_arr = explode('/', $twitter_link);
                                            $twitter_arr = array_reverse($twitter_arr);
                                            $twitter_username = $twitter_arr[0];
                                            
                                            if($twitter_username){
                                                $response = $connection->get("users/search", ["q" => $twitter_username ]);
                                                if(isset($response[0]->id)){
                                                    $twitter_profile_image_url = str_replace('_normal','',$response[0]->profile_image_url_https);
                                                    $twitter_followers_count = $response[0]->followers_count;
                                                }
                                            }
                                        }
                                        // Twitter API
                                        
                                        $youtube_followers_count = 0;
                                        
                                        $total_followers = $twitter_followers_count + $youtube_followers_count;
                                        @endphp
                                        
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="check1" class="form-check-input">
                                            </div>
                                        </td>
                                        <td>
                                            <input class="fav-chk" type="checkbox" id="heart-{{ $key }}">
                                            <label for="heart">&#9829</label>
                                        </td>
                                        <td>
                                            <a href="{{ url('influencer-profile/'.$influencer->id) }}">
                                                @if($twitter_profile_image_url != null):
                                                    <img src="{{ $twitter_profile_image_url }}" class="me-75" height="50" width="50" alt="Not Found" />
                                                @else
                                                    <img src="{{ asset('images/profile.png') }}" class="me-75" height="50" width="50" alt="Not Found" />
                                                @endif
                                                <span class="fw-bold text-light">{{ $influencer->name }}</span>
                                            </a>
                                        </td>
                                        <td id="telegram-main-{{ $influencer->id }}">
                                            <a class="badge rounded-pill badge-light-success link-bottom"
                                                target="_blank" href="{{ ($influencer->telegram) }}">Telegram</i></a>
                                        </td>
                                        <td class="">
                                            @php
                                            $influencer_id = $influencer->id;
                                            $all_regions = DB::table('influencer_regions')
                                            ->where('influencer_id', $influencer_id)
                                            ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')
                                            ->get();
                                            @endphp

                                            @foreach($all_regions as $key=>$region)
                                            <span class="badge rounded-pill badge-light-info link-bottom">{{
                                                $region->region }}</span>
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
                                            <a class="badge rounded-pill badge-light-success link-bottom"
                                                target="_blank" href="{{$val->social_address}}">{{$val->social}}</a>
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
                                            <span
                                                class="badge rounded-pill badge-light-info link-bottom">{{$content->short_name}}-
                                                {{$content->price}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <h5>{{ $total_followers }}</h5>
                                        </td>
                                        <td class="text-center">
                                            @if($influencer->is_favourite == 1)
                                            <input type="checkbox" class="form-check-input"
                                                onchange="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'" id="heart"
                                                checked>
                                            @elseif($influencer->is_favourite == 0)
                                            <input type="checkbox" class="form-check-input"
                                                onchange="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'" id="heart">
                                            @endif
                                        </td>
                                        <!--<td><span class="badge rounded-pill badge-light-primary me-1">Active</span></td>-->
                                        
                                        @if($influencer_permission != null && $influencer_permission->edit == 1)
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                    data-bs-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a type="button" class="dropdown-item"
                                                        onclick="quickEdit({{ $influencer->id }})">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a class="dropdown-item delete-influencer" data-bs-toggle="modal"
                                                        data-bs-target="#deletePermissionModal"
                                                        data-influencer_id="{{ $influencer->id }}">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="" class="form-check-input">
                                            </div>
                                        </th>
                                        <th>Favourite</th>
                                        <th>Name</th>
                                        <th>TG Handle / Email</th>
                                        <th>Region</th>
                                        <th>Tags</th>
                                        <th>Social</th>
                                        <th>Content</th>
                                        <th>Followers</th>
                                        <th>Favourite</th>
                                        <!--<th>Status</th>-->
                                        @if($influencer_permission != null && $influencer_permission->edit == 1)
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!--All Influencer Table ends here-->

                        <div id="filtered_influencers">

                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return true" method="POST" action="{{ route('edit_profile') }}">
                    @csrf
                    <input type="hidden" name="influencer_id" id="influencer_id" value="" />
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserFirstName">Name</label>
                        <input type="text" id="influencer_name" name="influencer_name" class="form-control" value="" placeholder="Your Name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserLastName">Telegram</label>
                        <input type="text" id="influencer_telegram" name="influencer_telegram" class="form-control" value="" placeholder="Your Telegram" />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="modalEditUserName">Email</label>
                        <input type="email" id="influencer_email" name="influencer_email" class="form-control" value="" placeholder="example@gmail.com" />
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
                                    <option value="{{$tag->id}}" >{{$tag->tag}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
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


<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<!--<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>-->
<!--        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
<!--        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->

<script>
    function filterEvent() {
        var name = $("#name").val();
        var email = $("#email").val();
        var regions = $(".multiple-regions").val();
        var socials = $(".multiple-socials").val();
        var tags = $(".multiple-tags").val();
        var contents = $(".multiple-contents").val();

        console.log(regions)

        $.ajax({
            type: 'POST',
            url: '/influencer-filter',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                name: name,
                email: email,
                regions: regions,
                socials: socials,
                tags: tags,
                contents: contents
            },
            success: function (data) {
                $("#all_influencers").hide()
                $("#filtered_influencers").html(data);
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
        // $("#editUser").modal("show");

        // $("mybtn").click(function () {
        //     $("#editUser").modal("show");
        // });
    }

    $(document).on("click", ".delete-influencer", function () {
        var influencer_id = $(this).data('influencer_id');
        $("#influencer_id_to_delete").val(influencer_id);
    });
    
    $(document).on("click", ".edit-influencer", function(){
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
@endsection