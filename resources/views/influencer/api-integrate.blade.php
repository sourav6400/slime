@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <ul class="nav nav-pills mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('integrate_twitter') }}">
                                
                                <!--<i data-feather="fe:twitter" class="font-medium-3 me-50"></i>-->
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                <span class="fw-bold">Twitter</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('integrate_youtube') }}">
                                <!--<i data-feather="bookmark" class="font-medium-3 me-50"></i>-->
                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                <span class="fw-bold">Youtube</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <!--<i data-feather="link" class="font-medium-3 me-50"></i>-->
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                <span class="fw-bold">Instagram</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <!--<i data-feather="bell" class="font-medium-3 me-50"></i>-->
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                <span class="fw-bold">Facebook</span>
                            </a>
                        </li>
                    </ul>
                    <!--/ User Pills -->
                </div>
                <!--/ User Content -->
            </div>
        </section>
    </div>
</div>
<!-- END: Content-->

@endsection