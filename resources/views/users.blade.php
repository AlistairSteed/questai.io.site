@extends('layouts.master')
@section('styles')
    <style>
        /* .user-password{
            width: calc(100% - 140px);
        } */
    </style>
@endsection
@section('header')
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="{{ route('client-selection') }}">
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
                    <li class="nav-item">
                        <!-- <a href="javascript:;" class="circle50">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="Shopping basket">
                        </a> -->
                        @if (auth()->user()->canShowBasketOrMyOrderPage())
                        <a href="#" class="circle50" data-toggle="modal" id="cart-popup-data" data-target="#cartpopup">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="cart">
                        </a>
                        @endif
                    </li>

                </ul>
                <div class="header-right">
                    <!-- <form class="form-inline search-header my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <a href="javascript:;" class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="Search"></a>
                    </form> -->
                    <!-- <a href="javascript:;" class="bell header-right-link">
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
                    <li> <a href="#clientoverview" data-toggle="collapse" aria-expanded="false"> 
                        <i class="far fa-file-alt"></i>Client Overview <i class="fas fa-chevron-down up-down"></i></a>
                        <ul class="collapse list-unstyled sidebar-submenu" id="clientoverview">
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-client-details') }}"><i class="far fa-edit"></i> Client Details</a> </li>
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-latest-activity') }}"><i class="far fa-clock"></i> Latest Activity</a> </li>
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-campaigns') }}"><i class="fas fa-bullhorn"></i> Campaigns</a> </li>
                        </ul>
                    </li>
                    <li class="active"> <a href="{{ route('users.index', $client->encrypted_id) }}"><i class="fal fa-users"></i> Users</a> </li>                    
                    @if (auth()->user()->canCreateCampaign($client))
                    <li> <a href="{{ route('campaign.create', $client->encrypted_id) }}"><i class="fas fa-bullhorn"></i>New Campaigns</a> </li>
                    @endif
                </ul>
            </nav>

            <div class="content">
                <h2 class="text-primary">Users</h2>
                <div class="setup-accordion">
                    <div class="accordion append-users" id="accordionExample">

                    </div>
                </div>
                @if (auth()->user()->canCreateUserForClient($client))
                <div class="add-more">
                    <a href="javascript:;" class="circle50 add-more-user"><i class="fas fa-plus"></i></a>
                </div>
                @endif
            </div>

        </div>
    </section>
    <!-- End Hero Section -->

    <div class="card" id="user-block" style="display: none">
        <div class="card-header">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span class="title-text"> User </span>
                    <img src="{{ asset('assets/images/arrow-down.png') }}" alt="arrow">
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse collapse-block" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <form class="row user-form" method="post" action="javascript:;" data-action="{{ route('users.store', $client->encrypted_id) }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" class="user-id">
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control first-name" name="first_name" placeholder="First Name" />
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control last-name" name="last_name" placeholder="Last Name" />
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control user-email" name="user_email" placeholder="Email address" />
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="password" class="form-control user-password" name="user_password" placeholder="password"/>
                    </div>
                    
                    <div class="form-group col-lg-6">
                        <label class="checkbox green">
                            View All Campaigns 
                            <input type="checkbox" class="check1" name="view_all_campaigns">
                            <span class="mark"></span>
                        </label>
                    </div>
                    <div class="form-group upload-delete col-lg-6">                      
                        <div class="delete">
                            <button type="submit" class="user-save-btn" style="background: none">
                                <a href="javascript:;" class="circle50">
                                    <img src="{{ asset('assets/images/file.png') }}" alt="file">
                                </a>
                            </button>
                            
                            @if (auth()->user()->canDeleteUserForClient($client))
                            <a href="javascript:;" class="circle50 user-delete-btn">
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
    @include('snippets.cart_popup')
@endsection

@section('scripts')


    <script>

        $(document).ready(function () {
            var app_url = '{{ url('/') }}';

            getUsers();
            function getUsers() {
                $("#overlay").fadeIn(300);　
                $.ajax({
                    method: 'get',
                    url: app_url + '/users/indexAjax/' + '{{ $client_id }}',
                    success: function (res) {
                        res.data.map(function (section) {
                            console.log(section);
                            let item = ($(document).find('#user-block').clone()).show().removeAttr('id').attr('data-id', section.usid);
                            item.find('.user-id').val(section.usid);
                            item.find('.first-name').val(section.usfirstname);
                            item.find('.last-name').val(section.uslastname);
                            item.find('.user-email').val(section.usemail);
                            item.find('.title-text').text(section.usfirstname + ' ' + section.uslastname);
                            item.find('.card-header button').attr('data-target', '#collapse'+section.usid);
                            item.find('.collapse-block').attr('id', 'collapse'+section.usid);
                            if(section.user_access && section.user_access.length > 0){
                                item.find('.check1').prop('checked', 'checked');
                            }else{
                                item.find('.check1').prop('unchecked', 'unchecked');
                            }
                            $(document).find('.append-users').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                    }
                });
            }

            $(document).on('click', '.add-more-user', function (){
                let length = $('.append-users .card').length + 1;
                let item = ($(document).find('#user-block').clone()).show().removeAttr('id');
                item.find('.card-header button').attr('data-target', '#collapse_new'+ length);
                item.find('.collapse-block').attr('id', 'collapse_new'+ length);
                $('.append-users').append(item);
                $('.add-more').addClass('d-none');
                item.find('.card-header button').trigger('click');
            });

            $(document).on('click', '.user-save-btn', function (e){
                var $this = $(this);
                let form = $this.closest(".user-form");                
                $("#overlay").fadeIn(300);　
                form.validate({
                    ignore:'',
                    rules: {
                        first_name: "required",
                        last_name: "required",
                        user_email: {
                            "required" : true,
                            "email" : true
                        },
                        user_password: {
                            "required" : $this.closest('.card').attr('data-id') ? false : true,
                        },
                    }, errorPlacement: function (error, element) {
                        console.log(element, error);
                        $("#overlay").fadeOut(300);
                    }
                });

                if (form.valid()) {
                    var formData = new FormData(form[0]);
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

                            if (res.status == 'error'){
                                $("#overlay").fadeOut(300);
                                toastr.error(res.message, "Error");
                                return false;
                            }
                            form.find('.user-id').val(res.data.usid)
                            form.closest('.card').attr('data-id', res.data.usid);
                            form.closest('.card').find('.title-text').text(res.data.usfirstname + ' ' + res.data.uslastname);
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update'){
                                toastr.success("User updated successfully", "Success");
                                window.location.reload();
                                $("#overlay").fadeOut(300);
                            } else {
                                toastr.success("User added successfully", "Success");
                                window.location.reload();
                                $("#overlay").fadeOut(300);
                            }
                            
                        },
                        error: function (err) {
                            $("#overlay").fadeOut(300);
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                        }
                    });
                }
            });

            $(document).on('click', '.user-delete-btn', function (e){
                $('.add-more').removeClass('d-none');
                let user_id = $(this).closest('.user-form').find('.user-id').val();
                if (!user_id){
                    $(this).closest('.card').remove();
                    return false;
                }
                $('#deleteConfirmModal').modal();
                $('#deleteConfirmModal').find('.delete-confirm').attr('data-id', user_id);
            });

            $(document).on('click', '.delete-confirm', function (e){
                let user_id = $(this).attr('data-id');
                $("#overlay").fadeIn(300);　
                $.ajax({
                    url: app_url + '/users/delete/' + user_id,
                    method: 'get',
                    success: function (res) {
                        toastr.options = {
                            "progressBar": true,
                        };
                        toastr.success("User deleted successfully", "Success");
                        $('.card[data-id="'+ user_id +'"]').remove();
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
                $('#deleteConfirmModal').modal('hide');
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
                        // console.log(res.basketData.basket_lines);                            
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
            
        });

        


    </script>
@endsection

