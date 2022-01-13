@extends('layouts.master')
@section('styles')
    <style>
        .news-portrait img {
            width: 100%;
            min-height: 100%;
            height: 100%;
        }
        .news-portrait {
            width: 140px;
            height: 80px;
            overflow: hidden;
            border-radius: 15px;
        }
    </style>
@endsection
@section('header')
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="{{url('/')}}">
                <?php 
                    $enterprise = App\Models\Enterprise::find(enterpriseId());
                ?>
                <b>{{$enterprise->enname}}</b>
                <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="Logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <!-- <li class="nav-item active">
                              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li> -->
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{ route('sales') }}">Sales</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{ route('news.index') }}">Update News</a>--}}
{{--                    </li>--}}

                </ul>
                <div class="header-right">
                    <!-- <form class="form-inline search-header my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <a href="#" class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="Search"></a>
                    </form> -->
                    <!-- <a href="#" class="bell header-right-link">
                        <img src="{{ asset('assets/images/bell.png') }}" alt="Bell">
                    </a> -->
                    <div class="dropdown">
                        <button class="btn  header-right-link btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('assets/images/user.png') }}" alt="user">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('edit.profile') }}">My details</a>
                            @if (auth()->user()->canShowBasketOrMyOrderPage())
                            <a class="dropdown-item" href="{{ route('my.order') }}">My order</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->
