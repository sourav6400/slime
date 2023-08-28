@extends('layouts.app')

@section('title') {{ 'All Users' }} @endsection

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
                <h4>Add User</h4>
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
                        
                        @php
                        $role_id = Auth::user()->role;
                        $user_management_permission = DB::table('user_management_permission')->where('role_id', $role_id)->first();
                        @endphp
                        
                        @if($user_management_permission != null && $user_management_permission->create == 1)
                        <div class="dt-buttons btn-group flex-wrap">
                            <button class="btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal" data-bs-target="#addPermissionModal"><span>Add New User</span></button>
                        </div>
                        @endif
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
                                @if($user_management_permission != null && $user_management_permission->edit == 1)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $sl = 1; @endphp
                            @foreach($all_users as $key=>$user)
                                @if($user->role != 'Super Admin' && $user->role != 'Admin')
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $user->name }}</td>
                                    <!--<td>{{ $user->username }}</td>-->
                                    <td>{{ $user->email }}</td>
                                    <!--<td>{{ $user->contact }}</td>-->
                                    <td>
                                        @php
                                            $role_id = $user->role;
                                            if(is_numeric($role_id))
                                                $role = DB::table('roles')->where('id', $role_id)->first()->role;
                                            else
                                                $role = $role_id;
                                        @endphp
                                        
                                        {{ $role }}
                                    </td>
                                    
                                    @if($user_management_permission != null && $user_management_permission->edit == 1)
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item edit-user" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" data-userid="{{ $user->id }}" data-name="{{ $user->name }}"  data-email="{{ $user->email }}" data-contact="{{ $user->contact }}" data-role="{{ $user->role }}">
                                                    <i data-feather="edit-2" class="me-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                
                                                
                                                @if($role != 'Admin')
                                                    <a class="dropdown-item delete-user" data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal"
                                                        data-user_id="{{ $user->id }}">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @php $sl++; @endphp
                                @endif
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
                            <h1 class="mb-1">Add New User</h1>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return true" novalidate="novalidate" action="{{route('add_new_user')}}" method="POST">
                            @csrf
                            <div class="col-12 mb-1">
                                <label class="form-label" for="addname">Name</label>
                                <input type="text" id="addname" name="name" class="form-control" placeholder="Your Name" autofocus="">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="user">Username</label>
                                <input type="text" id="user" name="username" class="form-control" placeholder="Username" autofocus="">
                            </div>
                            <div class="col-12 mb-1">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="basic-icon-default-contact">Contact</label>
                                <input type="text" id="basic-icon-default-contact" class="form-control dt-contact" placeholder="+1 (609) 933-44-22" name="user_contact" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="user-role">User Role</label>
                                <select id="user-role" name="role_id" class="select2 form-select" required>
                                    @foreach($all_roles as $role)
                                    <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="user-plan">Select Plan</label>
                                <select id="user-plan" name="plan" class="select2 form-select">
                                    <option value="basic">Basic</option>
                                    <option value="enterprise">Enterprise</option>
                                    <option value="company">Company</option>
                                    <option value="team">Team</option>
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
        
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 pb-5">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Edit User</h1>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return true" novalidate="novalidate" action="{{route('edit_user')}}" method="POST">
                            @csrf
                            <input type="hidden" id="userid" value="" name="userid" />
                            <div class="col-12 mb-1">
                                <label class="form-label" for="addname">Name</label>
                                <input type="text" id="name-edit" value="" name="name" class="form-control" placeholder="Your Name" autofocus="">
                            </div>
                            <div class="col-12 mb-1">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email-edit" value="" placeholder="Your Email">
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="basic-icon-default-contact">Contact</label>
                                <input type="text" id="contact-edit" class="form-control dt-contact" placeholder="+1 (609) 933-44-22" name="user_contact" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="user-role">User Role</label>
                                <select id="user-role role-edit" name="role_id" class="select2 form-select">
                                    @foreach($all_roles as $role)
                                    <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2 me-1 waves-effect waves-float waves-light">Update</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit User Modal -->
        
        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Edit Permission</h1>
                            <p>Edit permission as per your requirements.</p>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Warning!</h6>
                            <div class="alert-body">
                                By editing the permission name, you might break the system permissions functionality. Please ensure you're
                                absolutely certain before proceeding.
                            </div>
                        </div>

                        <form id="editPermissionForm" class="row" onsubmit="return false" novalidate="novalidate">
                            <div class="col-sm-9">
                                <label class="form-label" for="editPermissionName">Permission Name</label>
                                <input type="text" id="editPermissionName" name="editPermissionName" class="form-control" placeholder="Enter a permission name" tabindex="-1" data-msg="Please enter permission name">
                            </div>
                            <div class="col-sm-3 ps-sm-0">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Update</button>
                            </div>
                            <div class="col-12 mt-75">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editCorePermission">
                                    <label class="form-check-label" for="editCorePermission"> Set as core permission </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Edit Permission Modal -->
        
        <!-- Delete User Modal -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 pt-0">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Delete User</h1>
                        </div>
        
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading">Confirmation!</h6>
                            <div class="alert-body">
                                Do you want to delete this User?
                            </div>
                        </div>
        
                        <form id="deleteUserModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_user') }}" method="POST">
                            @csrf
                            <input type="hidden" value="" id="user_id_to_delete" name="user_id_to_delete" />
        
                            <div class="col-sm-12 ps-sm-0 text-center">
                                <button type="submit" class="btn btn-primary mt-2 waves-effect waves-float waves-light">Yes, Delete it</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2 waves-effect" data-bs-dismiss="modal" aria-label="Close">
                                    No, Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Delete User Modal -->
    </div>
</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" integrity="sha256-uEFhyfv3UgzRTnAZ+SEgvYepKKB0FW6RqZLrqfyUNug=" crossorigin="anonymous"></script>

<script>
$(document).on("click", ".edit-user", function () {
    // $.cookie("role", null, { path: '/user-list' });
    var userid = $(this).data('userid');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var contact = $(this).data('contact');
    var role = $(this).data('role');
    // console.log(contact);
    // document.cookie = "role="+role;
    // document.cookie = role + "=" + role;
    
    $("#userid").val(userid);
    $("#name-edit").val( name );
    $("#email-edit").val( email );
    $("#contact-edit").val( contact );
});

$(document).on("click", ".delete-user", function () {
    var user_id = $(this).data('user_id');
    $("#user_id_to_delete").val(user_id);
});
</script>
@endsection