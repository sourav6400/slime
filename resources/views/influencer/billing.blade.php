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
        <section class="app-user-view-billing">
            <div class="row">
                <!-- User Sidebar -->
                @include('influencer.includes.sidebar')
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <ul class="nav nav-pills mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/connections/'.$influencer_details['id']) }}">
                                <i data-feather="link" class="font-medium-3 me-50"></i><span class="fw-bold">Social Media</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('influencer/billing/'.$influencer_details['id']) }}">
                                <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Content & Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer-profile/'.$influencer_details['id']) }}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Account</span>
                            </a>
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

                    <!-- current plan -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Content</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewContentCard">
                                <i data-feather="plus"></i>
                                <span>Add New Content</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class=" col-12 pb-1">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Content</th>
                                                    <th>Short Name</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $influencer_id = $influencer_details['id'];
                                                $all_contents = DB::table('influencer_contents')
                                                    ->where('influencer_id', $influencer_id)
                                                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                    ->get();
                                                @endphp
                                                    
                                                @foreach($all_contents as $key=>$content)
                                                <tr>
                                                    <td>
                                                        @php
                                                            $social_media = null;
                                                            if($content->social_id != null)
                                                            {
                                                                $social = DB::table('socials')->where('id', $content->social_id)->first();
                                                                $social_media = $social->social;
                                                            }
                                                        @endphp
                                                        
                                                        @if($social_media == 'Twitter')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #00acee;">
                                                        @elseif($social_media == 'Youtube')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #CD201F;">
                                                        @elseif($social_media == 'Facebook')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #3b5998;">
                                                        @elseif($social_media == 'Linkedin')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #0072b1;">
                                                        @elseif($social_media == 'TikTok')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #ff0050;">
                                                        @elseif($social_media == 'Instagram')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #962fbf;">
                                                        @else
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                        @endif
                                                            <span class="fw-bold" style="color: #ffffff;">{{$content->content_name}}</span>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($social_media == 'Twitter')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #00acee;">
                                                        @elseif($social_media == 'Youtube')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #CD201F;">
                                                        @elseif($social_media == 'Facebook')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #3b5998;">
                                                        @elseif($social_media == 'Linkedin')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #0072b1;">
                                                        @elseif($social_media == 'TikTok')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #ff0050;">
                                                        @elseif($social_media == 'Instagram')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #962fbf;">
                                                        @else
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                        @endif
                                                            <span class="fw-bold" style="color: #ffffff;">{{$content->short_name}}</span>
                                                        </span>
                                                    </td>
                                                    <td><span class="fw-bold">${{$content->price}} </span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item edit-content" data-bs-toggle="modal" data-bs-target="#editContentCard" 
                                                                data-content_id="{{$content->id}}" data-content_price="{{$content->price}}" data-content_name="{{$content->short_name}}">
                                                                    <i data-feather="edit-2" class="me-50"></i> <span>Edit</span>
                                                                </a>
                                                                <button class="dropdown-item delete-content" data-bs-toggle="modal" data-bs-target="#deleteContentModal" 
                                                                data-content_id_delete_modal="{{ $content->id }}"><i data-feather="trash" class="me-50"></i> <span>Delete</span></button>
                                                                
                                                                <!--<a class="dropdown-item" href="#">-->
                                                                <!--    <i data-feather="edit-2" class="me-50"></i>-->
                                                                <!--    <span>Edit</span>-->
                                                                <!--</a>-->
                                                                <!--<a class="dropdown-item" href="#">-->
                                                                <!--    <i data-feather="trash" class="me-50"></i>-->
                                                                <!--    <span>Delete</span>-->
                                                                <!--</a>-->
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / current plan -->

                    <!-- payment methods -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-50">Wallet</h4>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                <i data-feather="plus"></i>
                                <span>Add New Wallet</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="added-cards">
                                @php
                                $influencer_id = $influencer_details['id'];
                                $all_wallets = DB::table('influencer_wallets')
                                    ->where('influencer_id', $influencer_id)
                                    ->join('wallets', 'influencer_wallets.wallet_id', '=', 'wallets.id')
                                    ->get();
                                @endphp
                                
                                @foreach($all_wallets as $key=>$wallet)
                                <div class="cardMaster rounded border p-2 mb-1">
                                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                                        <div class="card-information">
                                            <!--<img class="mb-1 img-fluid" src="app-assets/images/icons/payments/mastercard.png" alt="Master Card" />-->
                                            <div class="d-flex align-items-center mb-50">
                                                <h6 class="mb-0">{{$wallet->wallet_type}}</h6>
                                                <!--<span class="badge badge-light-primary ms-50">Primary</span>-->
                                            </div>
                                            <span class="card-number">{{$wallet->wallet_address}}<span>
                                        </div>
                                        <div class="d-flex flex-column text-start text-lg-end">
                                            <div class="d-flex order-sm-0 order-1 mt-1 mt-sm-0">
                                                <button class="btn btn-outline-primary me-75 edit-wallet" data-bs-toggle="modal" data-bs-target="#editCard" data-wallet_id="{{$wallet->id}}" data-wallet_type="{{$wallet->wallet_type}}" data-wallet_address="{{$wallet->wallet_address}}">
                                                    Edit
                                                </button>
                                                <button class="btn btn-outline-secondary delete-wallet" data-bs-toggle="modal" data-bs-target="#deleteWalletModal" data-wallet_id_delete_modal="{{ $wallet->id }}">Delete</button>
                                            </div>
                                            <!--<span class="mt-2">Card expires at 12/24</span>-->
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- / payment methods -->
                </div>
                <!--/ User Content -->
            </div>
        </section>
        
        <!-- edit card modal  -->
        <div class="modal fade" id="editCard" tabindex="-1" aria-labelledby="editCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="editCardTitle">Edit Wallet</h1>

                        <!-- form -->
                        <form id="editCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('edit_influencer_wallet') }}">
                            @csrf
                            <input type="hidden" name="influencer_id" value="{{ $influencer_details['id'] }}" />
                            <input type="hidden" name="wallet_id" id="wallet_id" value="" />
                            <div class="col-12">
                                <label class="form-label" for="modalEditCardNumber">Wallet Type</label>
                                <div class="input-group input-group-merge">
                                    <input id="wallet_type" value="" name="wallet_type" class="form-control credit-card-mask" type="text" placeholder="Wallet Name" aria-describedby="modalEditCard2" disabled onblur="disable(this)" readonly />
                                    <span class="input-group-text cursor-pointer p-25" id="modalEditCard2">
                                        <span class="edit-card-type"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalEditCardName">Wallet Address</label>
                                <input type="text" value="" name="wallet_address" id="wallet_address" class="form-control" placeholder="Paste Your Address" />
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
        <!--/ edit card modal  -->
        
        <!-- edit content card modal  -->
        <div class="modal fade" id="editContentCard" tabindex="-1" aria-labelledby="editCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="editCardTitle">Edit Content</h1>
                        <form id="editCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('edit_influencer_content') }}">
                            @csrf
                            <input type="hidden" name="influencer_id" value="{{ $influencer_details['id'] }}" />
                            <input type="hidden" name="content_id" id="content_id" value="" />
                            <div class="col-12">
                                <label class="form-label" for="modalEditCardNumber">Content Name</label>
                                <div class="input-group input-group-merge">
                                    <input id="content_name" value="" name="content_name" class="form-control credit-card-mask" type="text" placeholder="Wallet Name" aria-describedby="modalEditCard2" disabled onblur="disable(this)" readonly />
                                    <span class="input-group-text cursor-pointer p-25" id="modalEditCard2">
                                        <span class="edit-card-type"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalEditCardName">Price</label>
                                <input type="number" value="" name="content_price" id="content_price" class="form-control" placeholder="Paste Your Address" />
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
        
        <!-- add new Content card modal  -->
        <div class="modal fade" id="addNewContentCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="addNewCardTitle">Add New Content</h1>

                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('add_new_influencer_content') }}">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" name="influencer_id" />
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Content Name</label>
                                <select class="select2 form-select" name="content_id" required>
                                    @foreach($all_contents_profile as $content)
                                    <option value="{{ $content->id }}">{{ $content->content_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Price</label>
                                <input type="number" id="modalAddCardName" name="price" class="form-control" placeholder="Paste Your Content Price" required />
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
        <!--/ add new Content card modal  -->
        
        <!-- add new card modal  -->
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <h1 class="text-center mb-1" id="addNewCardTitle">Add New Wallet</h1>

                        <!-- form -->
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return true" method="POST" action="{{ route('add_new_influencer_wallet') }}">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" name="influencer_id" />
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Wallet Name</label>
                                <!--<div class="input-group input-group-merge">-->
                                    <!--<input id="modalAddCardNumber" name="modalAddCard" class="form-control add-credit-card-mask" type="text" placeholder="Wallet Name" aria-describedby="modalAddCard2" />-->
                                    
                                    <select class="select2 form-select" name="wallet_id" required>
                                        @foreach($all_wallets_profile as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->wallet_type }}</option>
                                        @endforeach
                                    </select>
                                    <!--<span class="input-group-text cursor-pointer p-25" id="modalAddCard2">-->
                                    <!--    <span class="add-card-type"></span>-->
                                    <!--</span>-->
                                <!--</div>-->
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Wallet Address</label>
                                <input type="text" id="modalAddCardName" name="wallet_address" class="form-control" placeholder="Paste Your Address" required />
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
        
        
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteWalletModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Delete Wallet</h1>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Confirmation!</h6>
                            <div class="alert-body">
                                Do you want to delete this Wallet?
                            </div>
                        </div>

                        <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_influencer_wallet') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" id="influencer_id_to_delete" name="influencer_id_to_delete" />
                            <input type="hidden" value="" id="wallet_id_to_delete" name="wallet_id_to_delete" />
                            
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
        
        <!-- Content Delete Modal -->
        <div class="modal fade" id="deleteContentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Delete Content</h1>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Confirmation!</h6>
                            <div class="alert-body">
                                Do you want to delete this Content?
                            </div>
                        </div>

                        <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_influencer_content') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $influencer_details['id'] }}" id="influencer_id_to_delete" name="influencer_id_to_delete" />
                            <input type="hidden" value="" id="content_id_to_delete" name="content_id_to_delete" />
                            
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
        <!--/ Content Delete Modal -->

    </div>
</div>
<!-- END: Content-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    $(document).on("click", ".edit-wallet", function () {
        var wallet_id = $(this).data('wallet_id');
        var wallet_type = $(this).data('wallet_type');
        var wallet_address = $(this).data('wallet_address');
        
        $("#wallet_id").val( wallet_id );
        $("#wallet_type").val( wallet_type );
        $("#wallet_address").val( wallet_address );
    });
    
    $(document).on("click", ".edit-content", function () {
        var content_id = $(this).data('content_id');
        var content_name = $(this).data('content_name');
        var content_price = $(this).data('content_price');
        
        $("#content_id").val( content_id );
        $("#content_name").val( content_name );
        $("#content_price").val( content_price );
    });
    
    $(document).on("click", ".delete-wallet", function () {
        var wallet_id = $(this).data('wallet_id_delete_modal');
        
        $("#wallet_id_to_delete").val( wallet_id );
    });
    
    $(document).on("click", ".delete-content", function () {
        var content_id = $(this).data('content_id_delete_modal');
        
        $("#content_id_to_delete").val( content_id );
    });
    
    
</script>

@endsection