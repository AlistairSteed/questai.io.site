@extends('layouts.guest_master')

@section('content')
    <!-- Hero Section -->
    <section class="login-page">
        <div class="container">
            <div class="row login-main">
                <div class="col-md-6">
                    <div class="white-bg border-radius login-box">
                        <h1>
                            <?php 
                                $enterpriseId = App\Models\Enterprise::first();
                                $enterprise_Id = $enterpriseId->enid;
                                if(request('ent')){                                
                                    $enterprise = App\Models\Enterprise::find(request('ent'));
                                    
                                    $infotext = App\Models\Infotext::where('enterprise_id',$enterprise->enid)->where('group',0)->orderBy('order','asc')->get();

                                    if($enterprise){
                                        $enterpriseName = $enterprise->enname;
                                    }
                                    else{
                                        $enterpriseName = 'Monarch Personnel';
                                    }
                                }else{
                                    $enterpriseName = 'Monarch Personnel';
                                }
                            ?>
                            <!-- [Monarch Personnel]<br> <span>powered by</span> QuestAI <strong>&#174;</strong> -->
                            {{$enterpriseName}}<br> <span>powered by</span> <img src="{{ URL::asset('assets/images/QuestAI_Dark_Green_RGB.png') }}" alt="Logo" style="width: 185px !important;">
                        </h1>
                        <!-- <a href="{{ url('login-main') }}" class="primary-btn login-main"><span>Login</span></a> -->
                        <a  class="primary-btn login-main-btn"><span>Login</span></a>
                        <p class="enterprise-id-pass mt-3"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=" login-info">
                        <h2 class="text-white">Benefits</h2>
                        <ul>
                            @foreach($infotext as $row)
                                @if($row->field_name == 'benefits')
                                    <li>
                                        {{$row->field_text}}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End Hero Section -->
@endsection


@section('scripts')


    <script>

        $(document).ready(function () {
            const params = new URLSearchParams(window.location.search);
            if(params != null && params != '' && 'ent=') {
                $('.login-main-btn').attr('href', 'login-main?'+params);
            }else{
                $(".login-main-btn").addClass('disabled'); 
                                    
                $('.enterprise-id-pass').text('Please Pass Enterprise ID in url like ("http://205.134.254.135/~team8/monarch-personnel-backend/public/login?ent='+enterprise_Id+'").');
                $('.enterprise-id-pass').css('color', 'red');
            }
        });
    </script>
@endsection
