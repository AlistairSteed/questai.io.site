@extends('layouts.master')
@section('styles')
    <style>

    </style>
    
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/3.4.8/select2.css" /> -->
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
                    <li class="nav-item">
                        <!-- <a href="#" class="circle50">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="cart">
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
                    <li> <a href="#clientoverview" data-toggle="collapse" aria-expanded="true"> <i
                                class="far fa-file-alt"></i>Client Overview <i class="fas fa-chevron-down up-down"></i></a>
                        <ul class="collapse list-unstyled sidebar-submenu" id="clientoverview">                            
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-client-details') }}"><i class="far fa-edit"></i> Client Details</a> </li>
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-latest-activity') }}"><i class="far fa-clock"></i> Latest Activity</a> </li>
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-campaigns') }}"><i class="fas fa-bullhorn"></i> Campaigns</a> </li>
                        </ul>
                    </li>
                    @if (auth()->user()->canViewUserForClient($client))
                    <li> <a href="{{ route('users.index.user', $client->encrypted_id,'user') }}"><i class="fal fa-users"></i> Users</a> </li>
                    @endif
                    @if (auth()->user()->canCreateCampaign($client))
                    <li class="{{ isset($campaign) ? '' : 'active' }}"> <a href="{{ route('campaign.create', $client->encrypted_id) }}"><i class="fas fa-bullhorn"></i>New Campaigns</a> </li>
                    @endif
                </ul>
            </nav>
            <div class="content">
                <h2 class="text-primary">{{ isset($campaign) ? 'Edit Campaign' : 'New Campaign' }}</h2>
                <div class="new-campaign border-radius white-bg container">
                    <form class="container" id="campaign-form" method="post" action="javascript:;" data-action="{{ isset($campaign) ? route('campaign.update', [$client->encrypted_id, $campaign->encrypted_id]) : route('campaign.store', $client->encrypted_id) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group col">      
                            <h5>Job Title</h5>                      
                                <input type="text" class="form-control job-title cajobtitle" placeholder="@infoText('cajobtitle')" name="cajobtitle" value="{{ isset($campaign) ? $campaign->cajobtitle : old('cajobtitle') }}">
                            </div>
                            <div class="form-group col row">
                                <div class="form-group col">
                            <h5>City</h5>
                                <input type="text" class="form-control cacity" placeholder="City" name="cacity" value="{{ isset($campaign) ? $campaign->cacity : old('cacity') }}">
                            </div>
                                <div class="form-group col">
                                    <h5>Postcode</h5>
                                 <input type="text" class="form-control capostcode" placeholder="Postcode" name="capostcode" value="{{ isset($campaign) ? $campaign->capostcode : old('capostcode') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3 annual-salary ">
                            <h5>Annual Salary Range</h5>
                        </div>
                        <div class="form-group col-md-3 annual-salary">
                        <h5>From</h5>
                            <input type="text" class="form-control casalaryfrom" placeholder="From" name="casalaryfrom" onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46' value="{{ isset($campaign) ? $campaign->casalaryfrom : old('casalaryfrom') }}">
                        </div>
                        <div class="form-group col-md-3 annual-salary">
                         <h5>To</h5>
                            <input type="text" class="form-control casalaryto" placeholder="To" name="casalaryto" onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46' value="{{ isset($campaign) ? $campaign->casalaryto : old('casalaryto') }}">
                        </div>
                        <div class="form-group col-md-3 annual-salary">
                        <h5>OTE</h5>
                            <input type="text" class="form-control caote" placeholder="OTE" name="caote" onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46' value="{{ isset($campaign) ? $campaign->caote : old('caote') }}">
                        </div>
