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
        <h3>Roles List</h3>
        <p class="mb-2">
            A role provided access to predefined menus and features so that depending <br />
            on assigned role an administrator can have access to what he need
        </p>
        
        @php
        $user_role_id = Auth::user()->role;
        $user_management_permission = DB::table('user_management_permission')->where('role_id', $user_role_id)->first();
        @endphp

        <!-- Role cards -->
        <div class="row">
            @foreach($all_roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>
                                @php
                                $role_id = $role->id;
                                $users = DB::table('users')->where('role', $role_id)->get();
                                $userCount = $users->count();
                                @endphp
                                Total {{ $userCount }} users
                            </span>
                            <!--<ul class="list-unstyled d-flex align-items-center avatar-group mb-0">-->
                            <!--    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy" class="avatar avatar-sm pull-up">-->
                            <!--        <img class="rounded-circle" src="app-assets/images/avatars/2.png" alt="Avatar" />-->
                            <!--    </li>-->
                            <!--    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar avatar-sm pull-up">-->
                            <!--        <img class="rounded-circle" src="app-assets/images/avatars/12.png" alt="Avatar" />-->
                            <!--    </li>-->
                            <!--    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar avatar-sm pull-up">-->
                            <!--        <img class="rounded-circle" src="app-assets/images/avatars/6.png" alt="Avatar" />-->
                            <!--    </li>-->
                            <!--    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kaith D'souza" class="avatar avatar-sm pull-up">-->
                            <!--        <img class="rounded-circle" src="app-assets/images/avatars/11.png" alt="Avatar" />-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{$role->role}}</h4>
                                @if($user_management_permission != null && $user_management_permission->edit == 1)
                                <a href="javascript:;" class="role-edit-modal" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-role_id = "{{$role->id}}" data-role = "{{$role->role}}">
                                    <small class="fw-bolder">Edit Role</small>
                                </a>
                                @endif
                            </div>
                            <a href="javascript:void(0);" class="text-body"><i data-feather="copy" class="font-medium-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            @if($user_management_permission != null && $user_management_permission->create == 1)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end justify-content-center h-100">
                                <img src="app-assets/images/illustration/faq-illustrations.svg" class="img-fluid mt-2" alt="Image" width="85" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                    <span class="btn btn-primary mb-1">Add New Role</span>
                                </a>
                                <p class="mb-0">Add role, if it does not exist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!--/ Role cards -->
        <!-- table -->
        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">Add New Role</h1>
                            <p>Set role permissions</p>
                        </div>
                        <!-- Add role form -->
                        <form id="addRoleForm" class="row" onsubmit="return true" action="{{ route('add_new_role') }}" method="POST" >
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="modalRoleName">Role Name</label>
                                <input type="text" id="modalRoleName" name="RoleName" class="form-control" placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name" required />
                            </div>
                            <div class="col-12">
                                <h4 class="mt-2 pt-50">Role Permissions</h4>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">
                                                    Administrator Access
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                                        <i data-feather="info"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Clients</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="client_read" value="1" type="checkbox" id="userManagementRead" />
                                                            <label class="form-check-label" for="userManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="client_write" value="1" type="checkbox" id="userManagementWrite" />
                                                            <label class="form-check-label" for="userManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="client_create" value="1" type="checkbox" id="userManagementCreate" />
                                                            <label class="form-check-label" for="userManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Influencers</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="influencer_read" value="1" type="checkbox" id="contentManagementRead" />
                                                            <label class="form-check-label" for="contentManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="influencer_write" value="1" type="checkbox" id="contentManagementWrite" />
                                                            <label class="form-check-label" for="contentManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check"> 
                                                            <input class="form-check-input" name="influencer_create" value="1" type="checkbox" id="contentManagementCreate" />
                                                            <label class="form-check-label" for="contentManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Campaigns</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="campaign_read" value="1" type="checkbox" id="dbManagementRead" />
                                                            <label class="form-check-label" for="dbManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="campaign_write" value="1" type="checkbox" id="dbManagementWrite" />
                                                            <label class="form-check-label" for="dbManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="campaign_create" value="1" type="checkbox" id="dbManagementCreate" />
                                                            <label class="form-check-label" for="dbManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Payment</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="payment_read" value="1" type="checkbox" id="finManagementRead" />
                                                            <label class="form-check-label" for="finManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="payment_write" value="1" type="checkbox" id="finManagementWrite" />
                                                            <label class="form-check-label" for="finManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="payment_create" value="1" type="checkbox" id="finManagementCreate" />
                                                            <label class="form-check-label" for="finManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">User Management</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="user_read" value="1" type="checkbox" id="reportingRead" />
                                                            <label class="form-check-label" for="reportingRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="user_write" value="1" type="checkbox" id="reportingWrite" />
                                                            <label class="form-check-label" for="reportingWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="user_create" value="1" type="checkbox" id="reportingCreate" />
                                                            <label class="form-check-label" for="reportingCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary me-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Role Modal -->
        
        
        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">Edit Role</h1>
                            <p>Set role permissions</p>
                        </div>
                        <!-- Add role form -->
                        <form id="addRoleForm" class="row" onsubmit="return true" action="{{ route('edit_role') }}" method="POST" >
                            @csrf
                            <input type="hidden" value="" id="role_id" name="role_id" />
                            <div class="col-12">
                                <label class="form-label" for="modalRoleName">Role Name</label>
                                <input type="text" id="role-name" value="" name="role_name" class="form-control" placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name" required />
                            </div>
                            <div class="col-12">
                                <h4 class="mt-2 pt-50">Role Permissions</h4>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <!--<tr>-->
                                            <!--    <td class="text-nowrap fw-bolder">-->
                                            <!--        Administrator Access-->
                                            <!--        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">-->
                                            <!--            <i data-feather="info"></i>-->
                                            <!--        </span>-->
                                            <!--    </td>-->
                                            <!--    <td>-->
                                            <!--        <div class="form-check">-->
                                            <!--            <input class="form-check-input" type="checkbox" id="selectAll" />-->
                                            <!--            <label class="form-check-label" for="selectAll"> Select All </label>-->
                                            <!--        </div>-->
                                            <!--    </td>-->
                                            <!--</tr>-->
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Clients</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="client_read" value="1" type="checkbox" id="userManagementRead" />
                                                            <label class="form-check-label" for="userManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="client_write" value="1" type="checkbox" id="userManagementWrite" />
                                                            <label class="form-check-label" for="userManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="client_create" value="1" type="checkbox" id="userManagementCreate" />
                                                            <label class="form-check-label" for="userManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Influencers</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="influencer_read" value="1" type="checkbox" id="contentManagementRead" />
                                                            <label class="form-check-label" for="contentManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="influencer_write" value="1" type="checkbox" id="contentManagementWrite" />
                                                            <label class="form-check-label" for="contentManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check"> 
                                                            <input class="form-check-input" name="influencer_create" value="1" type="checkbox" id="contentManagementCreate" />
                                                            <label class="form-check-label" for="contentManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Campaigns</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="campaign_read" value="1" type="checkbox" id="dbManagementRead" />
                                                            <label class="form-check-label" for="dbManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="campaign_write" value="1" type="checkbox" id="dbManagementWrite" />
                                                            <label class="form-check-label" for="dbManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="campaign_create" value="1" type="checkbox" id="dbManagementCreate" />
                                                            <label class="form-check-label" for="dbManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">Payment</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="payment_read" value="1" type="checkbox" id="finManagementRead" />
                                                            <label class="form-check-label" for="finManagementRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="payment_write" value="1" type="checkbox" id="finManagementWrite" />
                                                            <label class="form-check-label" for="finManagementWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="payment_create" value="1" type="checkbox" id="finManagementCreate" />
                                                            <label class="form-check-label" for="finManagementCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">User Management</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="user_read" value="1" type="checkbox" id="reportingRead" />
                                                            <label class="form-check-label" for="reportingRead"> Read </label>
                                                        </div>
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input" name="user_write" value="1" type="checkbox" id="reportingWrite" />
                                                            <label class="form-check-label" for="reportingWrite"> Write </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="user_create" value="1" type="checkbox" id="reportingCreate" />
                                                            <label class="form-check-label" for="reportingCreate"> Create </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary me-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Role Modal -->
        
        
    </div>
</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
    
    $(document).on("click", ".role-edit-modal", function(){
        var role = $(this).data('role');
        var role_id = $(this).data('role_id');
        
        $("#role_id").val(role_id);
        $("#role-name").val(role);
    });
</script>
@endsection