@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
    <!--<div class="app-content content ">-->
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
                                    <h4 class="card-title">Add Campaign Info</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" method="POST" action="{{ route('post_campaign_info') }}" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <input type="hidden" value="{{ $campaign_id }}" name="campaign_id" />
                                        <div class="row">
                                            <div class="col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Total Reach</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row d-flex align-items-end">
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="mb-1">
                                                                            <label class="form-label" for="select-social">Total Reach</label>
                                                                            <input type="number" class="form-control" name="total_reach" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Best Post</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row d-flex align-items-end">
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="mb-1">
                                                                            <label class="form-label" for="select-social">Post URL</label>
                                                                            <input type="url" class="form-control" name="best_post_url" required />
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="mb-1">
                                                                            <label class="form-label" for="itemcost">Post Image</label>
                                                                            <input type="file" name="best_post_file" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="Post Image" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Featured Article</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="invoice-repeater">
                                                                    <div data-repeater-list="article">
                                                                        <div data-repeater-item>
                                                                            <div class="row d-flex align-items-end">
                                                                                <div class="col-md-6 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="select-social">Article URL</label>
                                                                                        <input type="url" class="form-control" name="article_url" required />
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-4 col-12 featured-article-file">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="itemcost">Article Image</label>
                                                                                        <input type="file" name="article_img" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="Upload File" required />
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-2 col-20">
                                                                                    <div class="mb-1">
                                                                                        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
                                                                                            <i data-feather="x" class="me-25"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary sign-log-btn" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 pb-1">
                                                <div class="form-control-repeater">
                                                    <div class="">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Featured Video</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="invoice-repeater">
                                                                    <div data-repeater-list="video">
                                                                        <div data-repeater-item>
                                                                            <div class="row d-flex align-items-end">
                                                                                <div class="col-md-6 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="select-social">Video URL</label>
                                                                                        <input type="url" class="form-control" name="featured_video_url" />
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-4 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label class="form-label" for="itemcost">Video File</label>
                                                                                        <input type="file" name="featured_video_file" class="form-control" id="itemcost" aria-describedby="itemcost" placeholder="Upload Video" />
                                                                                    </div>
                                                                                </div>
                            
                                                                                <div class="col-md-2 col-20">
                                                                                    <div class="mb-1">
                                                                                        <button class="btn btn-outline-danger text-nowrap" data-repeater-delete type="button">
                                                                                            <i data-feather="x" class="me-25"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-icon btn-primary sign-log-btn" type="button" data-repeater-create>
                                                                                <i data-feather="plus" class="me-25"></i>
                                                                                <span>Add New</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Select2 End -->
            </div>
        </div>
    <!--</div>-->
    <!-- END: Content-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        // $(".featured-article-type").click(function(){
        //     var x = $(".featured-article-type").val();
        //     console.log(x);
        //     if(x == 'URL')
        //     {
        //         $(".featured-article-url").show();
        //     }
        // });
    </script>
@endsection