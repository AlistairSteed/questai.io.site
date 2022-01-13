@extends('layouts.master')
@section('styles')
    <style>
        textarea.client-desc{
            line-height: 30px !important;
        }
        .form-group .error {
            border: 1px solid red !important;
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
                    <!-- <li class="nav-item active">
                      <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client-selection') }}">Client Selection</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="circle50">
                            <img src="{{ asset('assets/images/shopping-basket.png') }}" alt="cart">
                        </a>
                    </li> -->

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
    
<section class="sidebar-content">
    <div class="container-fluid">
        <div style="text-align: center">
            <h2 class="text-primary">My Basket History</h2>
        </div>
        <div class="kt-portlet__body pl-5 pr-5">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Basket Start Date</th>
                        <th>Basket Complete Date</th>
                        <th>Total Price</th>           
                        <th>Grand Total Price</th>                        
                        <th>View</th>
                    </tr>
                </thead>
                <tbody id="tablecontents">                    
                    @if(count($basketData)>0)
                    <?php $i = 0?>
                    @foreach($basketData as $key => $row)
                        <tr class="row1">
                            <td>{{$key+1}}</td>
                            <td>{{$row->badatestart}}</td>
                            <td>{{$row->badatecomplete}}</td>
                            <td>{{'£'.number_format($row->total_amount, 2, '.', '')}}</td>
                            <td>{{'£'.number_format($row->grand_total_amount, 2, '.', '')}}</td>
                            <td>
                            <a href="{{$row->invoice_url}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" style="color:#007bff" title="View Order History" target="_blank">Receipt</a>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr class="text-center">
                        <td colspan="7">No record found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</section>

@endsection

@section('scripts')
@endsection
