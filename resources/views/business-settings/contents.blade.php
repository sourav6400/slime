@extends('layouts.app')

@section('title') {{ 'All Contents' }} @endsection

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
        <!-- Permission Table -->

        <div class="card col-md-12 mx-auto">
            <div class="card-header">
                <h4>Content</h4>
            </div>
            <div class="d-flex justify-content-between align-items-center header-actions text-nowrap mx-1 row mt-75 mb-2">
                <div class="col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start myclass">
                    <div class="dataTables_length d-flex align-middle" id="DataTables_Table_0_length">
                        <label class="mrg-r align-middle" for="select">Show</label>
                        <select name="DataTables_Table_0_length" id="select" class="form-select custom-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label class="mrg-l align-middle" for="select">entries</label>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-8">
                    <div class="dt-action-buttons d-flex align-items-center justify-content-lg-end justify-content-center flex-md-nowrap flex-wrap">
                        <div class="me-1">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <label>Search:<input type="search" class="form-control" placeholder="" aria-controls="DataTables_Table_0"></label>
                            </div>
                        </div>
                        <div class="user_role mt-50 width-200 me-1"></div>
                        <div class="dt-buttons btn-group flex-wrap">
                            <button class="btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#addPermissionModal"><span>Add Content</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                </div>
                <div class="text-nowrap">
                    <table class="table dataTable no-footer dtr-column table-striped" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr>
                                <th>SN.</th>
                                <th>Content Name</th>
                                <th>Short Name</th>
                                <th>Linked Social</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_contents as $key=>$content)
                            <tr>
                                @php
                                    $social_id = $content->social_id;
                                    $social = DB::table('socials')->where('id', $social_id)->first();
                                @endphp
                                <td>{{ $key+1 }}</td>
                                <td>{{ $content->content_name }}</td>
                                <td>{{ $content->short_name }}</td>
                                <td>
                                    @if($social)
                                        {{ $social->social }}
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item edit-content" data-bs-toggle="modal" data-bs-target="#editPermissionModal" data-content_id="{{ $content->id }}"  data-content="{{ $content->content_name }}" data-short_name="{{ $content->short_name }}">
                                                <i data-feather="edit-2" class="me-50"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a class="dropdown-item delete-content" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-content_id="{{ $content->id }}">
                                                <i data-feather="trash" class="me-50"></i>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-between mx-2 row mb-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">&nbsp;</a>
                            </li>
                            <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
                                <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">&nbsp;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Permission Table -->
        <!-- Add Permission Modal -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 pb-5">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Add New Content</h1>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return true" novalidate="novalidate" method="POST" action="{{ route('add_content') }}">
                            @csrf
                            <div class="col-12 mb-1">
                                <label class="form-label" for="modalPermissionName">Content Name</label>
                                <input type="text" id="modalPermissionName" name="content_name" class="form-control" placeholder="Content Name" autofocus="" data-msg="Please enter permission name">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="modalPermissionName">Short Link</label>
                                <input type="text" id="modalPermissionName" name="short_name" class="form-control" placeholder="Short Name" autofocus="" data-msg="Please enter permission name">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="select3-basic">Linked Social</label>
                                <select class="select2 form-select" name="social_id" >
                                    <optgroup label="Select Upto all">
                                        <option value="">--Select One--</option>
                                        @foreach($all_socials as $social)
                                            <option value="{{ $social->id }}">{{ $social->social }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light">Save</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
        
        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Edit Content</h1>
                        </div>

                        <form id="editPermissionForm" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('edit_content') }}" method="POST">
                            @csrf
                            <input type="hidden" id="content_id" name="content_id" value="" />
                            <div class="col-sm-12">
                                <label class="form-label" for="editPermissionName">Content Name</label>
                                <input type="text" id="content_name" name="content_name" class="form-control" placeholder="Enter a permission name" tabindex="-1" data-msg="Please enter permission name">
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="editPermissionName">Short Name</label>
                                <input type="text" id="short_name" name="short_name" class="form-control" placeholder="Enter a permission name" tabindex="-1" data-msg="Please enter permission name">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="select3-basic">Linked Social</label>
                                <select class="select2 form-select" name="social_id" >
                                    <optgroup label="Select Upto all">
                                        <option value="">--Select One--</option>
                                        @foreach($all_socials as $social)
                                            <option value="{{ $social->id }}">{{ $social->social }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-sm-12 ps-sm-0 text-center">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Update</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit Permission Modal -->
        
        <!-- Delete Modal -->
        <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
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
                            <h6 class="alert-heading">Warning!</h6>
                            <div class="alert-body">
                                Are you sure to delete this content?
                            </div>
                        </div>

                        <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_content') }}" method="POST">
                            @csrf
                            <input type="hidden" id="content_id_to_delete" name="content_id_to_delete" value="" />
                            <div class="col-sm-12 ps-sm-0 text-center">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes Delete It</button>
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
    </div>
</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    $(document).on("click", ".edit-content", function () {
        var contentId = $(this).data('content_id');
        var contentName = $(this).data('content');
        var shortName = $(this).data('short_name');
        
        $("#content_id").val( contentId );
        $("#content_name").val( contentName );
        $("#short_name").val( shortName );
    });
    
    $(document).on("click", ".delete-content", function () {
        var contentId = $(this).data('content_id');
        
        $("#content_id_to_delete").val( contentId );
    });
</script>
@endsection