@extends('layouts.guest_master')

@section('content')
        <!-- Hero Section -->
        <section class="login-page login-page2">
            <div class="container">
                <div class="login-main">

                    <div class="white-bg border-radius login-box login-box2">
                        <h1>
                            <!-- [Monarch Personnel] <br><span>powered by</span> QuestAI <strong>&#174;</strong> -->
                            {{$enterprise->enname}}<br> <span>powered by</span> <img src="{{ URL::asset('assets/images/QuestAI_Dark_Green_RGB.png') }}" alt="Logo" style="width: 185px !important;">
                        </h1>


                        <form class="login-form" id="login-form" action="{{ route('login') }}" method="post" autocomplete="on">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="usemail" class="form-control" placeholder="Username or Email">
                            </div>
                            <div class="form-group pass">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <img src="{{ asset('assets/images/view.png') }}" alt="view" class="pass-image hide">
                            </div>
                            <div class="form-group forget-remember">
                                <label class="checkbox">
                                    Remember me
                                    <input type="checkbox" name="remember" value="1"/>
                                    <span class="mark"></span>
                                </label>
                                <a href="{{ route('password.request','?ent='.$enterprise->enid) }}" class="fotgot-pass">Forgotten Password?</a>
                            </div>
                            <button type="submit" class="primary-btn"><span> Sign In</span></button>
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