@endsection
@section('content')
    <!-- Hero Section -->
    <section class="sidebar-content">
        <div class="container-fluid">
            <nav id="sidebar">
                <ul class="list-unstyled components">
                    <li> <a href="{{ route('client-selection') }}"><i class="fas fa-users"></i> Client selection</a> </li>
                    <!-- <li> <a href="javascript:;"><i class="fas fa-bullhorn"></i> Campaigns</a> </li> -->
                </ul>
            </nav>
            <div class="content">
                <h2 class="text-primary">News-Setup</h2>
                @if (auth()->user()->canViewNews())
                <div class="setup-accordion">
                    <div class="accordion append-news" id="accordionExample">
                    </div>
                </div>
                @endif
                
                @if (auth()->user()->canCreateNews())
                <div class="add-more">
                    <a href="javascript:;" class="circle50 add-more-news" data-url="{{route('news.store')}}"><i class="fas fa-plus"></i></a>
                </div>
                @endif
            </div>

        </div>
    </section>
    <!-- End Hero Section -->

    <div class="card"  id="news-block" style="display: none">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <span class="title-text"> News </span>
                    <img src="{{ asset('assets/images/arrow-down.png') }}" alt="arrow">
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse collapse-block" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <form class="row news-form" method="post" action="javascript:;" data-action="{{ route('news.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" class="news-id">
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control news-date news-datepicker"  name="news_date"  placeholder="Date" />
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control news-title" name="news_title" placeholder="Title" />
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control news-link" pattern="https?://.*" name="news_link" placeholder="Article link (Like:- http://www.google.com or https://www.google.com)" />
                    </div>
                    <div class="form-group upload-delete col-lg-6">
                        <a href="#" class="white-btn">
                            Upload image
                            <input type="file" name="news_image" class="news-image" accept="image/jpg,image/jpeg,image/png,image/gif" />
                        </a>
                        <div class="news-portrait">
                            <img src="{{ asset('assets/images/noimage.png') }}">
                        </div>
                        <div class="delete">                            
                            @if (auth()->user()->canUpdateNews())
                            <button type="submit" class="news-save-btn" id="news_save_btn" style="background: none">
                                <a href="javascript:;" class="circle50">
                                    <img src="{{ asset('assets/images/file.png') }}" alt="file">
                                </a>
                            </button>
                            @endif
                            @if (auth()->user()->canDeleteNews())
                            <a href="javascript:;" class="circle50 news-delete-btn">
                                <img src="{{ asset('assets/images/delete.png') }}" alt="delete">
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


   @include('snippets.delete_confirmation')
@endsection

@section('scripts')


    <script>

        $(document).ready(function () {
            var app_url = '{{ url('/') }}';

            function readURL(input){
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).closest('.upload-delete').find('.news-portrait').addClass('uploaded').find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).on('change', '.news-image', function () {
                $('.news-portrait').removeClass('uploaded').find('img').attr('src', '{{ asset("assets/images/noimage.png") }}');                
                readURL(this);
            });

            getNews();
            function getNews() {
                $("#overlay").fadeIn(300);　
                $.ajax({
                    method: 'get',
                    url: app_url + '/news-setup/indexAjax',
                    success: function (res) {
                        res.data.map(function (section) {
                            let item = ($(document).find('#news-block').clone()).show().removeAttr('id').attr('data-id', section.neid);
                            item.find('.news-id').val(section.neid);
                            item.find('.news-date').val(section.news_date);
                            item.find('.news-title').val(section.netitle);
                            item.find('.title-text').text(section.netitle);
                            item.find('.news-link').val(section.nearticlelink);
                            item.find('.card-header button').attr('data-target', '#collapse'+section.neid);
                            item.find('.collapse-block').attr('id', 'collapse'+section.neid);

                            if (section.news_image_url){
                                item.find('.news-portrait').addClass('uploaded').find('img').attr('src', section.news_image_url);
                            }
                            $(document).find('.append-news').append(item);

                            item.find(".news-datepicker").datepicker({
                                format: "yyyy-mm-dd",
                                autoclose: true,
                                todayHighlight: true,
                                orientation: "bottom"
                            });
                        });
                        $("#overlay").fadeOut(300);

                    },
                    error: function (err) {
                        console.log('err', err);
                        $("#overlay").fadeOut(300);
                    }
                });
            }

            $(document).on('click', '.add-more-news', function (){
                let length = $('.append-news .card').length + 1;
                let item = ($(document).find('#news-block').clone()).show().removeAttr('id');
                item.find('.card-header button').attr('data-target', '#collapse_new'+ length);
                item.find('.collapse-block').attr('id', 'collapse_new'+ length);
                $('.append-news').append(item);
                item.find('.card-header button').trigger('click');
                
                $('.add-more').addClass('d-none');

                item.find(".news-datepicker").datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    orientation: "bottom"
                });
            });

            $(document).on('click', '.news-save-btn', function (e){
                let form = $(this).closest(".news-form");
                $("#overlay").fadeIn(300);　
                form.validate({
                    ignore:'',
                    rules: {
                        news_date: "required",
                        news_title: "required",
                        news_link: "required",
                    }, errorPlacement: function (error, element) {
                        console.log(element, error);
                        $("#overlay").fadeOut(300);
                    }
                });

                if (form.valid()) {
                    if (!$(form).find('.news-portrait').hasClass('uploaded')) {
                        toastr.options = {
                            "progressBar": true,
                        };
                        toastr.error("Please upload image", "Validation");
                        return false;
                        $("#overlay").fadeOut(300);
                    }

                    var formData = new FormData(form[0]);
                    document.getElementById("news_save_btn").disabled = true;
                    $("#overlay").fadeIn(300);　
                    $.ajax({
                        url: form.attr('data-action'),
                        method: 'post',
                        data: formData,
                        cache: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        processData: false,
                        success: function (res) {
                            console.log(res);
                            form.find('.news-id').val(res.data.neid)
                            form.closest('.card').attr('data-id', res.data.neid);
                            form.closest('.card').find('.title-text').text(res.data.netitle);

                            if (res.data.news_image_url){
                                form.find('.news-portrait').addClass('uploaded').find('img').attr('src', res.data.news_image_url);
                            }
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update'){
                                toastr.success("News updated successfully", "Success");                        
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                                document.getElementById("news_save_btn").disabled = false;
                                $("#overlay").fadeOut(300);
                            } else {
                                toastr.success("News added successfully", "Success");                        
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                                document.getElementById("news_save_btn").disabled = false; 
                                $("#overlay").fadeOut(300);
                            }
                            
                        },
                        error: function (err) {
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                            document.getElementById("news_save_btn").disabled = false;
                            $("#overlay").fadeOut(300);
                        }
                    });
                }
            });

            $(document).on('click', '.news-delete-btn', function (e){
                $('.add-more').removeClass('d-none');
                let news_id = $(this).closest('.news-form').find('.news-id').val();
                if (!news_id){
                    $(this).closest('.card').remove();
                    return false;
                }
                $('#deleteConfirmModal').modal();
                $('#deleteConfirmModal').find('.delete-confirm').attr('data-id', news_id);
            });

            $(document).on('click', '.delete-confirm', function (e){
                let news_id = $(this).attr('data-id');
                $("#overlay").fadeIn(300);　
                $.ajax({
                    url: app_url + '/news-setup/delete/' + news_id,
                    method: 'get',
                    success: function (res) {
                        toastr.options = {
                            "progressBar": true,
                        };
                        toastr.success("News deleted successfully", "Success");
                        $('.card[data-id="'+ news_id +'"]').remove();
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
                $('#deleteConfirmModal').modal('hide');
            });
        });

    </script>
@endsection

