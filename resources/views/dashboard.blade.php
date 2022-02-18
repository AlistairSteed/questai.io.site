@extends('layouts.master')

@section('styles')
    <style>
        .box-outer{
            cursor: pointer;
        }
        img.news_image {
            height: 250px;
            width: 280px;
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
                            
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales') }}">Sales</a>
                    </li>      
                    @if (auth()->user()->canViewNews())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.index') }}">Update News</a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRole('sudfper'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('saconsole') }}">Super Admin Console</a>
                        </li>
                    @endif
                    @if (auth()->user()->hasRole('sudfper') || auth()->user()->hasRole('admghin'))
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('clients.index') }}">Create Client</a>
                        </li>
                    @endif
                    @if ($user_id == 40 || ($user_id >= 46 && $user_id <=49))
                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('topadmin') }}">Top Admin</a>
                        </li>
                    @endif
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
                    <li class="active"> <a href="{{ route('client-selection') }}"><i class="fal fa-users"></i> Client selection</a> </li>
                    <!-- <li> <a href="javascript:;"><i class="fas fa-bullhorn"></i> Campaigns</a> </li> -->
                </ul>
            </nav>
            <div class="content">
                <h2 class="text-primary">Client Selection</h2>    
                <div class="company-box">
                    @foreach($clients as $client) 
                    <a class="box-outer" href="{{ url('/client-overview/'. $client->encrypted_id) }}">
                        <div class="box">
                            <div class="box-top">
                                <h4>{{ $client->clname }}</h4>
                            </div>
                            <div class="box-bottom">
                                <span class="location">
                                    <img src="{{ asset('assets/images/location.png') }}" alt="Location"> {{ $client->claddress1 }} &nbsp; {{ $client->claddress2 }} &nbsp; {{ $client->clcity }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                @if (auth()->user()->canViewNews())
                <div class="news">
                    <div class="news-box border-radius20 white-bg">
                        <h3 class="text-primary">News</h3>

                        <div class="swiper-container mySwiper news-swiper">
                            <div class="swiper-wrapper">
                                @foreach($news_data as $news)
                                <div class="swiper-slide">
                                    <a href="{{$news->nearticlelink}}" target="_blank">
                                        <img src="{{ $news->news_image_url }}" alt="News" class="news_image">
                                    </a>
                                    <h4>{{ $news->netitle }}</h4>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </section>
    <!-- End Hero Section -->
@endsection

@section('scripts')


    <script>

        $(document).ready(function () {
            var app_url = '{{ url('/') }}';
            $(document).on('click', '.box-outer', function (){
                let client_id = $(this).attr('data-id');
                window.location.href = app_url + '/client-overview/' + client_id;
            });
        });

    </script>
@endsection

