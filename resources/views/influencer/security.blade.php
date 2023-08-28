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
                @include('influencer.includes.sidebar')

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <ul class="nav nav-pills mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer-profile/'.$influencer_details['id']) }}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Account</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/billing/'.$influencer_details['id']) }}">
                                <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Content & Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/connections/'.$influencer_details['id']) }}">
                                <i data-feather="link" class="font-medium-3 me-50"></i><span class="fw-bold">Social Media</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('influencer/notification/'.$influencer_details['id']) }}">
                                <i data-feather="bell" class="font-medium-3 me-50"></i><span class="fw-bold">Notifications</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('influencer/security/'.$influencer_details['id']) }}">
                                <i data-feather="lock" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Security</span>
                            </a>
                        </li>
                    </ul>
                    <!--/ User Pills -->

                    <!-- Change Password -->
                    <div class="card">
                        <h4 class="card-header">Change Password</h4>
                        <div class="card-body">
                            <form id="formChangePassword" method="POST" onsubmit="return false">
                                <div class="alert alert-warning mb-2" role="alert">
                                    <h6 class="alert-heading">Ensure that these requirements are met</h6>
                                    <div class="alert-body fw-normal">Minimum 8 characters long, uppercase & symbol</div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-md-6 form-password-toggle">
                                        <label class="form-label" for="newPassword">New Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-2 col-md-6 form-password-toggle">
                                        <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/ Change Password -->

                    <!-- Two-steps verification -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-50">Two-steps verification</h4>
                            <span>Keep your account secure with authentication step.</span>
                            <h6 class="fw-bolder mt-2">SMS</h6>
                            <div class="d-flex justify-content-between border-bottom mb-1 pb-1">
                                <span>+1(968) 945-8832</span>
                                <div class="action-icons">
                                    <a href="javascript:void(0)" class="text-body me-50" data-bs-target="#twoFactorAuthModal" data-bs-toggle="modal">
                                        <i data-feather="edit" class="font-medium-3"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="text-body"><i data-feather="trash" class="font-medium-3"></i></a>
                                </div>
                            </div>
                            <p class="mb-0">
                                Two-factor authentication adds an additional layer of security to your account by requiring more than just a
                                password to log in.
                                <a href="javascript:void(0);" class="text-body">Learn more.</a>
                            </p>
                        </div>
                    </div>
                    <!--/ Two-steps verification -->

                    <!-- recent device -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent devices</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap text-center">
                                <thead>
                                    <tr>
                                        <th class="text-start">BROWSER</th>
                                        <th>DEVICE</th>
                                        <th>LOCATION</th>
                                        <th>RECENT ACTIVITY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">
                                            <div class="avatar me-25">
                                                <img src="{{ asset('app-assets/images/icons/google-chrome.png') }}" alt="avatar" width="20" height="20" />
                                            </div>
                                            <span class="fw-bolder">Chrome on Windows</span>
                                        </td>
                                        <td>Dell XPS 15</td>
                                        <td>United States</td>
                                        <td>10, Jan 2021 20:07</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">
                                            <div class="avatar me-25">
                                                <img src="{{ asset('app-assets/images/icons/google-chrome.png') }}" alt="avatar" width="20" height="20" />
                                            </div>
                                            <span class="fw-bolder">Chrome on Android</span>
                                        </td>
                                        <td>Google Pixel 3a</td>
                                        <td>Ghana</td>
                                        <td>11, Jan 2021 10:16</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">
                                            <div class="avatar me-25">
                                                <img src="{{ asset('app-assets/images/icons/google-chrome.png') }}" alt="avatar" width="20" height="20" />
                                            </div>
                                            <span class="fw-bolder">Chrome on MacOS</span>
                                        </td>
                                        <td>Apple iMac</td>
                                        <td>Mayotte</td>
                                        <td>11, Jan 2021 12:10</td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">
                                            <div class="avatar me-25">
                                                <img src="{{ asset('app-assets/images/icons/google-chrome.png') }}" alt="avatar" width="20" height="20" />
                                            </div>
                                            <span class="fw-bolder">Chrome on iPhone</span>
                                        </td>
                                        <td>Apple iPhone XR</td>
                                        <td>Mauritania</td>
                                        <td>12, Jan 2021 8:29</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- / recent device -->
                </div>
                <!--/ User Content -->
            </div>
        </section>



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
        <!-- two factor auth modal -->
        <div class="modal fade" id="twoFactorAuthModal" tabindex="-1" aria-labelledby="twoFactorAuthTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg two-factor-auth">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 mx-50">
                        <h1 class="text-center mb-1" id="twoFactorAuthTitle">Select Authentication Method</h1>
                        <p class="text-center mb-3">
                            you also need to select a method by which the proxy
                            <br />
                            authenticates to the directory serve
                        </p>

                        <div class="custom-options-checkable">
                            <input class="custom-option-item-check" type="radio" name="twoFactorAuthRadio" id="twoFactorAuthApps" value="apps-auth" checked />
                            <label for="twoFactorAuthApps" class="custom-option-item d-flex align-items-center flex-column flex-sm-row px-3 py-2 mb-2">
                                <span><i data-feather="settings" class="font-large-2 me-sm-2 mb-2 mb-sm-0"></i></span>
                                <span>
                                    <span class="custom-option-item-title h3">Authenticator Apps</span>
                                    <span class="d-block mt-75">
                                        Get codes from an app like Google Authenticator, Microsoft Authenticator, Authy or 1Password.
                                    </span>
                                </span>
                            </label>

                            <input class="custom-option-item-check" type="radio" name="twoFactorAuthRadio" value="sms-auth" id="twoFactorAuthSms" />
                            <label for="twoFactorAuthSms" class="custom-option-item d-flex align-items-center flex-column flex-sm-row px-3 py-2">
                                <span><i data-feather="message-square" class="font-large-2 me-sm-2 mb-2 mb-sm-0"></i></span>
                                <span>
                                    <span class="custom-option-item-title h3">SMS</span>
                                    <span class="d-block mt-75">We will send a code via SMS if you need to use your backup login method.</span>
                                </span>
                            </label>
                        </div>

                        <button id="nextStepAuth" class="btn btn-primary float-end mt-3">
                            <span class="me-50">Continue</span>
                            <i data-feather="chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- / two factor auth modal -->

        <!-- add authentication apps modal -->
        <div class="modal fade" id="twoFactorAuthAppsModal" tabindex="-1" aria-labelledby="twoFactorAuthAppsTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg two-factor-auth-apps">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 mx-50">
                        <h1 class="text-center mb-2 pb-50" id="twoFactorAuthAppsTitle">Add Authenticator App</h1>

                        <h4>Authenticator Apps</h4>
                        <p>
                            Using an authenticator app like Google Authenticator, Microsoft Authenticator, Authy, or 1Password, scan the
                            QR code. It will generate a 6 digit code for you to enter below.
                        </p>

                        <div class="d-flex justify-content-center my-2 py-50">
                            <img class="img-fluid" src="app-assets/images/icons/qrcode.png" width="122" alt="QR Code" />
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">ASDLKNASDA9AHS678dGhASD78AB</h4>
                            <div class="alert-body fw-normal">
                                If you having trouble using the QR code, select manual entry on your app
                            </div>
                        </div>

                        <form class="row gy-1" onsubmit="return false">
                            <div class="col-12">
                                <input class="form-control" id="authenticationCode" type="text" placeholder="Enter authentication code" />
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-outline-secondary mt-2 me-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary mt-2">
                                    <span class="me-50">Continue</span>
                                    <i data-feather="chevron-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / add authentication apps modal-->

        <!-- add authentication sms modal-->
        <div class="modal fade" id="twoFactorAuthSmsModal" tabindex="-1" aria-labelledby="twoFactorAuthSmsTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg two-factor-auth-sms">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 mx-50">
                        <h1 class="text-center mb-2 pb-50" id="twoFactorAuthSmsTitle">`</h1>
                        <h4>Verify Your Mobile Number for SMS</h4>
                        <p>Enter your mobile phone number with country code and we will send you a verification code.</p>
                        <form class="row gy-1 mt-1" onsubmit="return false">
                            <div class="col-12">
                                <input class="form-control phone-number-mask" type="text" placeholder="Mobile number with country code" />
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-outline-secondary mt-1 me-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary mt-1">
                                    <span class="me-50">Continue</span>
                                    <i data-feather="chevron-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / add authentication sms modal-->
    </div>
</div>
<!-- END: Content-->
@endsection