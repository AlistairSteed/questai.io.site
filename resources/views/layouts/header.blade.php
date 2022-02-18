<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">a
                <!-- <li class="nav-item active">
                          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales') }}">Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">Update News</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client-selection') }}">Client Selection</a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('update-client', \Illuminate\Support\Facades\Request::segment(2)) }}">Update Client</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a href="#" class="circle50">
                        <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="Shopping basket">
                    </a>
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
                        <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- End Header -->
