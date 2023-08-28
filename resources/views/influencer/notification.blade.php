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
        <section class="app-user-view-security">
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
                            <a class="nav-link" href="{{ url('influencer-profile/'.$influencer_details['id']) }}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Account</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('influencer/notification/'.$influencer_details['id']) }}">
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

                    <!-- notifications -->

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-50">Notifications</h4>
                            <p class="mb-0">Change to notification settings, the user will get the update</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap text-center border-bottom">
                                <thead>
                                    <tr>
                                        <th class="text-start">Type</th>
                                        <th>✉️ Email</th>
                                        <th>🖥 Browser</th>
                                        <th>👩🏻‍💻 App</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">New for you</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck1" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck2" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Account activity</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck6" checked />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">A new browser used to sign in</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck7" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck8" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck9" checked />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">A new device is linked</td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck10" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck11" checked />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck12" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary me-1">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Discard</button>
                        </div>
                    </div>

                    <!--/ notifications -->
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