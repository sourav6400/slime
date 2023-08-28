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
        <!-- Select2 Start  -->
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add New Client</h4>
                        </div>
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('add_new_client') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="first-name-column">Name</label>
                                            <input type="text" id="first-name-column" class="form-control" placeholder="Your Name" name="name" required />
                                        </div>
                                    </div>
                                    <!--<div class="mb-1 form-password-toggle col-md-6">-->
                                    <!--    <label class="form-label" for="password">Password</label>-->
                                    <!--    <input type="password" name="password" id="password" class="form-control"-->
                                    <!--        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />-->
                                    <!--</div>-->
                                    <!--<div class="mb-1 form-password-toggle col-md-6">-->
                                    <!--    <label class="form-label" for="confirm-password">Confirm Password</label>-->
                                    <!--    <input type="password" name="confirm_password" id="confirm-password" class="form-control"-->
                                    <!--        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />-->
                                    <!--</div>-->
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="form-email">Email</label>
                                        <input type="email" id="form-email" class="form-control" placeholder="Your Email" name="email" required />
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="company-name-column">Company Name</label>
                                            <input type="text" id="company-name-column" class="form-control" placeholder="Your Company Name" name="company_name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" id="address" class="form-control" placeholder="Your Address" name="address" required />
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label for="tg" class="form-label">Telegram</label>
                                        <input type="text" name="telegram" id="tg" class="form-control" placeholder="Your Telegram" required />
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label for="vat" class="form-label">VAT No</label>
                                        <input type="number" name="vat" id="vat" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 col-12 mb-1">
                                        <label class="form-label" for="select7-multiple">Tags</label>
                                        <select class="select2 form-select" id="select7-multiple" name="tags[]" multiple required>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_tags as $tag):
                                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="exampleFormControlTextarea1">Notes</label>
                                            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Type here something"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 sign-log-btn ">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Select2 End -->
    </div>
</div>
<!-- END: Content-->
@endsection