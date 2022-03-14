@extends('layouts.master')
@section('styles')
    <style>

        .setup-accordion .card {
            filter: none;
        }

        .setup-accordion .card .card-body {
            padding: 15px;
        }

        .card {
            border: none;
        }

        .setup-accordion .card .card-body .form-group {
            margin-bottom: 0;
        }
        .grant-access-block{
            padding: 10px 0;
        }
        .cv-main.append-candidateassessmentadditional-data {
            justify-content: normal !important;
        }
        .cv-main.append-campaignassessmentadditional-data {
            justify-content: normal !important;
        }
        button.btn.btn-primary.white-btn.cart-complete-btn:disabled{
            background-color: #174b43 !important;
            color: #fff !important;
        }
        a.candidate-assessment-additional-selected-category-name {
            text-decoration: none;
            color: #898989;
        }
        a.candidate-assessment-additional-reset-category-name {
            margin-left: 15px !important;
        }
        
        a.campaign-assessment-additional-selected-category-name {
            color: #898989;
        }
        a.campaign-assessment-additional-reset-category-name {
            margin-left: 15px !important;
        }
        a.candidate-assessment-additional-reset-category-name {
            cursor: pointer;
        }
        a.campaign-assessment-additional-reset-category-name {
            cursor: pointer;
        }

        .client-overview .company-box.campaing-box .box.red .box-bottom span.status:after {
            background-color: #e73000;
        }
        .client-overview .company-box.campaing-box .box.green .box-bottom span.status:after {
            background-color: #4f8d4a;
        }
        .client-overview .company-box.campaing-box .box.yellow .box-bottom span.status:after {
            background-color: #ffc52e;
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client-selection') }}">Client Selection</a>
                    </li>
                    @if (auth()->user()->canGrantAccessCampaign($campaign))
                    <li class="nav-item">
                        <a class="nav-link" id="grant-access-btn" href="javascript:;">Grant Access</a>
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
                        <button class="btn  header-right-link btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton"
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
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-client-details') }}"><i class="far fa-edit"></i> Client Details</a> </li>
                            <li> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-latest-activity') }}"><i class="far fa-clock"></i> Latest Activity</a> </li>
                            <li class="active"> <a href="{{ route('client-overview', $client->encrypted_id.'#pills-campaigns') }}"><i class="fas fa-bullhorn"></i> Campaigns</a> 
                                <ul class="collapse list-unstyled show sidebar-submenu pt-0" id="clientoverview">
                                    <li class="active" data-id="pills-client-details-tab" id="client-details-title"> <a href="#pills-client-details" role="tab" id="tab_11"><i class="far fa-edit"></i> Overview</a> </li>

                                    <li data-id="pills-latest-activity-tab" id="latest-activity-title"> <a href="#pills-latest-activity" role="tab" id="tab_12"><i class="far fa-clock"></i> Latest Activity</a> </li>

                                    <li data-id="pills-candidates-tab" id="pills-candidates-title"> <a href="#pills-candidates" role="tab" id="tab_13"><i class="fas fa-users"></i> Candidates</a> </li>
                                </ul>                        
                            </li>
                        </ul>
                    </li>
                    @if (auth()->user()->canViewUserForClient($client))
                    <li> <a href="{{ route('users.index', $client->encrypted_id) }}"><i class="fas fa-users"></i> Users</a> </li>
                    @endif
                    @if (auth()->user()->canCreateCampaign($client))
                    <li> <a href="{{ route('campaign.create', $client->encrypted_id) }}"><i class="fas fa-bullhorn"></i>New Campaigns</a> </li>
                    @endif
                </ul>
            </nav>
            <div class="content sales client-overview">
                <h2 class="text-primary mb-3">Campaign Overview</h2>
                <div class="text-center mb-5">
                    <h5 class="text-primary mb-2">{{$clientData->clname}}</h5>
                    <h5 class="text-primary mb-2">{{ $campaign->cajobtitle }}</h5>
                    <div class="box-single-bottom mb-2">
                        <ul class="single-box-contact justify-content-center">
                            <li>
                                <img src="{{ asset('assets/images/location-big.png') }}" alt="Location" style="height: 20px;">
                                <p class="d-inline-block">{{ $campaign->caaddress1 }} &nbsp; {{ $campaign->caaddress2 }} &nbsp; {{ $campaign->cacity }} &nbsp;</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tabbing-search-head justify-content-center">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation" id="client-details-title">
                            <a class="nav-link active" id="pills-client-details-tab" data-toggle="pill" href="#pills-client-details"
                               role="tab" aria-controls="pills-client-details" aria-selected="true">Campaign Details</a>
                        </li>
                        <li class="nav-item" role="presentation" id="latest-activity-title">
                            <a class="nav-link" id="pills-latest-activity-tab" data-toggle="pill" href="#pills-latest-activity"
                               role="tab" aria-controls="pills-latest-activity" aria-selected="false">Latest Activity</a>
                        </li>
                        <li class="nav-item" role="presentation" id="pills-candidates-title">
                            <a class="nav-link" id="pills-candidates-tab" data-toggle="pill" href="#pills-candidates" role="tab"
                               aria-controls="pills-candidates" aria-selected="false">Candidates</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent" data-id="{{ $campaign->caid }}">
                    <div class="tab-pane fade show active" id="pills-client-details" role="tabpanel"
                         aria-labelledby="pills-client-details-tab">
                        <div class="company-box box-single-outer">
                            <div class="box-single campaign-detail">
                                <div class="box-single-top">
                                    <h4>Campaign Details</h4>
                                    <p>
                                        {{ $campaign->cajobtitle }}
                                    </p>
                                </div>
                                <div class="box-single-bottom">
                                    <ul class="single-box-contact justify-content-center">
                                        <li>
                                            <img src="{{ asset('assets/images/location-big.png') }}" alt="Location">
                                            <p>{{ $campaign->caaddress1 }} &nbsp; {{ $campaign->caaddress2 }} &nbsp; {{ $campaign->cacity }} &nbsp;</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="edition">
                                    <div class="edition-left">
                                        <ul>
                                            <li>
                                                <a href="javascript:;" class="circle50 copy-url-btn" title="Copy">
                                                    <img src="{{ asset('assets/images/file2.png') }}" alt="File">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $campaign->calink }}" class="white-btn" id="product-url" target="_blank">Campaign Advert</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="edition-right">
                                        <ul>
                                                @if (auth()->user()->canUpdateCampaign($campaign))
                                                <li>
                                                    <a href="{{ route('campaign.edit', [$client->encrypted_id, $campaign->encrypted_id]) }}" class="white-btn">Edit</a>
                                                </li>
                                                @endif
                                                @if (auth()->user()->canApproveCampaign($campaign) && $campaign->castatus >0)
                                                <li>
                                                    <a href="javascript:;" id="approve-campaign" data-id="4" data-string="approve"  class="white-btn campaign-status-btn">Approve</a>
                                                </li>
                                                @endif
                                                @if (auth()->user()->canBuyCampaign($campaign))
                                                <li>
                                                    <a href="javascript:;" class="white-btn" data-toggle="modal" id="campaign_assessmentadditional" data-target="#campingassessmentadditional">Buy Optional Extras</a>
                                                </li>
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="approved" id="campaign-status">
                                    <h5>{{ \App\Models\Campaign::getCampaignStatus($campaign->castatus) }}</h5>
                                    <p>by {{ $campaign->caapprovedby }} on {{ \Carbon\Carbon::parse($campaign->caapprovedon)->format('Y-m-d') }} at {{ \Carbon\Carbon::parse($campaign->caapprovedon)->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                            @if (auth()->user()->canEndCampaign($campaign))
                            <div class="end-campaign">
                                <a href="javascript:;" class="white-btn campaign-status-btn" id="end-campaign" data-string="end" data-id="9">End Campaign</a>
                            </div>
                            @endif
                    </div>
                    <div class="tab-pane fade" id="pills-latest-activity" role="tabpanel"
                         aria-labelledby="pills-latest-activity-tab">
                        <div class="company-box">
                            @foreach($activities as $activity)
                            <div class="box-outer">
                                <a href="javascript:;" class="box">
                                    <div class="box-top">
                                        <div class="date-time">
                                            <span><img src="{{ asset('assets/images/calendar.png') }}" alt="Date"> {{ \Carbon\Carbon::parse($activity->audatetime)->format('Y-m-d') }}</span>
                                            <span>{{ \Carbon\Carbon::parse($activity->audatetime)->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="box-bottom">
                                        <div class="info">
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
                    <div class="tab-pane fade" id="pills-candidates" role="tabpanel" aria-labelledby="pills-candidates-tab">
                        <div class="filter">
                            <div class="filter-head">
                                <h6>Filter</h6>
                            </div>
                            <div class="filter-body">
                                <div class="filter-left">
                                    <ul>
                                        <li>
{{--                                            <a href="javascript:;">--}}
{{--                                                Completed--}}
{{--                                                <i class="fas fa-chevron-down"></i>--}}
{{--                                            </a>--}}
                                                <select id="app-status-filter" class="form-control">
                                                    <option value="" selected>All</option>
                                                    <option value="0">Incomplete</option>
                                                    <option value="1">Completed</option>
                                                    <option value="5">Assistance Required</option>
                                                    <option value="8">Withdrawn</option>
                                                    <option value="9">Other</option>
                                                </select>
                                        </li>
                                        <li>
{{--                                            <a href="#">--}}
{{--                                                Sort by--}}
{{--                                                <i class="fas fa-chevron-down"></i>--}}
{{--                                            </a>--}}

                                            <select id="sort-by-filter" class="form-control">
                                                <option value="" selected>Latest</option>
                                                <option value="app_date_asc">Application date - ASC</option>
                                                <option value="app_date_desc">Application date - DESC</option>
                                                <option value="name_asc">Name - ASC</option>
                                                <option value="name_desc">Name - DESC</option>
                                                <option value="profile_score_asc">Profile score - ASC</option>
                                                <option value="profile_score_desc">Profile score - DESC</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="filter-right">
                                    <form class="form-inline search-header">
                                        <input class="form-control" id="candidate-search" type="search" placeholder="Search" aria-label="Search">
                                        <a href="javascript:;" class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="search"></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="company-box campaing-box append-candidates">

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>
    <!-- End Hero Section -->


    <div class="box-outer candidate-block" id="candidate-block" style="display: none">
        <div class="box">
            <div class="box-top">
                <h4></h4>
                <div class="date-time">
                    <span><img src="{{ asset('assets/images/calendar.png') }}" alt="Date">
                        &nbsp;<span class="date"></span> </span>
                    <span class="time"></span>
                </div>
            </div>
            <div class="box-bottom">
                <span class="casource">Source: </span>
                <span class="status">Application Status: 
                    <span class="application_status"></span>
                </span>
                    
                <span class="atscore">Profile Score: </span>

                <div class="read-like">
                    <a href="#" class="read-more" data-toggle="modal" id="candidate_Id" data-target="#clientinformation">More Information <i class="fas fa-chevron-right"></i></a>
                    <div class="like-comment">
                        <div class="like-comment-left">         
                            @if (auth()->user()->canCandidateStatusChangeCampaign($campaign))
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="green status-btn gsbtn" data-id="20" title="Accepted"><i class="fas fa-thumbs-up"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="yellow status-btn ysbtn" data-id="35" title="Good Candidate Rejected"><i class="fas fa-thumbs-down"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="red status-btn rsbtn" data-id="45" title="Rejected"><i class="fas fa-thumbs-down"></i></a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                        <div class="like-comment-right">
                            <ul>                  
                                    <li>
                                        <a href="javascript:;" class="green candidateId" id="candidateId" title="comment" data-toggle="modal" data-target="#candidate_comment"><img src="{{ asset('assets/images/comment-green.png') }}" alt="comment" class="candidate_comment_img"></a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="approved">
                <h5></h5>
            </div>
        </div>
    </div>


    <!-- client more information popup -->
    <div class="client-information-popup">
        <!-- Modal -->
        <div class="modal fade" id="clientinformation" tabindex="-1" role="dialog" aria-labelledby="clientinformation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content popup">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="popup-box text-center pt-lg-5 mt-lg-3">
                            <h3>CV, Video interview and Verification Information</h3>   
                            <input type="hidden" name="candidate-Ids" class="candidate-id" id="candidate-Ids" value="">
                            <span class="client-name candidate-name"></span>
                        </div>
                        <div class="popup-box">
                            <div class="assessments">
                                <div class="cv-main append-candidate-data">

                                </div>
                                <div class="cv-block-outer" id="cv-block-candidate-sec" style="display: none">
                                    <div class="cv-block">
                                         <div class="cv-head">
                                                <h5 class="cv-type"></h5>
                                        </div>
                                        <div class="cv-info">
                                            <div class="cv-info-block">
                                                <span>ID</span>
                                                <span class="cv-id"></span>
                                            </div>
                                            <div class="cv-info-block">
                                                <span>Score</span>
                                                <span class="cv-score"></span>
                                            </div>
                                        </div>
                                        <a class="cv-view candidate-attachment-link" id="attach-link" target="_blank">view</a>
                                    </div>
                                </div>
                            </div>
                                @if (auth()->user()->canCandidateBuy($campaign))
                                <div class="buy-assessment-btn">
                                    <a href="#" class="white-btn" data-toggle="modal" id="candidate_assessmentadditional" data-target="#candidateassessmentadditional">Buy Assessments</a>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('snippets.candidate_comment_popup')
    @include('snippets.cart_popup')
    @include('snippets.client_information_popup')
    @include('snippets.assessment-additional-popup')
    @include('snippets.grant_user_access_popup')
    @include('snippets.delete_confirmation')
    @include('snippets.candidate-assessment-additional-popup')
    @include('snippets.campaign-assessment-additional-popup')

@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            var campaignStatus = {{$campaignStatus}};
            if(campaignStatus == 4){
                $('#approve-campaign').attr("style","color: #fff !important; background-color: #174b43 !important");
                $('#approve-campaign').removeAttr("href");
                $('#approve-campaign').removeClass("campaign-status-btn");
            }else if(campaignStatus == 9){                
                $('#end-campaign').attr("style","color: #fff !important; background-color: #174b43 !important");
                $('#end-campaign').removeAttr("href");
                $('#end-campaign').removeClass("campaign-status-btn");
            }

            // $(function() {
            //     var hash = window.location.hash;
            //     hash && $('ul.nav a[href="' + hash + '"]').tab('show');    

            //     $('.nav-pills a').click(function(e) {
            //         $(this).tab('show');
            //         window.location.hash = this.hash;
            //     });
            // });
            
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
                if (hash == '#pills-candidates') {
                    $('#pills-candidates-title').addClass('active').siblings().removeClass('active');
                }

                $('.nav-pills a').click(function(e) {
                    $(this).tab('show');
                    window.location.hash = this.hash;
                });
            });
                
            var app_url = '{{ url('/') }}';

            $(document).on('click', '#grant-access-btn', function () {
                $('#grantAccess').modal();
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/campaign-grant-access/' + '{{ $client_id }}' + '/' + '{{ $campaign->caid }}',
                    method: 'get',
                    success: function (res) {
                        console.log(res);

                        if (res.status == 'success' && res.data) {
                           var html = '';
                            html += '<option value="" selected> Select user </option>';
                            $(res.users).each(function (key, user) {
                                html += '<option value="' + user['usid'] + '"> ' + user['usfirstname'] + ' ' + user['uslastname'] + '</option>';
                            });
                            $('.user-select').html(html);

                            // $(document).find('.append-grant-access').html('');
                            res.data.map(function (section) {
                                console.log(section);
                                let item = ($(document).find('#grant-access-block').clone()).removeAttr('id').attr('data-id', section.uaid);
                                item.css('display', 'flex');
                                item.find('.uaid').val(section.uaid);
                                item.find('.grant-access-user-id').val(section.uausid);
                                item.find(".user-select option[value='" + section.uausid + "']").attr("selected","selected");
                                item.find(".user-access-select option[value='" + section.uaaccess + "']").attr("selected","selected");
                                
                                $(document).find('.append-grant-access').append(item);

                            });
                        }
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
            });

            $(document).on('click', '.add-more-access', function (){
                // let length = $('.append-grant-access .grant-access-block').length + 1;
                let item = ($(document).find('#grant-access-block').clone()).removeAttr('id');
                item.css('display', 'flex');
                $('.append-grant-access').append(item);
            });

            $(document).on('click', '.grant-access-save-btn', function (e){
                var $this = $(this);
                let form = $this.closest(".grant-access-form");
                $("#overlay").fadeIn(300);

                form.validate({
                    ignore:'',
                    rules: {
                        user: "required",
                        user_access: "required",
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
                        processData: false,
                        success: function (res) {
                            console.log(res);

                            if (res.status == 'error'){
                                toastr.error(res.message, "Error");
                                return false;
                                $("#overlay").fadeOut(300);
                            }
                            if (res.status == 'success' && res.data) {
                                var html = '';
                                html += '<option value="" selected> Select user </option>';
                                $(res.users).each(function (key, user) {
                                    html += '<option value="' + user['usid'] + '"> ' + user['usfirstname'] + ' ' + user['uslastname'] + '</option>';
                                });
                                $('.user-select').html(html);

                                $(document).find('.append-grant-access').html('');
                                res.data.map(function (section) {
                                    console.log(section);
                                    let item = ($(document).find('#grant-access-block').clone()).removeAttr('id').attr('data-id', section.uaid);
                                    item.css('display', 'flex');
                                    item.find('.uaid').val(section.uaid);
                                    item.find('.grant-access-user-id').val(section.uausid);
                                    item.find(".user-select option[value='" + section.uausid + "']").attr("selected","selected");
                                    item.find(".user-access-select option[value='" + section.uaaccess + "']").attr("selected","selected");
                                    
                                    $(document).find('.append-grant-access').append(item);

                                });

                            }
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update'){
                                toastr.success("Grant user access updated successfully", "Success");
                            } else {
                                toastr.success("Grant user access added successfully", "Success");
                            }
                            $("#overlay").fadeOut(300);
                        },
                        error: function (err) {
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                            $("#overlay").fadeOut(300);
                        }
                    });
                    
                }
            });

            $(document).on('click', '.grant-access-delete-btn', function (e){
                let user_id = $(this).closest('.grant-access-form').find('.grant-access-user-id').val();
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
                    url: app_url + '/grant-access/delete/' + user_id,
                    // method: 'get',
                    method: 'post',
                    data: {
                        campaign_id : "{{$id}}",
                        client_id : "{{$client_id}}",
                    },
                    success: function (res) {
                        
                        if (res.status == 'success' && res.data) {
                            var html = '';
                            html += '<option value="" selected> Select user </option>';
                            $(res.users).each(function (key, user) {
                                html += '<option value="' + user['usid'] + '"> ' + user['usfirstname'] + ' ' + user['uslastname'] + '</option>';
                            });
                            $('.user-select').html(html);

                            $(document).find('.append-grant-access').html('');
                            res.data.map(function (section) {
                                console.log(section);
                                let item = ($(document).find('#grant-access-block').clone()).removeAttr('id').attr('data-id', section.uaid);
                                item.css('display', 'flex');
                                item.find('.grant-access-user-id').val(section.uausid);
                                item.find(".user-select option[value='" + section.uausid + "']").attr("selected","selected");
                                item.find(".user-access-select option[value='" + section.uaaccess + "']").attr("selected","selected");
                                
                                $(document).find('.append-grant-access').append(item);

                            });
                        }
                        toastr.options = {
                            "progressBar": true,
                        };
                        toastr.success("User grant access deleted successfully", "Success");
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

            $(document).on('click', '.campaign-status-btn', function () {
                $("#overlay").fadeIn(300);
                var status = $(this).attr('data-id');
                var string = $(this).attr('data-string');
                var cam_id = $(this).closest('#pills-tabContent').attr('data-id');

                $.ajax({
                    url: app_url + '/campaign-status-approve',
                    method: 'post',
                    data: {
                        status : status,
                        string : string,
                        cam_id : cam_id
                    },
                    success: function (res) {
                        console.log();

                        if (res.status == 'success' && res.data){
                            // candidate_block.find('.box').removeClass().addClass('box').addClass(res.data.app_status).addClass(res.data.final_status_class);
                            // candidate_block.find('.approved h5').text(res.data.final_status);
                            if(res.data.castatus == 4){
                                toastr.success("Campaign approved successfully!", "Success");      
                            }else if(res.data.castatus == 9) {                                
                                toastr.success("Campaign closed successfully!", "Success");   
                            }                     
                            setTimeout(function(){
                                window.location.reload();
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
            });

            $(document).on('click', '#clientoverview li', function (){
                $(this).addClass('active').siblings().removeClass('active');
                $('#' + $(this).attr('data-id')).trigger('click');
            });

            $(document).on('click', '.nav-item .nav-link', function (){
                let id = $(this).attr('id')
                $('#clientoverview li[data-id="'+ id +'"]').addClass('active').siblings().removeClass('active');
            });

            var $temp = $("<input>");
            var $url = $('#product-url').attr('href');

            $('.copy-url-btn').on('click', function() {
                $("body").append($temp);
                $temp.val($url).select();
                document.execCommand("copy");
                $temp.remove();
                
                toastr.success("Campaign advertising link copied to clipboard.", "Success");  
            })

            var app_status = $('#app-status-filter').val();
            var sort_by = $('#sort-by-filter').val();
            var search = $('#candidate-search').val();
            getCandidates(app_status, sort_by, search);

            $(document).on('change', '#app-status-filter', function (){
                app_status = $(this).val();
                getCandidates(app_status, sort_by, search);
            })

            $(document).on('change', '#sort-by-filter', function (){
                sort_by = $(this).val();
                getCandidates(app_status, sort_by, search);
            })

            $(document).on('keyup', '#candidate-search', function (e){
                search = $(this).val();
                getCandidates(app_status, sort_by, search);
                return e.which !== 13;
            })

            function getCandidates(app_status, sort_by, search)
            {
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-candidates',
                    method: 'post',
                    data: {
                        campaign_id : '{{ $id }}',
                        client_id : "{{$client_id}}",
                        app_status : app_status,
                        sort_by : sort_by,
                        search : search,
                    },
                    success: function (res) {
                        // console.log(res.comments);
                        $(document).find('.append-candidates').html('');
                        res.data.map(function (section) {   
                            let item = ($(document).find('#candidate-block').clone()).show().removeAttr('id').attr('data-id', section.caid);
                            item.find('.box').addClass(section.app_status);
                            item.find('.box').addClass(section.final_status_class);
                            item.find('.box-top h4').text(section.cafirstnames + ' ' + section.calastname);
                            item.find('.date-time .date').text(section.date);
                            item.find('.date-time .time').text(section.time);
                            item.find('.casource').text('Source: ' + section.casource);
                            item.find('.atscore').text('Profile Score: ' + section.atscore + '%');
                            item.find('.approved h5').text(section.final_status);
                            
                            if(section.final_status_class == 'bg-green'){
                                item.find('.gsbtn').css("background-color", "#4f8d4a");
                                item.find('.gsbtn').css("color", "#fff");                
                                item.find('.application_status').css("background-color", "#4f8d4a");     
                            }else if(section.final_status_class == 'bg-amber'){
                                item.find('.ysbtn').css("background-color", "#ffc52e");
                                item.find('.ysbtn').css("color", "#fff");
                                item.find('.application_status').css("background-color", "#ffc52e");   
                            }else if(section.final_status_class == 'bg-red'){
                                item.find('.rsbtn').css("background-color", "#e73100");
                                item.find('.rsbtn').css("color", "#fff");
                                item.find('.application_status').css("background-color", "#e73100");   
                            }

                            item.find('#candidateId').attr('data-id', section.caid);
                            item.find('#candidate_Id').attr('data-id', section.caid);
                            
                            res.comments.map(function (section2) {
                                console.log(section2);
                                if(section2.cocandidateid == section.caid){
                                    item.find('.candidateId').css("background-color", "#4f8d4a");
                                    item.find('.candidate_comment_img').css("filter", "brightness(0) invert(1)");
                                }
                            });
                            
                            $(document).find('.append-candidates').append(item);
                        });
                        $("#overlay").fadeOut(300);

                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
            }

            $(document).on('click', '.status-btn', function (){

                var status = $(this).attr('data-id');
                if(status == 20){
                    var status_name = 'Accepted';
                }else if(status == 35){
                    var status_name = 'Good candidate Rejected';                    
                }else if(status == 45){
                    var status_name = 'Rejected';                    
                }
                var can_id = $(this).closest('.candidate-block').attr('data-id');
                var candidate_block = $(this).closest('.candidate-block');
                swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to change the candidate status to "+ status_name + " ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) { 
                    if (result.value) {
                    $("#overlay").fadeIn(300);
                        $.ajax({
                            url: app_url + '/candidate-status-change',
                            method: 'post',
                            data: {
                                status : status,
                                can_id : can_id
                            },
                            success: function (res) {
                                console.log(res);
                                if (res.status == 'success' && res.data){
                                    candidate_block.find('.box').removeClass().addClass('box').addClass(res.data.app_status).addClass(res.data.final_status_class);
                                    candidate_block.find('.approved h5').text(res.data.final_status);
                                    candidate_block.find('.gsbtn').css("background-color", "#fff");
                                    candidate_block.find('.gsbtn').css("color", "#4f8d4a");
                                    candidate_block.find('.ysbtn').css("background-color", "#fff");
                                    candidate_block.find('.ysbtn').css("color", "#ffc52e");
                                    candidate_block.find('.rsbtn').css("background-color", "#fff");
                                    candidate_block.find('.rsbtn').css("color", "#e73100");
                                    if(res.data.final_status_class == 'bg-green'){
                                        candidate_block.find('.gsbtn').css("background-color", "#4f8d4a");
                                        candidate_block.find('.gsbtn').css("color", "#fff");
                                        candidate_block.find('.application_status').css("background-color", "#4f8d4a");     
                                    }else if(res.data.final_status_class == 'bg-amber'){
                                        candidate_block.find('.ysbtn').css("background-color", "#ffc52e");
                                        candidate_block.find('.ysbtn').css("color", "#fff");
                                        candidate_block.find('.application_status').css("background-color", "#ffc52e"); 
                                    }else if(res.data.final_status_class == 'bg-red'){
                                        candidate_block.find('.rsbtn').css("background-color", "#e73100");
                                        candidate_block.find('.rsbtn').css("color", "#fff");
                                        candidate_block.find('.application_status').css("background-color", "#e73100"); 
                                    }
                                    toastr.success("Status updated successfully!", "Success");                                    
                                }
                                $("#overlay").fadeOut(300);
                            },
                            error: function (err) {
                                $("#overlay").fadeOut(300);
                                console.log('err', err);
                                toastr.error("Something went wrong!", "Error");
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#candidateId', function (){
                var candidate_Id = $(this).attr("data-id");
                document.getElementById("candidate-id").value = candidate_Id;
                document.getElementById("candi-id").value = candidate_Id;
            })

            $(document).on('click', '#candidate_Id', function (){
                var candidate_Ids = $(this).attr("data-id");
                document.getElementById("candidate-Ids").value = candidate_Ids;
                document.getElementById("candidate-Idss").value = candidate_Ids;
                
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-candidate-name',
                    method: 'post',
                    data: {
                        candidate_id : candidate_Ids,
                    },
                    success: function (res) {
                        console.log(res.data);                            
                        jQuery(".candidate-name").html(res.data.cafirstnames +' '+res.data.calastname);

                        $(document).find('.append-candidate-data').html('');
                        res.data.attachments.map(function (section) {
                        console.log(section); 
                            let item = ($(document).find('#cv-block-candidate-sec').clone()).show().removeAttr('id').attr('data-id', section.caid);
                            item.find('.cv-type').text(section.attitle);
                            item.find('.cv-id').text(section.atid);
                            item.find('.cv-score').text(section.atscore + '%');   
                            if(section.atscoreset == 0){
                                var statuscolor = 'green';
                            }else if(section.atscoreset == 5){
                                var statuscolor = 'amber';
                            }else if(section.atscoreset == 9){
                                var statuscolor = 'red';
                            }else if(section.atscoreset == 99){
                                var statuscolor = 'not-ranked';
                            } 
                            
                            if(section.attype == 20){
                                if(section.at_link_url == null || section.at_link_url == ''){ 
                                    item.find('.candidate-attachment-link').text('Not completed');
                                    item.find('.candidate-attachment-link').addClass('amber');               
                                    item.find('.candidate-attachment-link').attr("href", section.at_link_url);
                                }else{                                    
                                    item.find('.candidate-attachment-link').addClass('green');               
                                    item.find('.candidate-attachment-link').attr("href", section.at_link_url);
                                }
                            }else if(section.attype == 10){
                                if(section.at_link_url == null || section.at_link_url == ''){ 
                                    item.find('.candidate-attachment-link').text('Not completed');
                                    item.find('.candidate-attachment-link').addClass('amber');               
                                    item.find('.candidate-attachment-link').attr("href", section.at_link_url);                                    
                                }else{ 
                                    item.find('.candidate-attachment-link').addClass(statuscolor);               
                                    item.find('.candidate-attachment-link').attr("href", section.at_link_url);                                       
                                }
                            }else{
                                item.find('.candidate-attachment-link').addClass(statuscolor);               
                                item.find('.candidate-attachment-link').attr("href", section.at_link_url);    
                            }           
                                            
                            $(document).find('.append-candidate-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
            })

            $(".candidate-assessment-additional-remove-cart").addClass('d-none'); 
            $(".candidate-assessment-additional-reset-category-name").addClass('d-none');
            $(document).on('click', '#candidate_assessmentadditional', function (){
                var candidate_Ids = document.getElementById("candidate-Idss").value;
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-get-candidate-buy-assessments',
                    method: 'post',
                    data: {
                        candidate_id : candidate_Ids,
                    },
                    success: function (res) {
                        // console.log(res.purchasedBasketData.basket_lines);                            
                        $(document).find('.append-candidateassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) {  
                                    if(section.prid == section1.blproductid && candidate_Ids == section1.blcandidateid){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);
                                    }   
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && candidate_Ids == section4.blcandidateid){
                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.candidate-buy-assessment-total-price').text('£0');
                            }
                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                        });

                        $(".candidate-assessment-additional-reset-category-name").addClass('d-none');                         
                        $('.candidate-assessment-additional-selected-category-name').text('Select a Category');  
                        // Category
                        $(document).find('.append-candidate-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            // console.log(section2)
                            let item = ($(document).find('#caegories-list-candidate-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.candidate-category-name').text(section2);
                            $(document).find('.append-candidate-assessment-additional-category-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
            })
            
            $(document).on('click', '#candidate_assessment_additional_reset_category_name', function (){
                var candidate_Ids = document.getElementById("candidate-Idss").value;
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-get-candidate-buy-assessments',
                    method: 'post',
                    data: {
                        candidate_id : candidate_Ids,
                    },
                    success: function (res) {
                        // console.log(res.purchasedBasketData.basket_lines);                            
                        $(document).find('.append-candidateassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) {  
                                    if(section.prid == section1.blproductid && candidate_Ids == section1.blcandidateid){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);
                                    }   
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && candidate_Ids == section4.blcandidateid){
                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.candidate-buy-assessment-total-price').text('£0');
                            }
                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                        });

                        $(".candidate-assessment-additional-reset-category-name").addClass('d-none'); 
                        $('.candidate-assessment-additional-selected-category-name').text('Select a Category'); 
                        // Category
                        $(document).find('.append-candidate-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            // console.log(section2)
                            let item = ($(document).find('#caegories-list-candidate-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.candidate-category-name').text(section2);
                            $(document).find('.append-candidate-assessment-additional-category-data').append(item);
                        });
                        
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");                        
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '.caegories-list', function (){
                var categoryName = $(this).attr("data-id");
                var candidate_Ids = document.getElementById("candidate-Idss").value;
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/get-candidate-category-name-wise-data',
                    method: 'post',
                    data: {
                        categoryName : categoryName,
                    },
                    success: function (res) {
                        // console.log(res);                            
                        $(document).find('.append-candidateassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 
                            
                            $('.candidate-assessment-additional-selected-category-name').text(section.prcategory);                            
                            $('.candidate-assessment-additional-reset-category-name').removeClass('d-none');

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) {  
                                    if(section.prid == section1.blproductid && candidate_Ids == section1.blcandidateid){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.candidate-assessment-additional-cart').addClass('added');                                            
                                        item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);           
                                    }   
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && candidate_Ids == section4.blcandidateid){
                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.candidate-buy-assessment-total-price').text('£0');
                            }
                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                        });

                        // Category
                        $(document).find('.append-candidate-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            // console.log(section2)
                            let item = ($(document).find('#caegories-list-candidate-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.candidate-category-name').text(section2);
                            $(document).find('.append-candidate-assessment-additional-category-data').append(item);
                        });                   
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);                   
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $('#candidate-assessment-additional-search').on('keyup',function(){
                $value = $(this).val();
                var candidate_Ids = document.getElementById("candidate-Idss").value;
                $("#overlay").fadeIn(300);
                $.ajax({
                    type : 'post',
                    url : app_url + '/ajax-candidate-assessment-additional-search',
                    data:{'search':$value},
                    success: function (res) {
                        console.log(res);     
                        $(document).find('.append-candidateassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) {  
                                    if(section.prid == section1.blproductid && candidate_Ids == section1.blcandidateid){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.candidate-assessment-additional-cart').addClass('added');  
                                        item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);              
                                    }  
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && candidate_Ids == section4.blcandidateid){
                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }
                            
                            if(res.basketData != null){
                                $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.candidate-buy-assessment-total-price').text('£0');
                            }
                            
                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                        });               
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");               
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '#candidate-assessment-additional-cart', function() {
                var product_id = $(this).data('id');
                var candidate_id = document.getElementById("candidate-Idss").value; 
                $("#overlay").fadeIn(300);
                $.ajax({
                    type: "POST",
                    url: app_url + '/candidate-assessment-additional-addtocart',
                    data: { 
                        product_id: product_id,  
                        candidate_id: candidate_id,                      
                        campaign_id : "{{$id}}",
                        client_id : "{{$client_id}}",
                    },
                    success: function (res) {
                    console.log(res);

                        $(document).find('.append-candidateassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            // console.log(section); 
                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            res.basketData.basket_lines.map(function (section1) {  
                                if(section.prid == section1.blproductid && candidate_id == section1.blcandidateid){
                                    item.find('.add-cart').addClass('added');    
                                    item.find('.basketline_id').attr('value', section1.blif);   
                                    // item.find('.candidate-assessment-additional-cart').addClass('added');        
                                    
                                    item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                    item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                    item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                    
                                    item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);        
                                }
                            });

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && candidate_id == section4.blcandidateid){
                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                        });

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
            })

            $(document).on('click', '#candidate-assessment-additional-remove-cart', function() {
                var basketLine_id = $(this).data('id');   
                var candidate_Ids = document.getElementById("candidate-Idss").value;
                $.ajax({
                    url: app_url + '/ajax-get-product-name',
                    method: 'get',
                    data: {
                        basketLine_id : basketLine_id,
                    },
                    success: function (data) {
                        var productName = data.productName;
                        swal.fire({
                            title: 'Are you sure?',
                            text: "Are you sure you want to remove this product is " + productName + " ?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then(function(result) { 
                            if (result.value) {
                                $("#overlay").fadeIn(300);
                                $.ajax({
                                    type: "POST",
                                    url: app_url + '/candidate-assessment-additional-remove-cart',
                                    data: { 
                                        basketLine_id: basketLine_id,  
                                        candidate_id : candidate_Ids,
                                    },
                                    success: function (res) {
                                        // console.log(res.purchasedBasketData.basket_lines);                            
                                        $(document).find('.append-candidateassessmentadditional-data').html('');
                                        res.productData.map(function (section) {
                                            let item = ($(document).find('#cv-block-candidateassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                                            item.find('.cv-head-title').text(section.prdesc);
                                            item.find('.cv-info-block-id').text(section.prcode);
                                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                                            item.find('.product_id').attr('value', section.prid); 

                                            if(res.basketData != null){                                
                                                res.basketData.basket_lines.map(function (section1) {  
                                                    if(section.prid == section1.blproductid && candidate_Ids == section1.blcandidateid){
                                                        item.find('.add-cart').addClass('added');    
                                                        item.find('.basketline_id').attr('value', section1.blif);   
                                                        item.find(".candidate-assessment-additional-cart").addClass('d-none'); 
                                                        item.find('.candidate-assessment-additional-remove-cart').removeClass('d-none');  
                                                        item.find('.candidate-assessment-additional-remove-cart').addClass('added');   
                                                        
                                                        item.find('#candidate-assessment-additional-remove-cart').attr('data-id', section1.blif);
                                                    }   
                                                });
                                            }

                                            if(res.purchasedBasketData != null){                                
                                                res.purchasedBasketData.map(function (section3) {  
                                                    section3.basket_lines.map(function (section4) {
                                                        if(section.prid == section4.blproductid && candidate_Ids == section4.blcandidateid){
                                                            item.find('.candidate-assessment-additional-purchases').text('Purchased'); 
                                                            item.find('.candidate-assessment-additional-cart').addClass('d-none');   
                                                            item.find('.candidate-assessment-additional-purchases').css("color", "green");                  
                                                        }   
                                                    });                                    
                                                });
                                            }

                                            if(res.basketData != null){
                                                $(document).find('.candidate-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                                            }else{                                
                                                $(document).find('.candidate-buy-assessment-total-price').text('£0');
                                            }
                                            item.find('#candidate-assessment-additional-cart').attr('data-id', section.prid);         
                                            $(document).find('.append-candidateassessmentadditional-data').append(item);
                                        });

                                        // Category
                                        $(document).find('.append-candidate-assessment-additional-category-data').html('');
                                        res.categoryData.map(function (section2) {
                                            // console.log(section2)
                                            let item = ($(document).find('#caegories-list-candidate-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                                            item.find('.candidate-category-name').text(section2);
                                            $(document).find('.append-candidate-assessment-additional-category-data').append(item);
                                        });

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
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
            })

            // Campaign Assessments Additional            
            $(".campaign-assessment-additional-remove-cart").addClass('d-none'); 
            $(document).on('click', '#campaign_assessmentadditional', function (){                                   
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-get-campaign-buy-assessments',
                    method: 'post',
                    data: {},
                    success: function (res) {
                        // console.log(res.basketData);                            
                        $(document).find('.append-campaignassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) { 
                                    // console.log(section1); 
                                    if(section.prid == section1.blproductid && campaign_id == section1.blcampaignid && section1.blcandidateid ==0){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.campaign-assessment-additional-cart').addClass('added');       
                                                                               
                                        item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);       
                                    }   
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.campaign-buy-assessment-total-price').text('£0');
                            }
                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                        });

                        
                        $(".campaign-assessment-additional-reset-category-name").addClass('d-none');                         
                        $('.campaign-assessment-additional-selected-category-name').text('Select a Category');  
                        // Category
                        $(document).find('.append-campaign-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            // console.log(section2)
                            let item = ($(document).find('#caegories-list-campaign-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.campaign-category-name').text(section2);
                            $(document).find('.append-campaign-assessment-additional-category-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '#campaign_assessment_additional_reset_category_name', function (){                                   
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/ajax-get-campaign-buy-assessments',
                    method: 'post',
                    data: {},
                    success: function (res) {
                        // console.log(res.basketData);                            
                        $(document).find('.append-campaignassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) { 
                                    // console.log(section1); 
                                    if(section.prid == section1.blproductid && campaign_id == section1.blcampaignid && section1.blcandidateid ==0){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.campaign-assessment-additional-cart').addClass('added');     
                                        
                                        item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);            
                                    }   
                                });
                            }

                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.campaign-buy-assessment-total-price').text('£0');
                            }
                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                        });

                        
                        $(".campaign-assessment-additional-reset-category-name").addClass('d-none');                         
                        $('.campaign-assessment-additional-selected-category-name').text('Select a Category');  
                        // Category
                        $(document).find('.append-campaign-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            // console.log(section2)
                            let item = ($(document).find('#caegories-list-campaign-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.campaign-category-name').text(section2);
                            $(document).find('.append-campaign-assessment-additional-category-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '.campaign-caegories-list', function (){
                var categoryName = $(this).attr("data-id");                                                
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/get-campaign-category-name-wise-data',
                    method: 'post',
                    data: {
                        categoryName : categoryName,
                    },
                    success: function (res) {
                        console.log(res.basketData);                            
                        $(document).find('.append-campaignassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            
                            $('.campaign-assessment-additional-selected-category-name').text(section.prcategory);                            
                            $('.campaign-assessment-additional-reset-category-name').removeClass('d-none');

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) { 
                                    console.log(section1); 
                                    if(section.prid == section1.blproductid && campaign_id == section1.blcampaignid && section1.blcandidateid ==0){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.campaign-assessment-additional-cart').addClass('added');    
                                        
                                        item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);             
                                    }   
                                });
                            }
                            
                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            if(res.basketData != null){
                                $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.campaign-buy-assessment-total-price').text('£0');
                            }
                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                        });

                        // Category
                        $(document).find('.append-campaign-assessment-additional-category-data').html('');
                        res.categoryData.map(function (section2) {
                            let item = ($(document).find('#caegories-list-campaign-assessment-additional-category-sec').clone()).show().removeAttr('id').attr('data-id', section2);
                            item.find('.campaign-category-name').text(section2);
                            $(document).find('.append-campaign-assessment-additional-category-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $('#campaign-assessment-additional-search').on('keyup',function(){
                $value = $(this).val();                                
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                $("#overlay").fadeIn(300);
                $.ajax({
                    type : 'post',
                    url : app_url + '/ajax-campaign-assessment-additional-search',
                    data:{'search':$value},
                    success: function (res) {
                        console.log(res);     
                        $(document).find('.append-campaignassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            if(res.basketData != null){                                
                                res.basketData.basket_lines.map(function (section1) {  
                                    if(section.prid == section1.blproductid){
                                        item.find('.add-cart').addClass('added');    
                                        item.find('.basketline_id').attr('value', section1.blif);   
                                        // item.find('.campaign-assessment-additional-cart').addClass('added');  
                                        
                                        item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                        item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                        item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                        
                                        item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);               
                                    }  
                                });
                            }
                            
                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }
                            
                            if(res.basketData != null){
                                $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            }else{                                
                                $(document).find('.campaign-buy-assessment-total-price').text('£0');
                            }
                            
                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                        $("#overlay").fadeOut(300);
                    }
                });
            })
            $(document).on('click', '#campaign-assessment-additional-cart', function() {
                var product_id = $(this).data('id');                                
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                $("#overlay").fadeIn(300);
                $.ajax({
                    type: "POST",
                    url: app_url + '/campaign-assessment-additional-addtocart',
                    data: { 
                        product_id: product_id,                     
                        campaign_id : "{{$id}}",
                        client_id : "{{$client_id}}",
                    },
                    success: function (res) {
                    console.log(res);

                        $(document).find('.append-campaignassessmentadditional-data').html('');
                        res.productData.map(function (section) {
                            // console.log(section); 
                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                            item.find('.cv-head-title').text(section.prdesc);
                            item.find('.cv-info-block-id').text(section.prcode);
                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                            item.find('.product_id').attr('value', section.prid); 

                            res.basketData.basket_lines.map(function (section1) {  
                                if(section.prid == section1.blproductid){
                                    item.find('.add-cart').addClass('added');    
                                    item.find('.basketline_id').attr('value', section1.blif);   
                                    // item.find('.campaign-assessment-additional-cart').addClass('added');     
                                    
                                    item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                    item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                    item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                    
                                    item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);            
                                }
                            });
                            
                            if(res.purchasedBasketData != null){                                
                                res.purchasedBasketData.map(function (section3) {  
                                    section3.basket_lines.map(function (section4) {
                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                        }   
                                    });                                    
                                });
                            }

                            $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                        });

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
            })

            $(document).on('click', '#campaign-assessment-additional-remove-cart', function() {
                var product_id = $(this).data('id');                                
                var campaign_id = "{{$campaign->caid}}";
                var client_id = "{{$client_id}}";
                var basketLine_id = $(this).data('id');  
                $.ajax({
                    url: app_url + '/ajax-get-product-name',
                    method: 'get',
                    data: {
                        basketLine_id : basketLine_id,
                    },
                    success: function (data) {
                        var productName = data.productName;
                        swal.fire({
                            title: 'Are you sure?',
                            text: "Are you sure you want to remove this product is " + productName + " ?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then(function(result) { 
                            if (result.value) { 
                                $("#overlay").fadeIn(300);
                                $.ajax({
                                    type: "POST",
                                    url: app_url + '/campaign-assessment-additional-remove-cart',
                                    data: { 
                                        basketLine_id: basketLine_id,  
                                        product_id: product_id,                     
                                        campaign_id : "{{$id}}",
                                        client_id : "{{$client_id}}",
                                    },
                                    success: function (res) {
                                    console.log(res);

                                        $(document).find('.append-campaignassessmentadditional-data').html('');
                                        res.productData.map(function (section) {
                                            // console.log(section); 
                                            let item = ($(document).find('#cv-block-campaignassessmentadditional-sec').clone()).show().removeAttr('id').attr('data-id', section.prid);
                                            item.find('.cv-head-title').text(section.prdesc);
                                            item.find('.cv-info-block-id').text(section.prcode);
                                            item.find('.cv-info-block-cost').text('£'+section.prprice);   
                                            item.find('.product_id').attr('value', section.prid); 

                                            res.basketData.basket_lines.map(function (section1) {  
                                                if(section.prid == section1.blproductid){
                                                    item.find('.add-cart').addClass('added');    
                                                    item.find('.basketline_id').attr('value', section1.blif);   
                                                    // item.find('.campaign-assessment-additional-cart').addClass('added');     
                                                    
                                                    item.find(".campaign-assessment-additional-cart").addClass('d-none'); 
                                                    item.find('.campaign-assessment-additional-remove-cart').removeClass('d-none');  
                                                    item.find('.campaign-assessment-additional-remove-cart').addClass('added');   
                                                    
                                                    item.find('#campaign-assessment-additional-remove-cart').attr('data-id', section1.blif);            
                                                }
                                            });
                                            
                                            if(res.purchasedBasketData != null){                                
                                                res.purchasedBasketData.map(function (section3) {  
                                                    section3.basket_lines.map(function (section4) {
                                                        if(section.prid == section4.blproductid && campaign_id == section4.blcampaignid && section4.blcandidateid ==0){
                                                            item.find('.campaign-assessment-additional-purchases').text('Purchased'); 
                                                            item.find('.campaign-assessment-additional-cart').addClass('d-none');   
                                                            item.find('.campaign-assessment-additional-purchases').css("color", "green");                  
                                                        }   
                                                    });                                    
                                                });
                                            }

                                            $(document).find('.campaign-buy-assessment-total-price').text('£'+res.basketData.total_amount);
                                            item.find('#campaign-assessment-additional-cart').attr('data-id', section.prid);         
                                            $(document).find('.append-campaignassessmentadditional-data').append(item);
                                        });

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
                    },
                    error: function (err) {
                        $("#overlay").fadeOut(300);
                        console.log('err', err);
                        toastr.error("Something went wrong!", "Error");
                    }
                });
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

            // candidate Comments
            $(document).on('click', '#candidateId', function (){
                var candidate_Ids = $(this).attr("data-id");
                document.getElementById("cocan-Id").value = candidate_Ids;

                var camping_id = $(this).closest('#pills-tabContent').attr('data-id');
                var client_id = "{{$client_id}}";
                $("#overlay").fadeIn(300);

                $.ajax({
                    url: app_url + '/getcomments/' + candidate_Ids,
                    method: 'post',
                    data: {
                        client_id : client_id,
                        camping_id : camping_id,
                    },
                    success: function (res) {
                        // console.log(res.data);

                        $(document).find('.append-candidate-comments-data').html('');
                        res.data.map(function (section) {
                            // console.log(section.user.usemail)
                            let item = ($(document).find('#comments-list').clone()).show().removeAttr('id').attr('data-id', section.usid);
                            item.find('.comments').text(section.cocomment);
                            if(section.user){
                                item.find('.comment-username').text(section.user.usemail);
                            }else{
                                item.find('.comment-username').text('');                                
                            }
                            item.find('.comment-datetime').text(section.codate);
                            $(document).find('.append-candidate-comments-data').append(item);

                            if(section.couser == {{$usrId}}){
                                item.find('.comment-edit-span').css("display", "block");                                      
                                item.find('#comment-edit').attr('data-id', section.coid);
                            }
                        });
                        $("#overlay").fadeOut(300);
                    },
                    error: function (err) {
                        console.log('err', err);
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '.add-more-candidate-comment', function (){
                let length = $('.append-candidate-comment .card').length + 1;
                let item = ($(document).find('#candidate-comment-block').clone()).show().removeAttr('id');
                item.find('.card-header button').attr('data-target', '#collapse_new'+ length);
                item.find('.collapse-block').attr('id', 'collapse_new'+ length);
                $('.append-candidate-comment').append(item);
                item.find('.card-header button').trigger('click');

                $('.add-more').addClass('d-none');
            });

            $(document).on('click', '.candidate-comment-save-btn', function (e){
                var $this = $(this);
                let form = $this.closest(".candidate-comment-form");
                $("#overlay").fadeIn(300);
                form.validate({
                    ignore:'',
                    rules: {
                        candidate_comment: "required",
                    }, errorPlacement: function (error, element) {
                        console.log(element, error);
                        $("#overlay").fadeOut(300);
                    }
                });

                if (form.valid()) {
                    $('.add-more').addClass('d-none');
                    var formData = new FormData(form[0]);
                    $("#overlay").fadeIn(300);
                    $.ajax({
                        url: form.attr('data-action'),
                        method: 'post',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            console.log(res.data);

                            if (res.status == 'error'){
                                toastr.error(res.message, "Error");
                                return false;
                                $("#overlay").fadeOut(300);
                            }
                            $(document).find('.append-candidate-comments-data').html('');
                            res.data.map(function (section) {
                                let item = ($(document).find('#comments-list').clone()).show().removeAttr('id').attr('data-id', section.usid);
                                item.find('.comments').text(section.cocomment);
                                item.find('.comment-username').text(section.user.usemail);
                                item.find('.comment-datetime').text(section.codate);
                                
                                if(section.couser == {{$usrId}}){
                                    item.find('.comment-edit-span').css("display", "block");                                      
                                    item.find('#comment-edit').attr('data-id', section.coid);
                                }
                                $(document).find('.append-candidate-comments-data').append(item);
                            });
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update'){
                                toastr.success("Comment updated successfully", "Success");
                            } else {
                                // $('.add-more').removeClass('d-none');
                                document.getElementById("candidatecomment").value = "";
                                toastr.success("Comment added successfully", "Success");
                            }
                            $("#overlay").fadeOut(300);
                        },
                        error: function (err) {
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                            $("#overlay").fadeOut(300);
                        }
                    });
                    
                }
            });

            
            $(document).on('click', '#comment-edit', function (){
                var comment_Id = $(this).attr("data-id");
                document.getElementById("comments_id").value = comment_Id;
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: app_url + '/getcomment/' + comment_Id,
                    method: 'get',
                    data: {
                        comment_Id : comment_Id,
                    },
                    success: function (res) {
                        console.log(res.data);
                        $('#editcandidatecomment').text(res.data.cocomment);
                        document.getElementById("couser").value = res.data.couser;
                        $("#overlay").fadeOut(300);                        
                    },
                    error: function (err) {
                        console.log('err', err);
                        $("#overlay").fadeOut(300);
                    }
                });
            })

            $(document).on('click', '.edit_candidate-comment-save-btn', function (e){
                var $this = $(this);
                let form = $this.closest(".edit-candidate-comment-form");
                
                $("#overlay").fadeIn(300);
                form.validate({
                    ignore:'',
                    rules: {
                        candidate_comment: "required",
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
                        processData: false,
                        success: function (res) {
                            console.log(res.data);

                            if (res.status == 'error'){
                                toastr.error(res.message, "Error");
                                return false;
                                $("#overlay").fadeOut(300);
                            }
                            $(document).find('.append-candidate-comments-data').html('');
                            res.data.map(function (section) {
                                let item = ($(document).find('#comments-list').clone()).show().removeAttr('id').attr('data-id', section.usid);
                                item.find('.comments').text(section.cocomment);
                                item.find('.comment-username').text(section.user.usemail);
                                item.find('.comment-datetime').text(section.codate);

                                if(section.couser == {{$usrId}}){
                                    item.find('.comment-edit-span').css("display", "block");                                      
                                    item.find('#comment-edit').attr('data-id', section.coid);
                                }
                                $(document).find('.append-candidate-comments-data').append(item);
                            });
                            toastr.options = {
                                "progressBar": true,
                            };
                            if (res.type == 'update'){
                                $('#edit-candidate-comment-block').modal('hide');
                                toastr.success("Comment updated successfully", "Success");
                            } else {
                                toastr.success("Comment added successfully", "Success");
                            }
                            $("#overlay").fadeOut(300);
                        },
                        error: function (err) {
                            console.log('err', err);
                            toastr.error("Something went wrong!", "Error");
                            $("#overlay").fadeOut(300);
                        }
                    });
                    
                }
            });


            $(document).on('click', '.candidate-comment-delete-btn', function (e){
                $('.add-more').removeClass('d-none');
                let user_id = $(this).closest('.candidate-comment-form').find('.user-id').val();
                if (!user_id){
                    $(this).closest('.card').remove();
                    return false;
                }
                $('#deleteConfirmModal').modal();
                $('#deleteConfirmModal').find('.delete-confirm').attr('data-id', user_id);
            });
        })


        // jQuery('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
        //     localStorage.setItem('activeTab', jQuery(e.target).attr('href'));
        // });

        // var activeTab = localStorage.getItem('activeTab');
        // console.log(activeTab);

        // if (activeTab) {
        //     jQuery('a[href="' + activeTab + '"]').tab('show');
        // }

        $('#candidate_comment').on('hidden.bs.modal', function () {
            location.reload();
        });
        $('#grantAccess').on('hidden.bs.modal', function () {
            location.reload();
        });
        

    </script>

@endsection

