@extends('layouts.master')
@section('styles')
    <style>

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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client-selection') }}">Client Selection</a>
                    </li>
                    @if (auth()->user()->canUpdateClientDetail())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('update-client', $client->encrypted_id) }}">Update Client</a>
                    </li>
                    @endif
                    @if (auth()->user()->canShowBasketOrMyOrderPage())
                    <li class="nav-item">
                        <a href="#" class="circle50" data-toggle="modal" id="cart-popup-data" data-target="#cartpopup">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="cart">
                        </a>
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
                    <li class="active"> <a href="#clientoverview" data-toggle="collapse" aria-expanded="true"> <i
                                class="far fa-file-alt"></i>Client Overview <i class="fas fa-chevron-down up-down"></i></a>
                        <ul class="collapse list-unstyled show sidebar-submenu" id="clientoverview">
                            <li class="active" data-id="pills-client-details-tab" id="client-details-title"> <a href="#pills-client-details" role="tab" id="tab_11"><i class="far fa-edit"></i> Client Details</a> </li>

                            <li data-id="pills-latest-activity-tab" id="latest-activity-title"> <a href="#pills-latest-activity" role="tab" id="tab_12"><i class="far fa-clock"></i> Latest Activity</a> </li>

                            <li data-id="pills-campaigns-tab" id="campaigns-title"> <a href="#pills-campaigns" role="tab" id="tab_13"><i class="fas fa-bullhorn"></i> Campaigns</a> </li>
                        </ul>
                    </li>
                    @if (auth()->user()->canViewUserForClient($client))
                    <li> <a href="{{ route('users.index.user', $client->encrypted_id,'user') }}"><i class="fal fa-users"></i> Users</a> </li>
                    @endif                    
                    @if (auth()->user()->canCreateCampaign($client))
                    <li> <a href="{{ route('campaign.create', $client->encrypted_id) }}"><i class="fas fa-bullhorn"></i>New Campaigns</a> </li>
                    @endif 
                </ul>
            </nav>
            <div class="content sales client-overview">
                <h2 class="text-primary mb-3">Client Overview</h2>

                <h5 class="text-primary text-center mb-5">{{$client->clname}}</h5>

                <div class="tabbing-search-head justify-content-center">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation" id="client-details-title">
                            <a class="nav-link active" id="pills-client-details-tab" data-toggle="pill" href="#pills-client-details"
                               role="tab" aria-controls="pills-client-details" aria-selected="true">Client Details</a>
                        </li>
                        <li class="nav-item" role="presentation" id="latest-activity-title">
                            <a class="nav-link" id="pills-latest-activity-tab" data-toggle="pill" href="#pills-latest-activity"
                               role="tab" aria-controls="pills-latest-activity" aria-selected="false">Latest Activity</a>
                        </li>
                        <li class="nav-item" role="presentation" id="campaigns-title">
                            <a class="nav-link" id="pills-campaigns-tab" data-toggle="pill" href="#pills-campaigns" role="tab"
                               aria-controls="pills-campaigns" aria-selected="false">Campaigns</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-client-details" role="tabpanel"
                         aria-labelledby="pills-client-details-tab">
                        <div class="company-box box-single-outer">
                            <div class="box-single">
                                <div class="box-single-top">
                                    <h4>{{ $client->clname }}</h4>
                                    <p style="white-space: pre-wrap;">{{ $client->clcompanydesc }}</p>
                                </div>
                                <div class="box-single-bottom">
                                    <ul class="single-box-contact">
                                        <li>
                                            <img src="{{ asset('assets/images/location-big.png') }}" alt="Location">
                                            <p>
                                                @if($client->claddress1)
                                                    {{ $client->claddress1 }} <br>
                                                @endif
                                                @if($client->claddress2)
                                                    {{ $client->claddress2 }} <br>
                                                @endif
                                                @if($client->clcity)
                                                    {{ $client->clcity }} <br>
                                                @endif
                                            </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/images/phone.png') }}" alt="Phone">
                                            <a href="tel:{{ $client->cltelno }}">{{ $client->cltelno }}</a>
                                        </li>
                                        @if($client->clvideo)
                                        <li>
                                            <a href="{{ $client->clvideo }}" target="_blank" class="white-btn">View Client Video</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-latest-activity" role="tabpanel" aria-labelledby="pills-latest-activity-tab">
                        <div class="company-box">
                            @foreach($activities as $activity)
                                <div class="box-outer">
                                    <a href="javascript:;" class="box">
                                        <div class="box-top">
                                            <h4>{{ @$activity->Campaign->cajobtitle }}</h4>
                                            <div class="date-time">
                                                <span><img src="{{ asset('assets/images/calendar.png') }}" alt="Date"> {{ \Carbon\Carbon::parse($activity->audatetime)->format('Y-m-d') }}</span>
                                                <span>{{ \Carbon\Carbon::parse($activity->audatetime)->format('H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="box-bottom">
                                            <div class="info">
                                                <span><img src="{{ asset('assets/images/location.png') }}" alt="location">London</span>
                                                <span><img src="{{ asset('assets/images/information.png') }}" alt="information">
                                                <p class="audetails">{{ $activity->audetails }}</p>
                        </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-campaigns" role="tabpanel" aria-labelledby="pills-campaigns-tab">
                        <div class="company-box">
                            @foreach($campaigns as $campaign)
                            <div class="box-outer" data-id="{{ $campaign->caid }}">
                                <a href="{{ route('campaign-overview', [$client->encrypted_id, $campaign->encrypted_id]) }}" class="box green">
                                    <div class="box-top">
                                        <h4>{{ $campaign->cajobtitle }}</h4>
                                        <div class="date-time">
                                            <span><img src="{{ asset('assets/images/calendar.png') }}" alt="Date"> {{ \Carbon\Carbon::parse($campaign->cadate)->format('Y-m-d') }}</span>
                                            <span>{{ \Carbon\Carbon::parse($campaign->cadate)->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="box-bottom">
                                        <div class="info">
                                            <span><img src="{{ asset('assets/images/location.png') }}" alt="location">
                                            @if($campaign->caaddress1)
                                                    {{ $campaign->caaddress1 }} <br>
                                                @endif
                                                @if($campaign->caaddress2)
                                                    {{ $campaign->caaddress2 }} <br>
                                                @endif
                                                @if($campaign->cacity)
                                                    {{ $campaign->cacity }} <br>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <?php 
                                        if($campaign->castatus == 0){
                                            $style = "#f7b900";
                                        }else if($campaign->castatus == 3){
                                            $style = "#f7b900;";
                                        }else if($campaign->castatus == 4){
                                            $style = "##4f8d49;";
                                        }else if($campaign->castatus == 9){
                                            $style = "#12A3C6;";
                                        }else{
                                            $style = "";                                            
                                        }
                                    ?>
                                    <div class="approved" style="background-color:{{$style}}">
                                        <h5>{{ \App\Models\Campaign::getCampaignStatus($campaign->castatus) }}</h5>
                                        <span>{{ $campaign->waiting_candidates }}/{{ $campaign->total_candidates }}</span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Hero Section -->
    
    @include('snippets.cart_popup')
@endsection

@section('scripts')


    <script>
        $(document).ready(function (){
            $(function() {
                var hash = window.location.hash;
                hash && $('ul.nav a[href="' + hash + '"]').tab('show');    
                
                hash && $('ul.list-unstyled a[href="' + hash + '"]').addClass('active').siblings().removeClass('active');
               
                if (hash == '#pills-client-details') {
                    $('#client-details-title').addClass('active').siblings().removeClass('active');
                }
                if (hash == '#pills-latest-activity') {
                    $('#latest-activity-title').addClass('active').siblings().removeClass('active');
                }
                if (hash == '#pills-campaigns') {
                    $('#campaigns-title').addClass('active').siblings().removeClass('active');
                }

                $('.nav-pills a').click(function(e) {
                    $(this).tab('show');
                    window.location.hash = this.hash;
                });
            });
            var app_url = '{{ url('/') }}';

            $(document).on('click', '#clientoverview li', function (){
                $(this).addClass('active').siblings().removeClass('active');
                $('#' + $(this).attr('data-id')).trigger('click');
            });

            $(document).on('click', '.nav-item .nav-link', function (){
                let id = $(this).attr('id')
                $('#clientoverview li[data-id="'+ id +'"]').addClass('active').siblings().removeClass('active');
            });


            //Cart
            $(".coupon-apply-btn").addClass('disabled'); 
            $(document).on('click', '#cart-popup-data', function (){
                $('#clientinformation').modal('hide');
                $('#candidateassessmentadditional').modal('hide');
                $('#campingassessmentadditional').modal('hide');
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-get-cart-product',
                    method: 'get',
                    success: function (res) {
                        console.log(res.basketData.basket_lines);                            
                        $(document).find('.append-cart-table-data').html('');
                        if(res.basketData.basket_lines.length !== 0 || res.basketData.basket_lines.length !== null){
                            if(res.basketData.total_amount == 0){
                                    document.getElementById("cart-complete-btn").disabled = true;
                                    $(".promo-code").addClass('d-none'); 
                                    $(".promo-code-price").addClass('d-none');
                                    $(".grand-total-cart-product-price").addClass('d-none');
                                    $('.grand-total').addClass('d-none');
                                    $('#coup-code').val('');
                            }else{
                                document.getElementById("cart-complete-btn").disabled = false;
                                $(".coupon-div").removeClass('d-none'); 
                                
                                res.basketData.basket_lines.map(function (section) {
                                    let item = ($(document).find('#cart-table-tr-sec').clone()).show().removeAttr('id').attr('data-id', section.blif);
                                    res.productData.map(function (section1) {  
                                        if(section.blproductid == section1.prid){      
                                            if(section.candidate != null){
                                                name = ' (' + section.candidate.cafirstnames +' '+ section.candidate.calastname +')';
                                            }else{
                                                name = ' (' + res.basketData.user.usfirstname +' '+ res.basketData.user.uslastname +')';
                                            }                         
                                            item.find('.product-name').text(section1.prdesc + name);
                                            item.find('.product-cost').text('£'+section1.prprice); 
                                            item.find('#product-remove-cart').attr('data-id', section.blif);           
                                        }   
                                    });
                                    
                                    document.getElementById("total-cart-price").value = res.basketData.total_amount;
                                    $(document).find('.total-cart-product-price').text('£'+res.basketData.total_amount.toFixed(2));      
                                    if(res.basketData.total_amount == 0){
                                        document.getElementById("cart-complete-btn").disabled = true;
                                        $(".promo-code").addClass('d-none'); 
                                        $(".promo-code-price").addClass('d-none');
                                        $(".grand-total-cart-product-price").addClass('d-none');
                                        $('.grand-total').addClass('d-none');
                                        $('#coup-code').val('');
                                    }else{
                                        document.getElementById("cart-complete-btn").disabled = false;
                                        $(".coupon-div").removeClass('d-none'); 
                                    }
                                    $(document).find('.append-cart-table-data').append(item);
                                });
                            }
                            $("#overlay").fadeOut(300);
                        }else{
                            document.getElementById("cart-complete-btn").disabled = true;
                            $("#overlay").fadeOut(300);
                        }
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '#product-remove-cart', function() {
                var basketLine_id = $(this).data('id');   
                swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to remove this product ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) { 
                    if (result.value) {
                        $("#overlay").fadeIn(300);
                        $('.total-cart-product-price').text('£0'); 
                        $('#total-cart-price').val('');
                        $(".coupon-div").addClass('d-none'); 
                        $(".promo-code").addClass('d-none'); 
                        $(".promo-code-price").addClass('d-none');
                        $(".grand-total-cart-product-price").addClass('d-none');
                        $('.grand-total').addClass('d-none');
                        $('#coup-code').val('');
                        $.ajax({
                            type: "POST",
                            url: app_url + '/product-remove-cart',
                            data: { 
                                basketLine_id: basketLine_id,  
                            },
                            success: function (res) {
                            console.log(res.basketData);                         
                                $(document).find('.append-cart-table-data').html('');
                                
                                if(res.basketData.basket_lines.length !== 0){
                                    res.basketData.basket_lines.map(function (section) {
                                        let item = ($(document).find('#cart-table-tr-sec').clone()).show().removeAttr('id').attr('data-id', section.blif);
                                        res.productData.map(function (section1) {  
                                            if(section.blproductid == section1.prid){      
                                                if(section.candidate != null){
                                                    name = ' (' + section.candidate.cafirstnames +' '+ section.candidate.calastname +')';
                                                }else{
                                                    name = ' (' + res.basketData.user.usfirstname +' '+ res.basketData.user.uslastname +')';
                                                }                         
                                                item.find('.product-name').text(section1.prdesc + name);
                                                item.find('.product-cost').text('£'+section1.prprice); 
                                                item.find('#product-remove-cart').attr('data-id', section.blif);           
                                            }   
                                        });
                                        
                                        document.getElementById("total-cart-price").value = res.basketData.total_amount;
                                        $(document).find('.total-cart-product-price').text('£'+res.basketData.total_amount.toFixed(2));   

                                        if(res.basketData.total_amount == 0){
                                            document.getElementById("cart-complete-btn").disabled = true;
                                            $(".promo-code").addClass('d-none'); 
                                            $(".promo-code-price").addClass('d-none');
                                            $(".grand-total-cart-product-price").addClass('d-none');
                                            $('.grand-total').addClass('d-none');
                                            $('#coup-code').val('');
                                        }else{
                                            document.getElementById("cart-complete-btn").disabled = false;
                                            $(".coupon-div").removeClass('d-none'); 
                                        }
                                        $(document).find('.append-cart-table-data').append(item);
                                    });
                                }else{
                                    document.getElementById("cart-complete-btn").disabled = true;
                                }

                                if (res.type == 'remove'){
                                    toastr.success("Product removed successfully", "Success");
                                } else {
                                    toastr.success("Product added successfully", "Success");
                                }
                                $("#overlay").fadeOut(300);

                            },
                            error: function (data) {
                                console.log('Error:', data);
                                $("#overlay").fadeOut(300);
                            }
                        });
                    }
                });
            })
            
            $(".promo-code").addClass('d-none'); 
            $(".promo-code-price").addClass('d-none');
            $('.grand-total').addClass('d-none');
            $('.grand-total-cart-product-price').addClass('d-none');

            $(document).on('click', '#coupon-apply-btn', function (){
                $("#overlay").fadeIn(300);
                var coupon = $("#coupon_code").val();                
                var total_amount = document.getElementById("total-cart-price").value;
                if (coupon==null || coupon==""){  
                    document.getElementById("coupon_code").required = true;
                    $('.coupon-code-msg').text('Please enter your coupon code.');
                    $('.coupon-code-msg').css('color', 'red');
                    $("#overlay").fadeOut(300);
                    return false;  
                }

                $.ajax({
                    url: app_url + '/check-coupon-code',
                    method: 'post',
                    data: {
                        coupon : coupon,
                    },
                    success: function (res) {
                        console.log(res.data);
                        if(res.type == 'expire'){
                            document.getElementById('coupon_code').value = '';
                            $('.coupon-code-msg').text('Expire this coupon code.');
                            $('.coupon-code-msg').css('color', 'red');  
                            $("#overlay").fadeOut(300); 
                        }else if(res.type == 'invalid'){                            
                            document.getElementById('coupon_code').value = '';
                            $('.coupon-code-msg').text('This coupon code is invalid.');
                            $('.coupon-code-msg').css('color', 'red');
                            $("#overlay").fadeOut(300); 
                        }else{
                            $('.coupon-code-msg').text(res.data.codesc);
                            $('.coupon-code-msg').css('color', 'green');
                            $('.coupon-apply-btn').css('display', 'none');   
                            $('.coupon-remove-btn').css('display', 'block');   
                            $("#coupon_code").attr("disabled", "disabled");    
                             
                            $('.promo-code').removeClass('d-none');  
                            $('.promo-code-price').removeClass('d-none');
                            $('.grand-total').removeClass('d-none');
                            $('.grand-total-cart-product-price').removeClass('d-none');
                            
                            document.getElementById("coup-code").value = res.data.cocode;

                            if(res.data.copercent !== '0.00'){
                                var percentage_amount = (total_amount/100)*res.data.copercent;
                                var grand_total_amount = total_amount - percentage_amount;
                            }else{                                
                                var percentage_amount = res.data.covalue;
                                var grand_total_amount = total_amount - percentage_amount;
                            }
                            
                            $('.promo-code').text('Promo - ('+res.data.cocode+')');                            
                            $('.promo-code').css('color', 'skyblue');  
                            $('.promo-code-price').text('-£'+percentage_amount.toFixed(2));  
                            $('.promo-code-price').css('color', 'skyblue'); 
                            $('.grand-total-cart-product-price').text('£'+grand_total_amount.toFixed(2));
                            
                            $("#overlay").fadeOut(300); 
                        }      
                        $("#overlay").fadeOut(300);              
                    },
                    error: function (err) {
                        console.log('err', err);
                        $("#overlay").fadeOut(300);
                    }
                });
            })
            $(document).on('click', '#coupon-remove-btn', function (){
                document.getElementById('coupon_code').value = '';
                $('#coup-code').val('');
                $('.coupon-apply-btn').css('display', 'block');   
                $('.coupon-remove-btn').css('display', 'none');                 
                $('.coupon-code-msg').text('');
                $("#coupon_code").removeAttr("disabled");  
                
                
                $(".promo-code").addClass('d-none'); 
                $(".promo-code-price").addClass('d-none');
                $(".grand-total-cart-product-price").addClass('d-none');
                $('.grand-total').addClass('d-none');
            })

            $("#coupon_code").keyup(function () {
                var btnSubmit = $("#coupon-apply-btn");
                if ($(this).val().trim() != "") {
                    btnSubmit.removeClass("disabled");
                } else {
                    btnSubmit.addClass('disabled'); ;
                }
            });

            $(document).on('change', 'input[type="checkbox"]', function (){
               if ($(this).is(':checked')){
                   $(this).siblings('span').removeClass('error');
               }
            });

            $(document).on('click', '.cart-complete-btn', function (e){
                
                var $this = $(this);
                let form = $this.closest(".cart-form");  
                document.getElementById("coupon_code").required = false;
                $("#overlay").fadeIn(300);
                form.validate({
                    ignore:'',
                    rules: {
                        check1: "required",
                    }, errorPlacement: function (error, element) {
                        $("#overlay").fadeOut(300);
                        // console.log(element, error);
                        if (element.hasClass('check1') && element.hasClass('error')){
                            element.siblings('span').addClass('error');                        
                            element.siblings('p').text('Please check this checkbox.');
                            element.siblings('p').css('color', 'red');
                            element.siblings('p').css('display', 'block');
                        }
                    }
                });

                if (form.valid()) {
                    console.log(form[0]);
                    form[0].submit();
                    $("#overlay").fadeIn(300);
                }
            });
            
        })

        

    </script>
@endsection

