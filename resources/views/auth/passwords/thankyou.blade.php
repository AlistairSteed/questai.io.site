@extends('layouts.guest_master')

@section('content')
    <!-- Hero Section -->
    <section class="login-page login-page2">
        <div class="container">
            <div class="login-main">

                <div class="white-bg border-radius login-box login-box2">
                    <h1>
                        [Monarch Personnel] <br><span>powered by</span> QuestAI <strong>&#174;</strong>
                    </h1>

                    <div class="form-group">
                        <h2 style="color:green"> Thank you </h2>
                        <h2 style="color:green">Your password changed successfully!</h2> 
                    </div>
                    
                    <!-- <div class="form-group forget-remember"> -->
                        <button type="submit" class="primary-btn email_btn">
                            <a href="{{ url('login-main') }}" class="fotgot-pass"><span>Back to Login</span></a>
                        </button>
                    <!-- </div> -->
                </div>

            </div>
        </div>
    </section>
    <!-- End Hero Section -->
@endsection

