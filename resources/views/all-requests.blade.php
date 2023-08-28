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
        <!-- Permission Table -->
        <div class="card col-12">
            <div class="card-header">
                <h4>All Requests</h4>
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
                            <button class="btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#addPermissionModal"><span>Add New User</span></button>
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
                                <th>SL.</th>
                                <th>Name</th>
                                <!--<th>Username</th>-->
                                <th>Email</th>
                                <!--<th>Contact</th>-->
                                <th>User Role</th>
                                <!--<th>Plan</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_requests as $key=>$request)
                            <tr>
                                <form action="{{route('approve')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $request->id }}" />
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $request->name }}</td>
                                    <!--<td>{{ $request->username }}</td>-->
                                    <td>{{ $request->email }}</td>
                                    <!--<td>{{ $request->contact }}</td>-->
                                    <td>
                                        <select name="role" class="form-select" required>
                                            <option value="">--Select One--</option>
                                            @foreach($all_roles as $role)
                                            <option value="{{$role->role}}">{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <!--<td>{{ $request->plan }}</td>-->
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                        <!--<div class="dropdown">-->
                                        <!--    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">-->
                                        <!--        <i data-feather="more-vertical"></i>-->
                                        <!--    </button>-->
                                        <!--    <div class="dropdown-menu dropdown-menu-end">-->
                                        <!--        <a class="dropdown-item" href="#">-->
                                        <!--            <i data-feather="edit-2" class="me-50"></i>-->
                                        <!--            <span>Edit</span>-->
                                        <!--        </a>-->
                                        <!--        <a class="dropdown-item" href="#">-->
                                        <!--            <i data-feather="trash" class="me-50"></i>-->
                                        <!--            <span>Delete</span>-->
                                        <!--        </a>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </td>
                                </form>
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
    </div>
</div>
<!-- END: Content-->
@endsection