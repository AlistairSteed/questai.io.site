@extends('layouts.master')

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
            <div class="content sales">
                <h2 class="text-primary">Sales</h2>

                <div class="tabbing-search-head">
                    <form class="form-inline search-header">
                        <input class="form-control" id="search-sale" type="search" placeholder="Search" aria-label="Search">
                        <a href="#" class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="search"></a>
                    </form>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="company-box append-sales-block">

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- End Hero Section -->

    <div class="box-outer sales-block" id="sales-block" style="display: none">
        <a href="#" class="box">
            <div class="box-top">
                <h4>Aardvark Systems Limited</h4>
                <div class="date-time">
                    <span><img src="{{ asset('assets/images/calendar.png') }}" alt="Date"> <span class="date">17/02/2021</span></span>
                    <span class="time">10:35</span>
                </div>
            </div>
            <div class="box-bottom">
                <span class="ref-number">Ref No.: 00000003</span>
                <span class="price">Sales Value: £775.00</span>
                <span class="payment">Payment Method: Invoice</span>
            </div>
            <div class="approved">
                <h5>Approved</h5>
                <span class="ap-date"></span>
                <span class="ap-time"></span>
            </div>
        </a>
    </div>
@endsection

@section('scripts')


    <script>

        $(document).ready(function () {
            var app_url = '{{ url('/') }}';
            var search = $('#search-sale').val();
            getSales(search);

            $(document).on('keyup', '#search-sale', function (){
                search = $(this).val();
                getSales(search);
            })

            function getSales(search)
            {

                $.ajax({
                    url: app_url + '/ajax-sales',
                    method: 'post',
                    data: {
                        search : search,
                    },
                    success: function (res) {
                        console.log(res);
                        $(document).find('.append-sales-block').html('');
                        res.data.map(function (section) {
                            let item = ($(document).find('#sales-block').clone()).show().removeAttr('id').attr('data-id', section.said);
                            item.find('.box-top h4').text(section.name);
                            item.find('.date-time .date').text(section.date);
                            item.find('.date-time .time').text(section.time);
                            item.find('.ref-number').text('Ref No.: ' + section.sarefno);
                            item.find('.price').text('Sales Value: £' + section.sagrandtotal);
                            item.find('.payment').text('Payment Method: ' + section.payment_type);
                            if (item.saapproveddate){
                                item.find('.box').addClass('green');
                                item.find('.approved .date').text(section.ap_date);
                                item.find('.approved .time').text(section.ap_time);
                            }
                            $(document).find('.append-sales-block').append(item);
                        });

                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
            }

        });

    </script>
@endsection

