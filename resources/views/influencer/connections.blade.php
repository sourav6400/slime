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
        <section class="app-user-view-connections">
            <div class="row">
                <!-- User Sidebar -->
                @include('influencer.includes.sidebar')
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <ul class="nav nav-pills mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('influencer/connections/'.$influencer_details['id']) }}">
                                <i data-feather="link" class="font-medium-3 me-50"></i><span class="fw-bold">Social Media</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/billing/'.$influencer_details['id']) }}">
                                <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Content & Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer-profile/'.$influencer_details['id']) }}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Account</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/notification/'.$influencer_details['id']) }}">
                                <i data-feather="bell" class="font-medium-3 me-50"></i><span class="fw-bold">Notifications</span>
                            </a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="{{ url('influencer/security/'.$influencer_details['id']) }}">-->
                        <!--        <i data-feather="lock" class="font-medium-3 me-50"></i>-->
                        <!--        <span class="fw-bold">Security</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                    <!--/ User Pills -->

                    <!-- connection -->

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Social Accounts</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewConnectionCard">
                                <i data-feather="plus"></i>
                                <span>Add New Connection</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <!--<h4 class="card-title mb-75">Social accounts</h4>-->
                            <p>Display content from social accounts on your site</p>
                            <!-- Social Accounts -->
                            @php
                            $influencer_id = $influencer_details['id'];
                            $all_socials = DB::table('influencer_socials')
                                ->where('influencer_id', $influencer_id)
                                ->join('socials', 'influencer_socials.social_id', '=', 'socials.id')
                                ->get();
                            @endphp
                            
                            @foreach($all_socials as $key=>$social)
                            <div class="d-flex mt-2">
                                <div class="flex-shrink-0">
                                    <!--<img src="{{ asset('app-assets/images/icons/social/facebook.png') }}" alt="facebook" class="me-1" height="38" width="38" />-->
                                </div>
                                <div class="d-flex justify-content-between flex-grow-1">
                                    <div class="me-1">
                                        <a href="{{ $social->social_address }}" target="_blank" class="fw-bolder mb-0">{{ strtoupper($social->social) }}</a>
                                        <!--<span>Not Connected</span>-->
                                    </div>
                                    <div class="mt-50 mt-sm-0">
                                        <a href="{{ $social->social_address }}" target="_blank" type="button" class="btn-sm btn-icon btn-outline-secondary">
                                            <i data-feather="link" class="font-medium-3"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                                            
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item edit-social" data-bs-toggle="modal" data-bs-target="#editSocialCard" 
                                            data-social_id="{{$social->id}}" data-social="{{$social->social}}" data-social_address="{{$social->social_address}}">
                                            <i data-feather="edit-2" class="me-50"></i> <span>Edit</span>
                                        </a>
                                        <button class="dropdown-item delete-social" data-bs-toggle="modal" data-bs-target="#deleteSocialCard" 
                                            data-social_id_delete_modal="{{ $social->id }}"><i data-feather="trash" class="me-50"></i> <span>Delete</span></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!--<img src="{{ asset('app-assets/images/icons/social/twitter.png') }}" alt="twitter" class="me-1" height="38" width="38" />-->
                            <!--<img src="{{ asset('app-assets/images/icons/social/linkedin.png') }}" alt="instagram" class="me-1" height="38" width="38" />-->
                            <!--<img src="{{ asset('app-assets/images/icons/social/dribbble.png') }}" alt="dribbble" class="me-1" height="38" width="38" />-->
                            <!--<img src="{{ asset('app-assets/images/icons/social/behance.png') }}" alt="behance" class="me-1" height="38" width="38" />-->
                            
                            <!-- /Social Accounts -->
                        </div>
                    </div>
                    <!--/ connection -->
                </div>
                <!--/ User Content -->
            </div>
        </section>
        
        <!-- edit content card modal  -->
        <div class="modal fade" id="editSocialCard" tabindex="-1" aria-labelledby="editCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="editCardTitle">Edit Social Account</h1>
                        <form id="editCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('edit_influencer_social') }}">
                            @csrf
                            <input type="hidden" name="influencer_id" value="{{ $influencer_details['id'] }}" />
                            <input type="hidden" name="social_id" id="social_id" value="" />
                            <div class="col-12">
                                <label class="form-label" for="modalEditCardNumber">Social Name</label>
                                <div class="input-group input-group-merge">
                                    <input id="social_name" value="" name="social_name" class="form-control credit-card-mask" type="text" placeholder="Social Name" aria-describedby="modalEditCard2" disabled onblur="disable(this)" readonly />
                                    <span class="input-group-text cursor-pointer p-25" id="modalEditCard2">
                                        <span class="edit-card-type"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalEditCardName">Address</label>
                                <input type="url" value="" name="social_address" id="social_address" class="form-control" placeholder="Paste Your Social Address" />
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Update</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ edit content card modal  -->
        
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteSocialCard" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Delete Social Account</h1>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Confirmation!</h6>
                            <div class="alert-body">
                                Do you want to delete this Social Account?
                            </div>
                        </div>

                        <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_influencer_social') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" id="influencer_id_to_delete" name="influencer_id_to_delete" />
                            <input type="hidden" value="" id="social_id_delete" name="social_id_delete" />
                            
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
        
        <!-- add new card modal  -->
        <div class="modal fade" id="addNewConnectionCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="addNewCardTitle">Add New Social Account</h1>

                        <!-- form -->
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('add_new_influencer_social') }}">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" name="influencer_id" />
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Social Name</label>
                                <select class="select2 form-select" name="social_id" required>
                                    @foreach($all_socials_profile as $social)
                                    <option value="{{ $social->id }}">{{ $social->social }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Social Address</label>
                                <input type="text" id="modalAddCardName" name="social_address" class="form-control" placeholder="Paste Your Address" required />
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Save</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ add new card modal  -->

    </div>
</div>
<!-- END: Content-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    $(document).on("click", ".edit-social", function () {
        var social_id = $(this).data('social_id');
        var social = $(this).data('social');
        var social_address = $(this).data('social_address');
        
        $("#social_id").val( social_id );
        $("#social_name").val( social );
        $("#social_address").val( social_address );
    });
    
    $(document).on("click", ".delete-social", function () {
        var social_id = $(this).data('social_id_delete_modal');
        
        $("#social_id_delete").val( social_id );
    });
</script>
@endsection