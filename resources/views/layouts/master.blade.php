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

    <!-- swiper css -->
    <link rel="stylesheet" href="{{ asset('assets/vender/swiper/css/swiper-bundle-min.css') }}">

    <!-- quill css -->
    <link rel="stylesheet" href="{{ asset('assets/vender/quill/css/quill.snow.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.standalone.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        .form-group .error {
            border: 1px solid red !important;
        }
        .datepicker.datepicker-dropdown{
            margin-top: 100px;
        }
    </style>
    @yield('styles')
</head>
<body>

@yield('header')
<!-- Main Content -->
<main>
    @yield('content')

    <section class="comment-box">
        <div class="container-fluid">
            <!-- <a href="#" title="comment" class="comment-site" data-toggle="modal" data-target="#comment">
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


<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<!-- JS Global Compulsory -->
{{--<script src="{{ asset('assets/vender/jquery/jquery-3.4.1.slim.min.js') }}"></script>--}}
<!-- <script src="{{ asset('assets/vender/bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="{{ asset('assets/vender/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vender/swiper/js/swiper-bundle-min.js') }}"></script>
<script src="{{ asset('assets/vender/quill/js/quill.js') }}"></script>


<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.6.1/dist/sweetalert2.all.min.js"></script>

<script>
    var quillPlaceholderTexts = {
        jobDescription: "@infoText('cajobdesc')",
        clientDescription: "@infoText('clcompanydesc')",
        essesntialSkillsAndQualifications: "@infoText('caessentialqual')",
        preferredSkillsAndQualifications: "@infoText('cadesirablequal')",
        additionalInformation: "@infoText('caadditional')",
    };
</script>

<!-- JS Front -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

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

        @if(session()->has('error'))
        toastr.options = {
        "progressBar": true,
    };
    toastr.error("{{ session()->get('error') }}", "Error");
    @php session()->forget('error'); @endphp
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
