@extends('layouts.master')
@section('styles')
    <style>
        textarea.client-desc{
            line-height: 30px !important;
        }
        .form-group .error {
            border: 1px solid red !important;
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
                        <a class="nav-link" href="{{ route('client-selection') }}">Client Selection</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="circle50">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="cart">
                        </a>
                    </li> -->

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
    <body class="signup-update-page">
    <!-- Hero Section -->
    <section class="signup-update">
        <div class="container">
            <div class="signup-update-main">

                <div class="signup-update-box white-bg border-radius">
                    <div class="box-top">
                        <h1>
                            <!-- [Monarch Personnel] <br><span>powered by</span> QuestAI <strong>&#174;</strong> -->
                            {{$enterprise->enname}}<br> <span>powered by</span> <img src="{{ URL::asset('assets/images/QuestAI_Dark_Green_RGB.png') }}" alt="Logo" style="width: 185px !important;">
                        </h1>
                    </div>
                    <div class="box-bottom">
                    <h1>This is a super admin console</h1>
                        
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Hero Section -->
    </body>

@endsection

@section('scripts')


    <script>
        $(document).ready(function (){
            $('#update-profile-form').validate({
                rules: {
                    usfirstname: "required",
                    uslastname: "required",
                    password: {
                        "required": false
                    },
                    cpassword: {
                        equalTo: "#password",
                    }

                },submitHandler: function (form) {
                    form.submit();
                    $("#overlay").fadeIn(300);
                }, errorPlacement: function (error, element) {
                    console.log(element, error);
                    $("#overlay").fadeOut(300);
                }
            });
        })

    </script>
@endsection