</div>
                        
                        <div class="form-group col-md-12">
                        <h5>Company Description</h5>

                            <div class="job-editor">

                                <div class="jobPost-editor jobPost-editor6 ca-comp-desc">
                                    {!! isset($campaign) ? $campaign->cacompdesc : $client->clcompanydesc !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                        <h5>Job Description</h5>
                            <div class="job-editor">
                                <div class="jobPost-editor jobPost-editor1 ca-job-desc">
                                    {!! isset($campaign) ? $campaign->cajobdesc : old('cajobdesc') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                        <h5>Essential Qualificiations</h5>
                            <div class="job-editor notrequired">
                                <div class="jobPost-editor jobPost-editor3 ca-essential-qual">
                                    {!! isset($campaign) ? $campaign->caessentialqual : old('caessentialqual') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                        <h5>Desirable Qualificiations</h5>
                            <div class="job-editor notrequired">
                                <div class="jobPost-editor jobPost-editor4 ca-desirable-qual">
                                    {!! isset($campaign) ? $campaign->cadesirablequal : old('cadesirablequal') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                        <h5>Additional Information</h5>

                            <div class="job-editor notrequired">
                                <div class="jobPost-editor jobPost-editor5 ca-additional">
                                    {!! isset($campaign) ? $campaign->caadditional : old('caadditional') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control cajobtypeid" name="cajobtypeid">
                               <option value="" selected disabled>Select Job Type</option>
                               @foreach($job_types as $job_type)
                                    @php
                                        $select = isset($campaign) && $job_type->jtid == $campaign->cajobtypeid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $job_type->jtid }}" {{ $select }}>{{ $job_type->jtdesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control caindustryid" name="caindustryid">
                                <option value="">Select Industry</option>
                                @foreach($industries as $industry)
                                    @php
                                        $select = isset($campaign) && $industry->inid == $campaign->caindustryid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $industry->inid }}" {{ $select }}>{{ $industry->indesc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <select class="form-control cafuntionid" name="cafuntionid">
                                <option value="">Select Function</option>
                                @foreach($functions as $function)
                                    @php
                                        $select = isset($campaign) && $function->fuid == $campaign->cafuntionid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $function->fuid }}" {{ $select }}>{{ $function->fudesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control caemploytypeid" name="caemploytypeid">
                                <option value="">Select Employment Type</option>
                                @foreach($employment_types as $employment_type)
                                    @php
                                        $select = isset($campaign) && $employment_type->etid == $campaign->caemploytypeid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $employment_type->etid }}" {{ $select }}>{{ $employment_type->etdesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control caexperienceid" name="caexperienceid">
                                <option value="">Select Experience</option>
                                @foreach($experiences as $experience)
                                    @php
                                        $select = isset($campaign) && $experience->exid == $campaign->caexperienceid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $experience->exid }}" {{ $select }}>{{ $experience->exdesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6"></div>
                        <div class="form-group col-md-6">
                            <div class="new-campaign-radio">
                                <div class="new-campaign-radio-left">
                                    <p>Remote Working Available?</p>
{{--                                    <input type="text" placeholder="Help Text here" />--}}
                                </div>

                                <div class="new-campaign-radio-right">
                                    <label class="radio">
                                        YES
                                        <input type="radio" class="caremote" name="caremote" value="1" checked {{ isset($campaign) && $campaign->caremote == 1 ? 'checked' : '' }}>
                                        <span class="mark"></span>
                                    </label>
                                    <label class="radio">
                                        No
                                        <input type="radio" class="caremote" name="caremote" value="0" {{ isset($campaign) && $campaign->caremote == 0 ? 'checked' : '' }}>
                                        <span class="mark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="new-campaign-radio">
                                <div class="new-campaign-radio-left">
                                    <p>Keep this campaign private (the role will not be advertised or publicly viewable without having a
                                        link to the campaign)</p>
{{--                                    <input type="text" placeholder="Help Text here" />--}}
                                </div>

                                <div class="new-campaign-radio-right">
                                    <label class="radio">
                                        YES
                                        <input type="radio" class="caprivate" name="caprivate" value="1" checked {{ isset($campaign) && $campaign->caprivate == 1 ? 'checked' : '' }}>
                                        <span class="mark"></span>
                                    </label>
                                    <label class="radio">
                                        No
                                        <input type="radio" class="caprivate" name="caprivate" value="0" {{ isset($campaign) && $campaign->caprivate == 0 ? 'checked' : '' }}>
                                        <span class="mark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="checkbox green">
                                @infoText('campaign_checkbox1')
                                <input type="checkbox" class="check1" name="check1">
                                <span class="mark"></span>
                                <p class="check1-msg"></p>
                            </label>
                            <label class="checkbox green">
                                @infoText('campaign_checkbox2')
                                <input type="checkbox" class="check2" name="check2">
                                <span class="mark"></span>
                                <p class="check2-msg"></p>
                            </label>
                        </div>
                        <div class="col-md-12 create-delete">
                            <p class="validation-msg"></p>
                            <a href="javascript:;" class="white-btn submit-cam-btn">
                                {{ isset($campaign) ? 'Update' : 'Create' }}
                            </a>
                            @if(isset($campaign))
                            <a href=" {{ route('campaign-overview', [$client->encrypted_id, $campaign->encrypted_id]) }}" class="white-btn">
                               Cancel
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End Hero Section -->

    @include('snippets.cart_popup')
@endsection

