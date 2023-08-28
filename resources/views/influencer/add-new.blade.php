@extends('layouts.app')

@section('title') {{ 'Add New Influencer' }} @endsection

@section('content')
<!-- BEGIN: Content-->
    <!--<div class="app-content content ">-->
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <!-- Select2 Start  -->
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add New Influencer</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" id="add_influencer" method="POST" action="{{ route('add_new_influencer') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="first-name-column">Name</label>
                                                    <input type="text" name="name" id="first-name-column" class="form-control" placeholder="Your Name" name="fname-column" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label">Contact Type</label>
                                                    <select class="form-select" id="contact_type" name="contact_type">
                                                        <option value="telegram">Telegram</option>
                                                        <option value="email">E-mail</option>
                                                        <option value="mobile">Mobile</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="last-name-column">Contact</label>
                                                    <input type="text" name="contact" id="contact" class="form-control" placeholder="Your Contact" name="lname-column" />
                                                </div>
                                            </div>  
                                            <div class="col-md-6 col-12 mb-1">
                                                <label class="form-label" for="select3-basic">Region</label>
                                                <select class="select2 form-select" name="regions[]" multiple >
                                                    <optgroup label="Select Upto all">
                                                        @foreach($all_regions as $region)
                                                        <option value="{{ $region->id }}">{{ $region->region }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <input type="hidden" name="email" value="" name="email" />
                                            <div class="col-md-6 col-12 mb-1">
                                                <label class="form-label" for="select5-multiple">Tags</label>
                                                <select class="select2 form-select" name="tags[]" id="select5-multiple" multiple >
                                                    <optgroup label="Select Upto all">
                                                        @foreach($all_tags as $tag)
                                                            <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <!--<div class="mb-1 form-password-toggle col-md-6">-->
                                            <!--    <label class="form-label" for="password">Password</label>-->
                                            <!--    <input type="password" name="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>-->
                                            <!--</div>-->
                                            <!--<div class="mb-1 form-password-toggle col-md-6">-->
                                            <!--    <label class="form-label" for="confirm-password">Confirm Password</label>-->
                                            <!--    <input type="password" name="confirm_password" id="confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>-->
                                            <!--</div>-->
                                            <div class="col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Social</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="invoice-repeater">
                                                                    <div data-repeater-list="social">
                                                                        <div data-repeater-item>
                                                                            <div class="row d-flex align-items-end">
                                                                                <div class="col-md-3 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="select-social">Social Name</label>
                                                                                        <select class="form-select" name="name" id="select-social" >
                                                                                            @foreach($all_socials as $social)
                                                                                                @if($social->social == 'Twitter')
                                                                                                    <option value="{{ $social->id }}" selected>{{ $social->social }}</option>
                                                                                                @else
                                                                                                    <option value="{{ $social->id }}">{{ $social->social }}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-7 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="itemcost">Profile Address</label>
                                                                                        <input type="url" name="address" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="Profile Address" />
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-2 col-20">
                                                                                    <div class="mb-1">
                                                                                        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
                                                                                            <i data-feather="x" class="me-25"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary sign-log-btn" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Content Type</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <form action="#" class="invoice-repeater">
                                                                   <div class="invoice-repeater">
                                                                    <div data-repeater-list="content">
                                                                        <div data-repeater-item>
                                                                            <div class="row d-flex align-items-end">
                                                                                <div class="col-md-5 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="select-content-name">Content Name</label>
                                                                                        <select class="form-select" name="content" id="select-content-name">
                                                                                            @foreach($all_contents as $content)
                                                                                            <option value="{{ $content->id }}">{{ $content->short_name }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label for="price">Price</label>
                                                                                        <div class="top-25" onclick="edit(this)"><input class="price-change" name="price" value="15" id="price"></div>
                                                                                        <!--<div class="top-25" ondlclick="edit(this)"><input class="price-change" value="$15" id="price" disabled onblur="disable(this)"></div>-->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-1 col-12">
                                                                                    <div class="mb-1">
                                                                                        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
                                                                                            <i data-feather="x" class="me-25"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary sign-log-btn" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                   </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Wallet</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div action="#" class="invoice-repeater">
                                                                    <div data-repeater-list="wallet">
                                                                        <div data-repeater-item>
                                                                            <div class="row d-flex align-items-end">
                                                                                <div class="col-md-4 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="select-wallet">Wallet Type</label>
                                                                                        <select class="form-select" name="type" id="select-wallet">
                                                                                            @foreach($all_wallets as $wallet)
                                                                                            <option value="{{ $wallet->id }}">{{ $wallet->wallet_type }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-4 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="itemcost">Wallet Address</label>
                                                                                        <input type="number" name="address" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="Paste Your Address" />
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-4 col-20">
                                                                                    <div class="mb-1">
                                                                                        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
                                                                                            <i data-feather="x" class="me-25"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary sign-log-btn" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="exampleFormControlTextarea1">Notes</label>
                                                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Type here something"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary me-1 sign-log-btn">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Select2 End -->
            </div>
        </div>
    <!--</div>-->
    <!-- END: Content-->
    
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    
    <script>
    $('#add_influencer').on('submit',function(){
        var contact_type = $("#contact_type").val();
        var contact = $("#contact").val();
        var regexPattern = /^[a-zA-Z0-9]+$/;
        
        console.log(contact);
        if(contact_type == 'telegram' && contact.length > 0)
        {
            if(regexPattern.test(contact))
            {
                // alert("UserName is Valid");
                return true;
            }
            else
            {
                alert("Enter a Valid UserName");
                return false;
            }
        }
        else {
            return true;
        }
    })
    
    // function validateUserName()
    // {
    //     // var contact_type = document.getElementById("contact_type").value;
    //     var inputValue = document.getElementById("contact").value;
    //     var regexPattern = /^[a-zA-Z0-9]+$/;
        
    //     // console.log(contact_type);
        
    //     // var alert(contact_type);
        
    //     if(regexPattern.test(inputValue))
    //     {
    //         alert("UserName is Valid");
    //         return true;
    //     }
    //     else
    //     {
    //         alert("Enter a Valid UserName");
    //         return false;
    //     }
    // }
    </script>
@endsection

