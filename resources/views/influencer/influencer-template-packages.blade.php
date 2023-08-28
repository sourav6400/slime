@extends('layouts.app')

@section('title') {{ 'Influencer Template' }} @endsection

@section('content')
<style>
    #inf_table_wrapper {
        padding: 2rem;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- BEGIN: Content-->
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-body">
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form class="" method="POST" action="{{ route('add_package_to_template') }}">
                            @csrf
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">All Packages</h4>
                            <button type="submit" class="btn btn-primary" style="float: right;">Add To Template</button>
                        </div>
                        <!--Search Form -->
                        <div>
                            <input type="hidden" name="template_id" value="{{ $id }}" />
                            <table id="inf_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <!--<div class="form-check">-->
                                            <!--    <input type="checkbox" class="form-check-input" name="" id="select-all">-->
                                            <!--</div>-->
                                            #
                                        </th>
                                        <th>Template Name</th>
                                        <th>Influencers</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($influencer_packages as $key=>$package)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-danger">
                                                <input type="checkbox" name="packages[]" value="{{ $package->id }}" id="check1" class="form-check-input">
                                            </div>
                                        </td>
                                        <td><a href="#">{{ $package->package_name }}</a></td>
                                        
                                        <td>
                                            @php
                                                $influencer_id = $package->influencer_id;
                                                $influencerDetail = DB::table('influencer')->where('id', $influencer_id)->first(); 
                                            @endphp
                                            @if($influencerDetail)
                                                <span class="badge rounded-pill badge-light-info link-bottom">{{ $influencerDetail->name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="delete-influencer-template" title="Delete Template" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-package_id="{{ $package->id }}">
                                                <i data-feather="trash" class="me-50"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="check1" class="form-check-input">
                                            </div>
                                        </th>
                                        <th>Template Name</th>
                                        <th>Influencers</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- END: Content-->

<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h3 class="mb-1">Do you want to delete this Package?</h3>
                </div>

                <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="#" method="POST">
                    @csrf
                    <input type="hidden" class="influencer_package_id" name="influencer_package_id" value="" />

                    <div class="col-sm-12 ps-sm-0 text-center">
                        <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes, Delete</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                            No, Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    // $('table').dataTable();
    
    $(document).ready(function () {
        $('#inf_table').DataTable();
    });
    
    // $('#inf_table').dataTable( {
    //     paginate: true,
    //     //   scrollY: 600
    // } );
    
    $(document).on("click", ".delete-influencer-template", function() {
        var package_id = $(this).data('package_id');
        $(".influencer_package_id").val(package_id);
    });
</script>

@endsection