@section('scripts')
<!-- <script src="https://cdn.jsdelivr.net/select2/3.4.8/select2.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>


    <script>
        $(document).ready(function() {
            // $('#cajobtypeid').select2();
            
            $('.casalaryfrom').mask("#,##0", {reverse: true});
            $('.casalaryto').mask("#,##0", {reverse: true});
            $('.caote').mask("#,##0", {reverse: true});
        });
        $(document).ready(function (){
            var app_url = '{{ url('/') }}';

            $('#cajobtypeid').select2({
                ajax: {
                    delay: 250,
                    url: app_url + '/ajax-cajobtypeid-search',
                    dataType: 'json',
                    method: 'POST',
                    processResults: function (data) {
                        console.log(data)
                        return {
                            results: data
                        };
                    }
                }
            });

            $(document).on('change', 'input[type="checkbox"]', function (){
               if ($(this).is(':checked')){
                   $(this).siblings('span').removeClass('error');
                   $(this).siblings('p').css('display', 'none');
                   
               }
            });

            $(document).on('keyup', '.job-editor', function (){
                if (!$(this).find('.ql-editor').text()){
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });

            $(document).on('click', '.submit-cam-btn', function (e) {
                let form = $(this).closest("#campaign-form");
                $("#overlay").fadeIn(300);　
                form.validate({
                    ignore:'',
                    rules: {
                        cajobtitle: "required",
                        cacity: "required",
                        capostcode: "required",
                        casalaryfrom: "required",
                        casalaryto: "required",
                        caote: "required",
                        cajobtypeid: "required",
                        caindustryid: "required",
                        cafuntionid: "required",
                        caemploytypeid: "required",
                        caexperienceid: "required",
                        check1: "required",
                        check2: "required",
                        

                    }, errorPlacement: function (error, element) {
                        $("#overlay").fadeOut(300);
                        // console.log(element, error);
                        $(document).find('.validation-msg').text('Missing data, please review the boxes outlined in red.');
                        $(document).find('.validation-msg').css('color', 'red');

                        if (element.hasClass('check1') && element.hasClass('error')){
                            element.siblings('span').addClass('error');                            
                            element.siblings('p').text('Please check this checkbox.');
                            element.siblings('p').css('color', 'red');
                            element.siblings('p').css('display', 'block');
                        }
                        if (element.hasClass('check2') && element.hasClass('error')){
                            element.siblings('span').addClass('error');                            
                            element.siblings('p').text('Please check this checkbox.');
                            element.siblings('p').css('color', 'red');
                            element.siblings('p').css('display', 'block');
                        }
                    }
                });

                var is_valid = true;
                $('.job-editor').each(function (key, val){
                    if (!$(val).find('.ql-editor').text()){
                       $(val).addClass('error');
                       is_valid = false;
                   } else {
                       $(val).removeClass('error');
                   }
                });

                
                $('.notrequired').each(function (key, val){                       
                    $(val).removeClass('error');
                       is_valid = true;
                });


                if (form.valid()) {
                    if (!is_valid){
                        return false;
                    }

                    // var formData = new FormData(form[0]);
                    var formData = {
                        cajobtitle: $('.cajobtitle').val(),
                        cacity: $('.cacity').val(),
                        capostcode: $('.capostcode').val(),
                        casalaryfrom: $('.casalaryfrom').val(),
                        casalaryto: $('.casalaryto').val(),
                        caote: $('.caote').val(),
                        cajobtypeid: $('.cajobtypeid').val(),
                        caindustryid: $('.caindustryid').val(),
                        cafuntionid: $('.cafuntionid').val(),
                        caemploytypeid: $('.caemploytypeid').val(),
                        caexperienceid: $('.caexperienceid').val(),
                        caremote: $('.caremote:checked').val(),
                        caprivate: $('.caprivate:checked').val(),
                        cacompdesc: $('.ca-comp-desc .ql-editor').html(),
                        cajobdesc: $('.ca-job-desc .ql-editor').html(),
                        caessentialqual: $('.ca-essential-qual .ql-editor').html(),
                        cadesirablequal: $('.ca-desirable-qual .ql-editor').html(),
                        caadditional: $('.ca-additional .ql-editor').html(),
                    };
                    
                    $(document).find('.validation-msg').css('display', 'none');
                    
                    $.ajax({
                        url: form.attr('data-action'),
                        method: 'post',
                        data: formData,
                        success: function (res) {
                        $("#overlay").fadeIn(300);　
                            console.log(res);
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update') {
                                toastr.success("Campaign updated successfully", "Success");
                                setTimeout(() => {
                                    window.location="{{route('campaign-overview', [$client->encrypted_id, isset($campaign->encrypted_id)?$campaign->encrypted_id:0])}}";
                                    $("#overlay").fadeOut(300);
                                }, 3000);                                    
                            } else {
                                toastr.success("Campaign added successfully", "Success");
                                setTimeout(function(){
                                    window.location="{{ route('client-overview', $client->encrypted_id.'#pills-campaigns') }}";
                                    $("#overlay").fadeOut(300);
                                }, 3000);
                            }
                        },
                        error: function (err) {
                            $("#overlay").fadeOut(300);
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                        }
                    });
                }
            })

            
            
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
        })

    </script>
@endsection

