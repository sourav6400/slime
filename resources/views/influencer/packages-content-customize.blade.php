@extends('layouts.app')

@section('title') {{ 'Package Content Customize' }} @endsection

@section('content')
<style>
    /*.card {*/
    /*    margin-top: -20px;*/
    /*}*/

    /*.table {*/
        /*margin-top: 10px;*/
    /*    padding: 10px !important;*/
    /*}*/

    /*.custom-card-class {*/
    /*    margin-top: -2rem;*/
    /*    margin-bottom: 4px;*/
    /*}*/

    /*.sticky-container {*/
    /*    position: -webkit-sticky !important;*/
    /*    position: sticky !important;*/
    /*    top: 0 !important;*/
    /*    position: relative;*/
    /*}*/

    /*.fixedElement {*/
    /*    background-color: #17212b;*/
    /*    position: fixed;*/
    /*    top: 0;*/
    /*    width: 100%;*/
    /*    z-index: 100;*/
    /*}*/
    /*#myPackageTable_wrapper{*/
    /*    padding-left: 2rem;*/
    /*    padding-right: 2rem;*/
    /*}*/
</style>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- BEGIN: Content-->

<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div>
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
        <div class="sticky-container fixedElement">
            <section class="sticky-content">
                <div class="card">
                    <div class="card-header">
                        <div class="col-12 col-md-6">
                            <h4 class="card-title">Package Name : <span class="text-success">{{ $package->package_name }}</span></h4>
                        </div>
                        <div class="col-12 col-md-6">
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between">
                            <h4 class="card-title">Influencer Detail</h4>
                            <!--<div class="dt-action-buttons text-end">-->
                            <!--    <div class="dt-buttons d-inline-flex">-->
                            <!--        Influencer Detail-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    @php
                                    $total_price = 0;
                                    $i = 0;
                                    $total_follower = 0;
                                    $total_action = 0;
                                    @endphp

                                    <table id="myPackageTable" class="scrolldown table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Content-Quantity</th>
                                                <th>Price</th>
                                                <th>Audiences</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <!-- Table body content -->
                                        <tbody>
                                            @php 
                                            $packageId = $package->id;
                                            $influencer = DB::table('influencer_package')->where('id', $packageId)->first()->influencer_id;
                                            $influencer_detail = DB::table('influencer')->where('id', $influencer)->first(); 
                                            @endphp

                                            @if($influencer_detail)
                                            @php
                                            $i++;

                                            $total_follower = $total_follower + $influencer_detail->total_follower;
                                            
                                            $ifluencer_package_content_qry = DB::table('ifluencer_package_content')
                                                ->where('influencer_id', $influencer_detail->id)
                                                ->where('package_id', $packageId)->first();
                                                
                                            if($ifluencer_package_content_qry)
                                            {
                                                $all_contents = DB::table('ifluencer_package_content')
                                                    ->where('influencer_id', $influencer_detail->id)
                                                    ->where('package_id', $packageId)
                                                    ->join('contents', 'ifluencer_package_content.content_id', '=', 'contents.id')
                                                    ->get();
                                            }
                                            else
                                            {
                                                $all_contents = DB::table('influencer_contents')
                                                    ->where('influencer_id', $influencer_detail->id)
                                                    ->join('contents', 'influencer_contents.content_id', '=', 'contents.id')
                                                    ->get();
                                            }
                                            
                                            $price = 0;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        @if($influencer_detail->dp_url != null)
                                                        <img src="{{ $influencer_detail->dp_url }}" class="me-75" height="40" width="40" alt="Not Found" />
                                                        @else
                                                        <img src="{{ asset('images/profile.png') }}" class="me-75" height="40" width="40" alt="Not Found" />
                                                        @endif
                                                        <br>
                                                        <span class="fw-bold text-light">{{ $influencer_detail->name }}</span>
                                                    </a>
                                                </td>
                                                <td class="">
                                                    @if($all_contents)
                                                    @foreach($all_contents as $key=>$content)
                                                    
                                                    @php
                                                    $packageContentDetail = DB::table('ifluencer_package_content')
                                                        ->where('package_id', $packageId)
                                                        ->where('influencer_id', $influencer_detail->id)
                                                        ->where('content_id', $content->id)
                                                        ->first();
                                                    if($packageContentDetail)
                                                    {
                                                        $quantity = $packageContentDetail->content_quantity;
                                                    }
                                                    else
                                                    {
                                                        $quantity = 1;
                                                    }
                                                    @endphp

                                                    @if($quantity > 0)
                                                        @php
                                                            $social_media = null;
                                                            if($content->social_id != null)
                                                            {
                                                                $social = DB::table('socials')->where('id', $content->social_id)->first();
                                                                $social_media = $social->social;
                                                            }
                                                        @endphp
                                                        
                                                        @if($social_media == 'Twitter')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #00acee;">
                                                        @elseif($social_media == 'Youtube')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #CD201F;">
                                                        @elseif($social_media == 'Facebook')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #3b5998;">
                                                        @elseif($social_media == 'Linkedin')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #0072b1;">
                                                        @elseif($social_media == 'TikTok')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #ff0050;">
                                                        @elseif($social_media == 'Instagram')
                                                            <span class="badge rounded-pill badge-light-info link-bottom" style="background-color: #962fbf;">
                                                        @else
                                                            <span class="badge rounded-pill badge-light-info link-bottom">
                                                        @endif
                                                            <span class="badge rounded-pill" style="border: 1px solid white; color: white;">
                                                                {{$content->short_name}} - {{ $quantity }}
                                                            </span>
                                                        </span>
                                                    @endif
                                                    @php
                                                    $price = $price + ($content->price)*$quantity;
                                                    $total_action = $total_action + $quantity;
                                                    @endphp
                                                    @endforeach
                                                    @php $total_price = $total_price + $price; @endphp
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($package->price) }}
                                                </td>
                                                <td>
                                                    {{ number_format($influencer_detail->total_follower) }}
                                                </td>
                                                <td>
                                                    <a class="edit-tag" title="Edit" onclick="contentModal({{ $influencer_detail->id }})">
                                                        <i data-feather="edit" class="me-100"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- END: Content-->

