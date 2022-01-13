<div class="cart-popup">
    <!-- Modal -->
    <div class="modal fade" id="cartpopup" tabindex="-1" role="dialog" aria-labelledby="cartpopup" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                
                <form class="cart-form" method="post" action="{{ route('checkout.page') }}" autocomplete="off">
                @csrf           
                    <input type="hidden" name="total-cart-price" class="total-cart-price" id="total-cart-price">
                    <input type="hidden" name="coupon" class="coupon" id="coup-code">
                    <div class="modal-body">
                        <div class="popup-box pb-4">
                            <div class="text-center">
                                <span class="cart-logo">
                                <img src="{{ asset('assets/images/cart-big.png') }}" alt="cart">
                                </span>
                            </div>
                            <div class="append-cart-table-data">

                            </div>
                            <table  class="cart-table-tr" id="cart-table-tr-sec" style="display: none">
                                <tr>
                                    <td class="product-name"></td>
                                    <td class="product-cost"></td>
                                    <td class="product-remove">
                                        <a href="#" class="circle50 product-remove-cart" id="product-remove-cart"><i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="popup-box pt-3">
                            <table class="mb-4 mb-sm-2">
                                <tr>
                                    <td class="total"> total </td>
                                    <td class="total-cart-product-price" id="total-cart-product-price"></td>
                                </tr>
                                
                                <tr>
                                    <td class="promo-code"></td>
                                    <td class="promo-code-price"></td>
                                </tr>
                                <tr>
                                    <td class="grand-total total"> Grand Total </td>
                                    <td class="grand-total-cart-product-price"></td>
                                </tr>
                                <tr class="mobile-block coupon-div d-none">
                                    <td>
                                        <input type="text" class="form-control" placeholder="Coupon" name="coupon" id="coupon_code">
                                        
                                        <a class="coupon-code-msg"></a>
                                    </td>
                                    <td>
                                        <a href="#" class="white-btn coupon-apply-btn" id="coupon-apply-btn">Apply</a>
                                        <a href="#" class="white-btn coupon-remove-btn" id="coupon-remove-btn" style="display: none">Remove</a>
                                    </td>
                                </tr>                                
                            </table>
                            <div class="form-group col-md-12">
                                <label class="checkbox green">
                                    Please accept our standard terms and conditions.
                                    <input type="checkbox" class="check1" name="check1">
                                    <span class="mark"></span>
                                    <p class="cartcheck1-msg"></p>
                                </label>
                            </div>
                            <a href="#" class="term-condition">Review our standard terms and conditions</a>
                        </div>
                    </div>
                    <div class="modal-footer popup-box">
                        <button type="submit" class="btn btn-primary white-btn cart-complete-btn" id="cart-complete-btn">Complete</button>
                        <button type="button" class="btn btn-secondary white-btn cart-cancel-btn" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
