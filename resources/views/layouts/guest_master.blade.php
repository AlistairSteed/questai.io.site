<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Monarch Personnel</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ebf9ff">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vender/fontawesome/css/all.css') }}">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vender/bootstrap/css/bootstrap.min.css') }}">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css')}}"/>
    <link href="{{ asset('assets/css/bootstrap-datepicker.min.css')}}" />

    <style>
        .form-group .error {
            border: 1px solid red;
        }
    </style>
</head>
<body class="login">

<!-- Main Content -->
<main>
    @yield('content')

    <section class="comment-box">
        <div class="container-fluid">
            <!-- <a href="#" title="comment" class="comment-site">
                <img src="{{ asset('assets/images/comment.png') }}" alt="Comment">
            </a> -->
            <!-- Start of questaisupport Zendesk Widget script -->
            <script id="ze-snippet" src=https://static.zdassets.com/ekr/snippet.js?key=7de8bbe7-356a-4c22-beb7-af46582bfe1e> </script>
            <!-- End of questaisupport Zendesk Widget script -->
        </div>
    </section>
</main>


<!-- End Content -->
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<!-- Footer -->
<footer>

</footer>
<!-- End Footer -->

<!-- JS Global Compulsory -->
<script src="{{ asset('assets/vender/jquery/jquery-3.4.1.slim.min.js') }}"></script>
<script src="{{ asset('assets/vender/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
<!-- JS Front -->

<script>

    $.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    @if(session()->has('success'))
        toastr.options = {
        "progressBar": true,
    };
    toastr.success("{{ session()->get('success') }}", "Success");
    @php session()->forget('success'); @endphp
        @endif

        @if(session()->has('failure'))
        toastr.options = {
        "progressBar": true,
    };
    toastr.error("{{ session()->get('failure') }}", "Error");
    @php session()->forget('failure'); @endphp
        @endif

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr.options = {
        "progressBar": true,
    };
    toastr.error("{{ $error }}", "Error");
    @endforeach @endif

        @if(session()->has('status'))
        toastr.options = {
        "progressBar": true,
    };
    toastr.success("{{ session()->get('status') }}", "Success");
    @endif

    $(document).ready(function (){
        $(document).ajaxError(function (event, request, settings) {
            if (request.status === 419) {
                window.location="{{url('login-main')}}";
            }
        });
    });

</script>

@yield('scripts')
</body>
</html>
