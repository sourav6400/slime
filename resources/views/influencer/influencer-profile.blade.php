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
        <section class="app-user-view-account">
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
                            <a class="nav-link" href="{{ url('influencer/billing/'.$influencer_details['id']) }}">
                                <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Content & Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('influencer-profile/'.$influencer_details['id']) }}">
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

                    <!-- Project table -->
                    <div class="card">
                        <h4 class="card-header">User's Projects List</h4>
                        <div class="table-responsive">
                            <table class="table datatable-project">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Project</th>
                                        <th class="text-nowrap">Total Task</th>
                                        <th>Progress</th>
                                        <th>Hours</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /Project table -->

                    <!-- Activity Timeline -->
                    <div class="card">
                        <h4 class="card-header">User Activity Timeline</h4>
                        <div class="card-body pt-1">
                            <ul class="timeline ms-50">
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>User login</h6>
                                            <span class="timeline-event-time me-1">12 min ago</span>
                                        </div>
                                        <p>User login at 2:12pm</p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>Meeting with john</h6>
                                            <span class="timeline-event-time me-1">45 min ago</span>
                                        </div>
                                        <p>React Project meeting with john @10:15am</p>
                                        <div class="d-flex flex-row align-items-center mb-50">
                                            <div class="avatar me-50">
                                                <img src="{{ asset('app-assets/images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar" width="38" height="38" />
                                            </div>
                                            <div class="user-info">
                                                <h6 class="mb-0">Leona Watkins (Client)</h6>
                                                <p class="mb-0">CEO of pixinvent</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>Create a new react project for client</h6>
                                            <span class="timeline-event-time me-1">2 day ago</span>
                                        </div>
                                        <p>Add files to new design folder</p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                                    <div class="timeline-event">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                            <h6>Create Invoices for client</h6>
                                            <span class="timeline-event-time me-1">12 min ago</span>
                                        </div>
                                        <p class="mb-0">Create new Invoices and send to Leona Watkins</p>
                                        <div class="d-flex flex-row align-items-center mt-50">
                                            <img class="me-1" src="{{ asset('app-assets/images/icons/pdf.png') }}" alt="data.json" height="25" />
                                            <h6 class="mb-0">Invoices.pdf</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /Activity Timeline -->

                    <!-- Invoice table -->
                    <div class="card">
                        <table class="invoice-table table text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#ID</th>
                                    <th><i data-feather="trending-up"></i></th>
                                    <th>TOTAL Paid</th>
                                    <th class="text-truncate">Issued Date</th>
                                    <th class="cell-fit">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /Invoice table -->
                </div>
                <!--/ User Content -->
            </div>
        </section>
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
                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserFirstName">Name</label>
                                <input type="text" id="modalEditUserFirstName" name="modalEditUserName" class="form-control" placeholder="Your Name" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserLastName">Telegram</label>
                                <input type="text" id="modalEditUserLastName" name="modalEditUsertelegram" class="form-control" placeholder="Your Telegram" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalEditUserName">Email</label>
                                <input type="email" id="modalEditUserName" name="modalEditUserName" class="form-control" value="gertrude.dev" placeholder="example@gmail.com" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserStatus">Region</label>
                                <select id="modalEditUserStatus" name="modalEditUserStatus" class="form-select" aria-label="Default select example">
                                    <option selected>Asia</option>
                                    <option value="1">India</option>
                                    <option value="2">Africa</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditkol">KOL</label>
                                <select id="modalEditkol" name="modalEditUserStatus" class="form-select" aria-label="Default select example">
                                    <option selected>Something</option>
                                    <option value="1">India</option>
                                    <option value="2">Bangladesh</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="modalEditUserLanguage">Tags</label>
                                <select id="modalEditUserLanguage" name="modalEditUserLanguage" class="select2 form-select" multiple>
                                    <option value="Facebook">Content Creator</option>
                                    <option value="Twitter">Artist</option>
                                    <option value="Vibas">Vibas</option>
                                    <option value="Collector">Collector</option>
                                    <option value="NFT">NFT</option>
                                    <option value="NFT Collector">NFT Collector</option>
                                    <option value="Host">Host</option>
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
        <!-- Edit Tags Modal  -->
        <div class="modal fade" id="edittags" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Edit Tags</h1>
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">

                            <div class="col-12">
                                <label class="form-label" for="modalEdittags">Tags</label>
                                <select id="modalEdittags" name="modalEditUserLanguage" class="select2 form-select" multiple>
                                    <option value="Facebook">Content Creator</option>
                                    <option value="Twitter">Artist</option>
                                    <option value="Vibas">Vibas</option>
                                    <option value="Collector">Collector</option>
                                    <option value="NFT">NFT</option>
                                    <option value="NFT Collector">NFT Collector</option>
                                    <option value="Host">Host</option>
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
        <!--/ Edit Tags Modal  -->
        <!-- upgrade your plan Modal -->
        <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-upgrade-plan">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-2">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Upgrade Plan</h1>
                            <p>Choose the best plan for user.</p>
                        </div>
                        <form id="upgradePlanForm" class="row pt-50" onsubmit="return false">
                            <div class="col-sm-8">
                                <label class="form-label" for="choosePlan">Choose Plan</label>
                                <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                    <option selected>Choose Plan</option>
                                    <option value="standard">Standard - $99/month</option>
                                    <option value="exclusive">Exclusive - $249/month</option>
                                    <option value="Enterprise">Enterprise - $499/month</option>
                                </select>
                            </div>
                            <div class="col-sm-4 text-sm-end">
                                <button type="submit" class="btn btn-primary mt-2">Upgrade</button>
                            </div>
                        </form>
                    </div>
                    <hr />
                    <div class="modal-body px-5 pb-3">
                        <h6>User current plan is standard plan</h6>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-center me-1 mb-1">
                                <sup class="h5 pricing-currency pt-1 text-primary">$</sup>
                                <h1 class="fw-bolder display-4 mb-0 text-primary me-25">99</h1>
                                <sub class="pricing-duration font-small-4 mt-auto mb-2">/month</sub>
                            </div>
                            <button class="btn btn-outline-danger cancel-subscription mb-1">Cancel Subscription</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ upgrade your plan Modal -->

    </div>
</div>
<!-- END: Content-->

@endsection