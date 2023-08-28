@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
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
                            <div class="col-12 col-md-6">
                                <h4 class="card-title">Campaign Name : <span class="text-success">something</span>
                                </h4>
                            </div>
                            <div class="col-12 col-md-6 text-md-end mt-1">
                                <p>Starting Date : <span class="text-success">01/2/2023</span></p>
                                <p>Ending Date : <span class="text-success">01/2/2023</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <h4 class="pb-1">Client Name : <span class="text-warning">Jhon Doe</span></h4>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Budget:</span>
                                                <span>25k</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Paid Amount:</span>
                                                <span>50k</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Budget Remaining:</span>
                                                <span>5k</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Region:</span>
                                                <span>Asia</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Campaign Goal:</span>
                                                <span>Reach 2k users</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Main call to Action:</span>
                                                <span><a href="">google/meet.com</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 pt-2">
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <h4>Client Brif</h4>
                                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias,
                                            neque voluptas. At rem laborum ad saepe molestias necessitatibus,
                                            blanditiis totam doloribus eligendi suscipit eveniet nisi aut cumque
                                            quis, molestiae animi.</p>
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Asset:</span>
                                                <a href=""><img src="images/drive.png" alt=""
                                                        style="height: 20px; width: 20px;"></a>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Client Brief Link:</span>
                                                <a href=""><img src="images/dropbox.png" alt=""
                                                        style="height: 20px; width: 20px;"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-bg">
                                        <h4>Influencer</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Content</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="account.html">
                                                                <img src="app-assets/images/portrait/small/avatar-s-3.jpg"
                                                                    class="me-75" height="40" width="40"
                                                                    alt="Angular" />
                                                                <span class="fw-bold text-light">Blake Jhon</span>
                                                            </a>
                                                        </td>
                                                        <td class="">
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">TP</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">FP</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">RT</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">L</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">RV</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="account.html">
                                                                <img src="app-assets/images/portrait/small/avatar-s-7.jpg"
                                                                    class="me-75" height="40" width="40"
                                                                    alt="Angular" />
                                                                <span class="fw-bold text-light">Smith Roy</span>
                                                            </a>
                                                        </td>
                                                        <td class="">
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">TP</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">FP</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">RT</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">L</span>
                                                            <span
                                                                class="badge rounded-pill badge-light-info link-bottom">RV</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="btn btn-primary mt-1">Add Campaign</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Select2 End -->
    </div>
</div>
<!-- END: Content-->

@endsection