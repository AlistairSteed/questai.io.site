@extends('layouts.guest_master')

@section('content')
        <!-- Hero Section -->
        <section class="login-page login-page2">
            <div class="container">
                <div class="login-main">

                    <div class="white-bg border-radius login-box login-box2" style="width:120%;margin-left:-10%;">
                        <h1>
                            <!-- [Monarch Personnel] <br><span>powered by</span> QuestAI <strong>&#174;</strong> -->
                            {{$enterprise->enname}}<br> <span>powered by</span> <img src="{{ URL::asset('assets/images/QuestAI_Dark_Green_RGB.png') }}" alt="Logo" style="width: 185px !important;">
                        </h1>

                        <h1>Sign Up</h1>
                        <h5>Personal Details</h5>
                        <form class="login-form register-form" id="login-form" action="{{ route('register') }}" method="post" autocomplete="on" style="margin:5%;width:90%;margin-right:0px !important;">
                            @csrf
                            <input type="hidden" name="usenterpriseid" class="form-control" value="{{$enterprise->enid}}">
                            <div class="form-group" style="width:96% !important;">
                                <input type="email" name="usemail" class="form-control" placeholder="Email Address">
                            </div>
                            
                            <div class="form-group pass" style="width:50%;">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <img src="{{ asset('assets/images/view.png') }}" alt="view" class="pass-image hide">
                            </div>
                            <div class="form-group pass" style="width:50%;">
                                <input type="password" name="confirm" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password">
                                <img src="{{ asset('assets/images/view.png') }}" alt="view" class="pass-image hide">
                            </div>
                            <div class="form-group" style="width:50%">
                                <input type="text" name="usfirstname" class="form-control" placeholder="First Name">
                            </div>
                            <div class="form-group" style="width:50%">
                                <input type="text" name="uslastname" class="form-control" placeholder="Last Name">
                            </div>
                            <!-- <div class="form-group forget-remember">
                                <label class="checkbox">
                                    Remember me
                                    <input type="checkbox" name="remember" value="1"/>
                                    <span class="mark"></span>
                                </label>
                                <a href="{{ route('password.request','?ent='.$enterprise->enid) }}" class="fotgot-pass">Forgotten Password?</a>
                            </div> -->
                            <h5>Client Details</h5>
                            <div class="form-group" style="width:50%">
                                <input type="text" name="clname" class="form-control" placeholder="Company Name">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="claddress1" class="form-control" placeholder="Address">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="clcity" class="form-control" placeholder="City">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="clcounty" class="form-control" placeholder="County">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="clcountry" class="form-control" placeholder="Country">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="clpostcode" class="form-control" placeholder="Post Code">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="cltelno" class="form-control" placeholder="Telephone number">
                            </div>
                            <div class="form-group" style="width:50%;">
                                <input type="text" name="clemail" class="form-control" placeholder="Accounts email Address">
                            </div>
                            <h5>Optional at this stage</h5>
                            <div class="form-group" style="width:96% !important;">
                                <textarea name="clcompanydesc" class="form-control" placeholder="Client Description"></textarea>
                            </div>
                            <div class="form-group" style="width:96% !important;">
                                <input type="text" name="clvideo" class="form-control" placeholder="Client Video Link">
                            </div>
                            <button type="submit" class="primary-btn"><span>Submit</span></button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <!-- End Hero Section -->
@endsection


@section('scripts')


    <script>

        $(document).ready(function () {

            $.validator.setDefaults({
                debug: true,
                success: "valid"
            });

            $('#login-form').validate({
                rules: {
                    usemail: "required",
                    password: "required",
                    clemail: "required",
                    confirm: "required",
                    claddress1: "required",
                    clname: "required",
                    clcity: "required",
                    clcounty: "required",
                    clpostcode: "required",
                    cltelno: "required",
                    clemail: "required",
                    usenterpriseid: "required",
                    usfirstname: "required",
                    uslastname: "required",
                },
                messages: {},
                submitHandler: function (form) {
                    form.submit();
                    $("#overlay").fadeIn(300);　
                }, errorPlacement: function (error, element) {
                    console.log(element, error);
                    $("#overlay").fadeOut(300);
                    // element.parent().append(error);
                }
            });

            $(document).on('click', '.pass-image', function (){

                if ($(this).hasClass('hide')){
                    $(this).toggleClass('hide').closest('.pass').find('input').attr('type', 'text');
                    $(this).attr('src', '{{ asset('assets/images/user.png') }}')
                } else {
                    $(this).toggleClass('hide').closest('.pass').find('input').attr('type', 'password');
                    $(this).attr('src', '{{ asset('assets/images/view.png') }}')
                }
            });

        });

    </script>
@endsection

