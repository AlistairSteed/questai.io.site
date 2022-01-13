<!-- Assessments and additional verifaction popup for candidate-->
<div class="assessment-additional-popup">
      <!-- Modal -->
      <div class="modal fade" id="campingassessmentadditional" tabindex="-1" role="dialog" aria-labelledby="campingassessmentadditional" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popup-box text-center pt-lg-5 mt-lg-3">
                        <h3>Campaign</h3>
                        <span class="client-name">Buy Skills Assessments and Additional Verification<br>
                        <!-- $userInfo->usfirstname.' '.$userInfo->uslastname -->
                    </span>
                    </div>
                    <div class="select-category-box">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="category"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                
                                <a class="campaign-assessment-additional-selected-category-name"></a>
                            </button>
                            <div class="dropdown-menu append-campaign-assessment-additional-category-data" aria-labelledby="category">

                            </div>
                            <div class="caegories-list campaign-caegories-list" id="caegories-list-campaign-assessment-additional-category-sec" style="display: none">
                                <ul>
                                    <li><a class="dropdown-item campaign-category-name"></a></li>
                                </ul> 
                            </div>
                            <a class="campaign-assessment-additional-reset-category-name" id="campaign_assessment_additional_reset_category_name">Clear</a>
                        </div>
                        <form class="form-inline search-header">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="campaign-assessment-additional-search">
                            <a class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="search"></a>
                        </form>
                    </div>
                    <div class="popup-box">
                        <div class="assessments">
                            <div class="cv-main append-campaignassessmentadditional-data justify-content-unset">

                            </div>
                            <div class="cv-block-outer" id="cv-block-campaignassessmentadditional-sec" style="display: none">
                                <input type="hidden" name="product_id" id="product_id" class="product_id">
                                <div class="cv-block">
                                    <div class="cv-head">
                                    <h5 class="cv-head-title"></h5>
                                    </div>
                                    <div class="cv-info">
                                        <div class="cv-info-block">
                                            <span>ID</span>
                                            <span class="cv-info-block-id"></span>
                                        </div>
                                        <div class="cv-info-block">
                                            <span>Cost</span>
                                            <span class="cv-info-block-cost"></span>
                                        </div>
                                    </div>
                                    <div class="add-cart">
                                        <span>Added</span>
                                        <input type="hidden" name="basketline_id" id="basketline_id" class="basketline_id">
                                        <a href="#" class="circle50 campaign-assessment-additional-cart" id="campaign-assessment-additional-cart">
                                            <img src="{{ asset('assets/images/shopping-basket.png') }}" class="hover-hide" alt="cart">
                                            <!-- <img src="{{ asset('assets/images/shopping-basket-light.png') }}" class="hover-show" alt="cart"> -->
                                        </a>
                                        <a href="#" class="circle50 campaign-assessment-additional-remove-cart" id="campaign-assessment-additional-remove-cart">
                                            <!-- <img src="{{ asset('assets/images/shopping-basket.png') }}" class="hover-hide" alt="cart"> -->
                                            <img src="{{ asset('assets/images/shopping-basket-light.png') }}" class="hover-show" alt="cart">
                                        </a>
                                        <p class="campaign-assessment-additional-purchases"></p>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="popup-box">
                        <div class="buy-assessment-btn">
                            <div class="total-price">
                                <span>Total</span>
                                <span class="campaign-buy-assessment-total-price"></span>
                            </div>
                            <a href="#" class="white-btn"  data-toggle="modal" id="cart-popup-data" data-target="#cartpopup">Buy Service</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>