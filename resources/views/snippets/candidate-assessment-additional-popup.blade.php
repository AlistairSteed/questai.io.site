<!-- Assessments and additional verifaction popup for candidate-->
<div class="assessment-additional-popup">
    <!-- Modal -->
    <div class="modal fade" id="candidateassessmentadditional" tabindex="-1" role="dialog" aria-labelledby="candidateassessmentadditional" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popup-box text-center pt-lg-5 mt-lg-3">
                        <h3>CV, Video interview and Verification Information</h3>
                        <span class="client-name">Buy Skills Assessments and Additional Verification<br>
                        <input type="hidden" name="candidate-Ids" class="candidate-id" id="candidate-Idss" value="">
                        <span class="client-name candidate-name"></span>
                    </div>
                    <div class="select-category-box">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="category"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a class="candidate-assessment-additional-selected-category-name"></a>
                            </button>
                            <div class="dropdown-menu append-candidate-assessment-additional-category-data" aria-labelledby="category">

                            </div>
                            <div class="caegories-list" id="caegories-list-candidate-assessment-additional-category-sec" style="display: none">
                                <ul>
                                    <li><a class="dropdown-item candidate-category-name"></a></li>
                                </ul> 
                            </div>
                            <a class="candidate-assessment-additional-reset-category-name" id="candidate_assessment_additional_reset_category_name">Clear</a>
                        </div>
                        <form class="form-inline search-header">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="candidate-assessment-additional-search">
                            <a class="search-btn"><img src="{{ asset('assets/images/search.png') }}" alt="search"></a>
                        </form>
                    </div>
                    <div class="popup-box">
                        <div class="assessments">
                            <div class="cv-main append-candidateassessmentadditional-data justify-content-unset">

                            </div>
                            <div class="cv-block-outer" id="cv-block-candidateassessmentadditional-sec" style="display: none">
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
                                        <a href="#" class="circle50 candidate-assessment-additional-cart" id="candidate-assessment-additional-cart">
                                            <img src="{{ asset('assets/images/shopping-basket.png') }}" class="hover-hide" alt="cart">
                                            <!-- <img src="{{ asset('assets/images/shopping-basket-light.png') }}" class="hover-show" alt="cart"> -->
                                        </a>
                                        
                                        <a href="#" class="circle50 candidate-assessment-additional-remove-cart" id="candidate-assessment-additional-remove-cart">
                                            <!-- <img src="{{ asset('assets/images/shopping-basket.png') }}" class="hover-hide" alt="cart"> -->
                                            <img src="{{ asset('assets/images/shopping-basket-light.png') }}" class="hover-show" alt="cart">
                                        </a>
                                        <p class="candidate-assessment-additional-purchases"></p>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="popup-box">
                        <div class="buy-assessment-btn">
                            <div class="total-price">
                                <span>Total</span>
                                <span class="candidate-buy-assessment-total-price"></span>
                            </div>
                            <a href="#" class="white-btn"  data-toggle="modal" id="cart-popup-data" data-target="#cartpopup">Buy Assessments</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>