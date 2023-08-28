@extends('layouts.app')

@section('title') {{ 'Favourite Influencers' }} @endsection

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
                <section id="advanced-search-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom d-flex justify-content-between">
                                    <h4 class="card-title">Favourite Influencers</h4>
                                    @php
                                    $role_id = Auth::user()->role;
                                    $influencer_permission = DB::table('influencer_permission')->where('role_id', $role_id)->first();
                                    @endphp
                                </div>
                                <!--Search Form -->
                                <div class="card-body mt-2">
                                    
                                </div>
                                <hr class="my-0" />
                                <div class="card-datatable table-responsive">
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
                                                <th>TG Handle</th>
                                                <th>Region</th>
                                                <th>Tags</th>
                                                <th>Social</th>
                                                <th>Content</th>
                                                <th>Total Flowers</th>
                                                <!--<th>Status</th>-->
                                                @if($influencer_permission != null && $influencer_permission->edit == 1)
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fav_influencers as $key=>$influencer)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="" id="check1" class="form-check-input">
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($influencer->is_favourite == 1)
                                                    <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'" style="color: red;"></i>
                                                    @elseif($influencer->is_favourite == 0)
                                                    <i class="fa fa-heart fav-btn" aria-hidden="true" onclick="window.location.href='{{ url('change-fav-status/'.$influencer->id) }}'"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('influencer-profile/'.$influencer->id) }}">
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
                                                <!--<td><span class="badge rounded-pill badge-light-primary me-1">Active</span></td>-->
                                                @if($influencer_permission != null && $influencer_permission->edit == 1)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                            data-bs-toggle="dropdown">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" class="dropdown-item"
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
                                                <th>TG Handle</th>
                                                <th>Region</th>
                                                <th>Tags</th>
                                                <th>Social</th>
                                                <th>Content</th>
                                                <th>Total Flowers</th>
                                                <!--<th>Status</th>-->
                                                @if($influencer_permission != null && $influencer_permission->edit == 1)
                                                <th>Action</th>
                                                @endif
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
    
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
function quickEdit(id) {
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
        }
    });
}
$(document).ready(function(){
    $(".change-fav-status").change(function() {
        $(".change-fav-status-form").submit(); // Submit the form
    });
});
</script>
@endsection