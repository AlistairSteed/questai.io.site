@extends('layouts.guest_master')

@section('content')
        <!-- Hero Section -->
        <section class="login-page login-page2">
            <div class="container">
                <div class="login-main">

                    <div class="white-bg border-radius login-box login-box2">
                        <h1>
                            {{$enterprise->enname}} <br><span>powered by</span> QuestAI <strong>&#174;</strong>
                        </h1>


                        <form class="reset-pwd-form" id="reset-pwd-form" action="javascript:;" data-action="{{ route('password.reset') }}" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email" name="usemail" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group pass">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group cpass">
                                <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Password Confirmation">
                            </div>
                            <div class="form-group forget-remember">
                                <a href="{{ url('/login?ent='.$enterpriseId) }}" class="fotgot-pass">Back to Login</a>
                            </div>
                            
                            <button type="submit" class="primary-btn email_btn">
                                <a href="javascript:;"><span> Reset Password</span></a>
                            </button>
                            
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

            $(document).on('click', '.email_btn', function (e){
                $("#overlay").fadeIn(300);　
                var $this = $(this);
                let form = $this.closest(".reset-pwd-form");

                form.validate({
                    ignore:'',
                    rules: {
                        usemail: "required",
                        password: "required",
                        password_confirmation: "required",
                    }, errorPlacement: function (error, element) {
                        console.log(element, error);
                        $("#overlay").fadeOut(300);
                    }
                });       

                if (form.valid()) {
                    var formData = new FormData(form[0]);
                    var Enterprise_id = '{{$enterpriseId}}';
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
                            toastr.options = {
                                "progressBar": true,
                            };

                            toastr.success("Thank you. You have successfully reset your password!", "Success");                            
                            setTimeout(() => {
                                window.location="{{url('/login?ent='.$enterpriseId)}}";
                            }, 3000);    
                            
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

    </script>
@endsection

