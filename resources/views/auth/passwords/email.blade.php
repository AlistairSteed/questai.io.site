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


                    <form class="forgot_password-form" id="forgot_password-form" action="javascript:;" data-action="{{ route('password.email') }}" method="post" autocomplete="on">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="usemail" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group forget-remember">
                            <a href="{{ url('login-main?ent='.$enterprise->enid) }}" class="fotgot-pass">Back to Login</a>
                        </div>
                        <button type="submit" class="primary-btn email_btn" id="submit_btn">
                            <a href="javascript:;"><span> Submit</span></a>
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
                var $this = $(this);
                let form = $this.closest(".forgot_password-form");

                form.validate({
                    ignore:'',
                    rules: {
                        usemail: "required",
                    }, errorPlacement: function (error, element) {
                        console.log(element, error);
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
                                $("#overlay").fadeOut(300);
                                toastr.error(res.message, "Error");
                                return false;
                            }
                            toastr.options = {
                                "progressBar": true,
                            };

                            toastr.success("We have e-mailed your password reset link!", "Success");                             
                            setTimeout(() => {
                                window.location="{{url('login-main?ent='.$enterprise->enid)}}";
                                $("#overlay").fadeOut(300);
                            }, 3000);                                     
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