<div class="modal fade" id="contentModal">
    <div id="content-modal-body">
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    // $(document).ready(function() {
    //     var table = $('#myPackageTable').DataTable({
    //         paginate: true,
    //         // scrollY: 600,
    //         pageLength: 5,
    //         lengthMenu: [
    //             [5, 10, 20, 50, 100],
    //             [5, 10, 20, 50, 100]
    //         ]
    //     })
    // });

    // $("#myTable").dataTable( {
    //     paginate: true,
    //     // scrollY: 600,
    //     pageLength : 5,
    //     lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
    // } );

    function editAccess(content_id) {
        if ($('#check-' + content_id).is(":checked")) {
            $("#quantity-" + content_id).prop("readonly", false);
            $("#price-" + content_id).prop("readonly", false);
            $("#btn-" + content_id).attr("disabled", false);
        } else {
            $("#quantity-" + content_id).prop("readonly", true);
            $("#price-" + content_id).prop("readonly", true);
            $("#btn-" + content_id).attr("disabled", true);
        }
    }
    

    $(document).on("click", ".delete-influencer", function() {
        var influencer_id = $(this).data('influencer_id');

        $("#influencer_id_to_remove").val(influencer_id);
    });

    function contentModal(id) {
        var package_id = '<?php echo $package->id; ?>';
        $.ajax({
            type: 'POST',
            url: '/package-content-modal',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                influencer_id: id,
                package_id: package_id,
                request_from: 'package_detail'
            },
            success: function(data) {
                $("#content-modal-body").html(data);
                $('#contentModal').modal('show');
                // console.log(data)
            }
        });
    }

    function update_content_price(content_id) {
        // var price = $("#price-" + content_id).val();
        // var influencer_id = $(".influencer-" + content_id).val();
        // var quantity = $("#quantity-" + content_id).val();
        // var template_id = '<?php // echo $influencer_template_detail->id; ?>';
        // var clients_budget = '<?php // echo $influencer_template_detail->clients_budget; ?>';
        // var total_expense = '<?php // echo $total_price; ?>';

        // console.log("influencer_id: " + influencer_id);
        // console.log("content_id: " + content_id);
        // console.log("template_id: " + template_id);

        // $.ajax({
        //     type: 'POST',
        //     url: '/content-custom-price',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         influencer_id: influencer_id,
        //         content_id: content_id,
        //         price: price,
        //         quantity: quantity,
        //         template_id: template_id,
        //         clients_budget: clients_budget,
        //         total_expense: total_expense
        //     },
        //     success: function(data) {
        //         alert(data);
        //     }
        // });
    }
</script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table_to_export');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('Influencers.' + (type || 'xlsx')));
    }
</script>

@endsection