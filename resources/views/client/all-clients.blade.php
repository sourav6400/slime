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
        <section id="advanced-search-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">All Clients</h4>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <!--<button-->
                                    <!--    class="dt-button buttons-collection btn btn-outline-secondary dropdown-toggle me-2"-->
                                    <!--    tabindex="0" aria-controls="DataTables_Table_0" type="button"-->
                                    <!--    aria-haspopup="true" aria-expanded="false"><span><svg-->
                                    <!--            xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                                    <!--            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                                    <!--            stroke-linecap="round" stroke-linejoin="round"-->
                                    <!--            class="feather feather-share font-small-4 me-50">-->
                                    <!--            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>-->
                                    <!--            <polyline points="16 6 12 2 8 6"></polyline>-->
                                    <!--            <line x1="12" y1="2" x2="12" y2="15"></line>-->
                                    <!--        </svg>Export</span></button>-->
                                    @php
                                    $role_id = Auth::user()->role;
                                    $client_permission = DB::table('client_permission')->where('role_id', $role_id)->first();
                                    @endphp
                                    
                                    @if($client_permission != null && $client_permission->create == 1)
                                        <a class="btn btn-primary" href="{{ route('add_new_client_view') }}">Add New Client</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--Search Form -->
                        <div class="card-body mt-2">
                            <form class="dt_adv_search" method="POST">
                                <div class="row g-1 mb-md-1">
                                    <div class="col-md-6">
                                        <label class="form-label">Name:</label>
                                        <input type="text" class="form-control dt-input dt-full-name" data-column="1"
                                            placeholder="Your Name" data-column-index="0" id="name_filter" onkeyup="filterEvent()" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control dt-input" data-column="2"
                                            placeholder="Email or Telegram" data-column-index="1" id="email_filter" onkeyup="filterEvent()" />
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Telegram</label>
                                        <input type="text" class="form-control dt-input" data-column="2"
                                            placeholder="Email or Telegram" data-column-index="1" id="telegram_filter" onkeyup="filterEvent()" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="select5-multiple">Tags</label>
                                        <select class="select2 form-select multiple-tags" id="select5-multiple" onchange="filterEvent()" multiple>
                                            <optgroup label="Select Upto all">
                                                @foreach($all_tags as $tag):
                                                <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr class="my-0" />
                        <div class="card-datatable table-responsive" id="all_clients">
                            <table class="dt-advanced-search table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="" id="select-all">
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Company Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Telegram</th>
                                        <th>Tags</th>
                                        <th>Favourite</th>
                                        <th>VAT No</th>
                                        @if($client_permission != null && $client_permission->edit == 1)
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_clients as $key=>$client)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="" id="" class="form-check-input">
                                            </div>
                                        </td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->comany_name }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td><a href="{{ $client->telegram }}" target="_blank">{{ $client->telegram }}</a></td>
                                        <td class="">
                                            @php
                                            $client_id = $client->id;
                                            $all_tags = DB::table('client_tags')
                                            ->where('client_id', $client_id)
                                            ->join('tags', 'client_tags.tag_id', '=', 'tags.id')
                                            ->get();
                                            @endphp
                                            @foreach($all_tags as $key=>$tag)
                                            <span class="badge rounded-pill badge-light-info link-bottom">{{ $tag->tag }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if($client->is_favourite == 1)
                                            <input type="checkbox" class="form-check-input"
                                                onchange="window.location.href='{{ url('change-client-fav-status/'.$client->id) }}'"
                                                checked>
                                            @elseif($client->is_favourite == 0)
                                            <input type="checkbox" class="form-check-input"
                                                onchange="window.location.href='{{ url('change-client-fav-status/'.$client->id) }}'">
                                            @endif
                                        </td>
                                        <td>{{ $client->vat_no }}</td>
                                        
                                        @if($client_permission != null && $client_permission->edit == 1)
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                    data-bs-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a type="button" class="dropdown-item"
                                                        onclick="clientEdit({{ $client->id }})">
                                                        <i data-feather="edit-2" class="me-50"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <!--<a class="dropdown-item delete-client" data-bs-toggle="modal"-->
                                                    <!--    data-bs-target="#deleteClientModal"-->
                                                    <!--    data-client_id="{{ $client->id }}">-->
                                                    <!--    <i data-feather="trash" class="me-50"></i>-->
                                                    <!--    <span>Delete</span>-->
                                                    <!--</a>-->
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Telegram</th>
                                    <th>Tags</th>
                                    <th>Favourite</th>
                                    <th>VAT No</th>
                                    @if($client_permission != null && $client_permission->edit == 1)
                                    <th>Action</th>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                        <div id="filtered_clients"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Delete Client</h1>
                </div>

                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading">Confirmation!</h6>
                    <div class="alert-body">
                        Do you want to delete this Client?
                    </div>
                </div>

                <form id="deletePermissionModal" class="row" onsubmit="return true" novalidate="novalidate" action="{{ route('delete_client') }}" method="POST">
                    @csrf
                    <input type="hidden" value="" id="client_id_to_delete" name="client_id_to_delete" />

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
<!--/ Delete Modal -->

<div class="modal fade" id="editClient" tabindex="-1" aria-hidden="true">

</div>
<!-- END: Content-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

<script>
function filterEvent() {
    var name = $("#name_filter").val();
    var email = $("#email_filter").val();
    var telegram = $("#telegram_filter").val();
    var tags = $(".multiple-tags").val();

    $.ajax({
        type: 'POST',
        url: '/client-filter',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            name: name,
            email: email,
            telegram: telegram,
            tags: tags
        },
        success: function (data) {
            $("#all_clients").hide()
            $("#filtered_clients").html(data);
            // console.log(data)
        }
    });
}

function clientEdit(id) {
    var client_id = id;
    console.log(id);

    $.ajax({
        type: 'POST',
        url: '/client-edit',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            client_id: client_id
        },
        success: function (data) {
            $("#editClient").html(data);
            $("#editClient").modal("show");
            // console.log(data)
            // alert(data)
        }
    });
}

$(document).on("click", ".delete-client", function () {
    var client_id = $(this).data('client_id');
    $("#client_id_to_delete").val(client_id);
});
</script>
@endsection