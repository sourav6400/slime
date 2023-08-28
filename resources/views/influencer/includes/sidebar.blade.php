<!-- User Sidebar -->
<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <div class="d-flex justify-content-around mb-2">
        <a href="{{ route('all_influencers') }}" class="btn btn-success btn-primary font-medium-3 me-50">
            <i class="fas fa-undo" aria-hidden="true"></i> <span class="fw-bold">Back to all influencers</span>
        </a>
    </div>

    <!-- User Card -->
    <div class="card">
        <div class="card-body">

            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    @if($influencer_details['dp_url'] != null):
                        <img src="{{ $influencer_details['dp_url'] }}" class="img-fluid rounded mt-3 mb-2" height="110" width="110" alt="User avatar" />
                    @else
                        <img src="{{ asset('images/profile.png') }}" class="img-fluid rounded mt-3 mb-2" height="110" width="110" alt="User avatar" />
                    @endif

                    <div class="user-info text-center">
                        <h4>{{ $influencer_details['name'] }}</h4>
                        <span class="badge bg-light-secondary">Author</span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-around my-2 pt-75">
                <div class="d-flex align-items-start me-2">
                    <span class="badge bg-light-primary p-75 rounded">
                        <i data-feather="heart" class="font-medium-2"></i>
                    </span>
                    <div class="ms-75">
                        <h4 class="mb-0">{{ $influencer_details['total_follower'] }}</h4>
                        <small>Total Followers</small>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <span class="badge bg-light-primary p-75 rounded">
                        <i data-feather="briefcase" class="font-medium-2"></i>
                    </span>
                    <div class="ms-75">
                        <h4 class="mb-0">568</h4>
                        <small>Projects Done</small>
                    </div>
                </div>
            </div>
            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Name:</span>
                        <span>{{ $influencer_details['name'] }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Telegram:</span>
                        <a href="{{ $influencer_details['telegram'] }}" target="_blank">
                            <span>{{ $influencer_details['telegram'] }}</span>
                        </a>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Status:</span>
                        <span class="badge bg-light-success">Active</span>
                    </li>

                    <li class="mb-75">
                        @php
                        $influencer_id = $influencer_details['id'];
                        $all_regions = DB::table('influencer_regions')
                            ->where('influencer_id', $influencer_id)
                            ->join('regions', 'influencer_regions.region_id', '=', 'regions.id')
                            ->get();
                        @endphp
                        <span class="fw-bolder me-25">Region:</span>
                        @foreach($all_regions as $key=>$region)
                        <span class="badge bg-light-success">{{ $region->region }}</span>
                        @endforeach
                    </li>

                    <li class="mb-75">
                        <span class="fw-bolder me-25">Email:</span>
                        <span>{{ $influencer_details['email'] }}</span>
                    </li>
                    <!--<li class="mb-75">-->
                    <!--    <span class="fw-bolder me-25">KOL:</span>-->
                    <!--    <span></span>-->
                    <!--</li>-->
                </ul>
                <div class="d-flex justify-content-center pt-2">
                    <a class="btn btn-primary me-1" onclick="quickEdit({{ $influencer_details['id'] }})">Edit</a>
                    <a data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-influencer_id="{{ $influencer_details['id'] }}" class="btn btn-outline-danger suspend-user delete-influencer">Suspended</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Card -->

    <!-- Plan Card -->
    <div class="card border-primary">
        <div class="card-header d-flex justify-content-between">
            <h3 class="text-center">Tags</h3>
            <!--<a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#edittags" data-bs-toggle="modal">-->
            <!--    Edit-->
            <!--</a>-->
        </div>
        <div class="card-body">
            @php
            $influencer_id = $influencer_details['id'];
            $all_tags = DB::table('influencer_tags')
                ->where('influencer_id', $influencer_id)
                ->join('tags', 'influencer_tags.tag_id', '=', 'tags.id')
                ->get();
            @endphp
            @foreach($all_tags as $key=>$tag)
                <span class="badge rounded-pill badge-light-info link-bottom">{{ $tag->tag }}</span>
            @endforeach
        </div>
    </div>
    <!-- /Plan Card -->
</div>
<!--/ User Sidebar -->


<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
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
                    <input type="hidden" name="influencer_id" value="{{ $influencer_details['id']}}" />
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserFirstName">Name</label>
                        <input type="text" id="modalEditUserFirstName" name="influencer_name" class="form-control" value="{{$influencer_details['name']}}" placeholder="Your Name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserLastName">Telegram</label>
                        <input type="text" id="modalEditUserLastName" name="influencer_telegram" class="form-control" value="{{ $influencer_details['telegram'] }}" placeholder="Your Telegram" />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="modalEditUserName">Email</label>
                        <input type="email" id="modalEditUserName" name="influencer_email" class="form-control" value="{{ $influencer_details['email'] }}" placeholder="example@gmail.com" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="select3-basic">Region</label>
                        <select class="select2 form-select" name="influencer_regions[]" id="region" multiple required>
                            @foreach($all_regions_profile as $region)
                            <option value="{{$region->id}}">{{$region->region}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--<div class="col-12 col-md-6">-->
                    <!--    <label class="form-label" for="modalEditkol">KOL</label>-->
                    <!--    <select id="modalEditkol" name="modalEditUserStatus" class="form-select" aria-label="Default select example">-->
                    <!--        <option selected>Something</option>-->
                    <!--        <option value="1">India</option>-->
                    <!--        <option value="2">Bangladesh</option>-->
                    <!--    </select>-->
                    <!--</div>-->

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="select3-basic">Tags</label>
                        <select class="select2 form-select" name="influencer_tags[]" id="tag" multiple required>
                            @foreach($all_tags_profile as $tag)
                            <option value="{{$tag->id}}">{{$tag->tag}}</option>
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

                        <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_influencer') }}" method="POST">
                            @csrf
                            <input type="hidden" value="" id="influencer_id_to_delete" name="influencer_id_to_delete" />

                            <div class="col-sm-12 ps-sm-0 text-center">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes, Delete it</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    No, Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Delete Modal -->

    <div class="modal fade" id="editUserAjax" tabindex="-1" aria-hidden="true">

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    $(document).on("click", ".delete-influencer", function () {
        var influencer_id = $(this).data('influencer_id');

        $("#influencer_id_to_delete").val( influencer_id );
    });

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
                $("#editUserAjax").html(data);
                $("#editUserAjax").modal("show");
                // console.log(data)
                // alert(data)
            }
        });
    }
</script>
