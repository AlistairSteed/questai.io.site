<?php

use App\Models\Campaign;
use App\Models\Enterprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use \App\Http\Controllers\NewsController;
use \App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use \App\Http\Controllers\CampaignController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StripePaymentController;
// use \App\Http\Controllers\Auth\ResetPasswordController;
use \App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// $this->middleware('middleware', ['only' => ['login']]);
// Route::group(['middleware' => ['enterpriseId']], function () {  
//   Auth::routes();
// });
Auth::routes();

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/client-selection');
    } else {
        return redirect('/login?ent=');
    }
});

Route::get('/login-main', function () {
    $enterprise = Enterprise::findOrFail(request('ent'));
    if($enterprise){
      return view('auth.login_main', compact('enterprise'));
    }
});
Route::get('/register-main', function () {
  $enterprise = Enterprise::findOrFail(request('ent'));
  if($enterprise){
    return view('auth.register_main', compact('enterprise'));
  }
});
Route::get('saconsole', [DashboardController::class, 'saconsole'])->name('saconsole');
Route::get('topadmin', [DashboardController::class, 'topadmin'])->name('topadmin');

/*
  |--------------------------------------------------------------------------
  | Routes for Both Users Without Authentication
  |--------------------------------------------------------------------------
*/
Route::post('/public/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.newname');
Route::get('password/reset/{ent}', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request.newname');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.reset.newname');
Route::get('password/reset/{token}/{enterpriseId}', [ForgotPasswordController::class, 'showResetForm'])->name('password_reset_submit');
Route::get('thankyou', [ForgotPasswordController::class, 'thankYou'])->name('thankyou');

//Webhooks Route

Route::any('stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');

Route::any('payment/success', [CheckoutController::class, 'paymentSuccess']);
//   session()->flash('status', 'Task was successful!');
//    return redirect('/')->with('success','Your order has been successfully completed.');
// });

Route::any('payment/cancelled', [CheckoutController::class, 'paymentCancel']);
  // session()->flash('status', 'Task was successful!');
  //    return redirect('/')->with('success','You have to cancel your payment');
// });

/*
  |--------------------------------------------------------------------------
  | Global Routes for All Users, Required Authentication
  |--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout.newname');
    Route::get('edit-profile', [DashboardController::class, 'editProfile'])->name('edit.profile');
    Route::post('update-profile', [DashboardController::class, 'updateProfile'])->name('update.profile');

    /*
    |--------------------------------------------------------------------------
    | Routes For Client Management
    |--------------------------------------------------------------------------
  */
    Route::get('client-selection', [DashboardController::class, 'index'])->name('client-selection');
    Route::get('update-client/{client_id}', [DashboardController::class, 'updateClient'])->name('update-client');
    Route::post('post-update-client/{client_id}', [DashboardController::class, 'postUpdateClient'])->name('post-update-client');
    Route::get('client-overview/{client_id}', [DashboardController::class, 'getClientOverview'])->name('client-overview');

    /*
    |--------------------------------------------------------------------------
    | Routes For Sales Management
    |--------------------------------------------------------------------------
  */
    Route::get('sales', [DashboardController::class, 'getSales'])->name('sales');
    Route::post('ajax-sales', [DashboardController::class, 'ajaxGetSales'])->name('ajax-get-sales');

    /*
     |--------------------------------------------------------------------------
     | Routes For Campaign Management
     |--------------------------------------------------------------------------
   */
    Route::get('campaign/create/{client_id}', [CampaignController::class, 'createCampaign'])->name('campaign.create');
    Route::get('campaign/edit/{client_id}/{id}', [CampaignController::class, 'editCampaign'])->name('campaign.edit');
    Route::post('campaign/store/{client_id}', [CampaignController::class, 'storeCampaign'])->name('campaign.store');
    Route::post('campaign/update/{client_id}/{id}', [CampaignController::class, 'updateCampaign'])->name('campaign.update');
    Route::get('campaign-overview/{client_id}/{id}', [DashboardController::class, 'getCampaignOverview'])->name('campaign-overview');
    Route::post('campaign-status-approve', [DashboardController::class, 'approveCampaignStatus'])->name('change-campaign-status');
    Route::post('ajax-candidates', [DashboardController::class, 'ajaxGetCandidates'])->name('ajax-get-candidates');
    Route::post('candidate-status-change', [DashboardController::class, 'changeCandidateStatus'])->name('change-candidate-status');
    Route::get('campaign-grant-access/{client_id}/{id}', [CampaignController::class, 'getCampaignGrantAccess'])->name('campaign-grant-access');
        
    Route::post('ajax-cajobtypeid-search', [CampaignController::class, 'ajaxCajobTypeIdSearch'])->name('ajax-cajobtypeid-search');
    
    Route::post('campaign-grant-access-store',  [CampaignController::class, 'campaignGrantAccessStore'])->name('grant_access.store');
    Route::post('grant-access/delete/{user_id}',  [CampaignController::class, 'grantAccessUserDelete'])->name('grantAccessUserDelete');
    
    Route::post('ajax-candidate-name', [DashboardController::class, 'ajaxGetCandidateName'])->name('ajax-get-candidatee-name');
    Route::post('getcomments/{candidate_id}', [DashboardController::class, 'ajaxGetCandidateComment'])->name('ajax-get-candidate-comment');
    Route::get('getcomment/{comment_id}', [DashboardController::class, 'ajaxGetComment'])->name('ajax-get-comment');
    Route::post('add-comment', [DashboardController::class, 'addCandidateComment'])->name('add-candidate-comment');
    Route::post('edit-comment', [DashboardController::class, 'editCandidateComment'])->name('edit-candidate-comment');

    
    Route::post('ajax-get-candidate-buy-assessments', [DashboardController::class, 'ajaxGetCandidateBuyAssessments'])->name('ajax-get-candidate-buy-assessments');
    Route::post('candidate-assessment-additional-addtocart', [DashboardController::class, 'candidateAssessmentAdditionalAddtocart'])->name('candidate-assessment-additional-addtocart');
    Route::post('candidate-assessment-additional-remove-cart', [DashboardController::class, 'candidateAssessmentAdditionalRemovetocart'])->name('candidate-assessment-additional-remove-cart');
    Route::post('ajax-candidate-assessment-additional-search', [DashboardController::class, 'ajaxCandidateAssessmentAdditionalSearch'])->name('ajax-candidate-assessment-additional-search');

    Route::post('get-candidate-category-name-wise-data', [DashboardController::class, 'getCandidateCategoryNameWiseData'])->name('get-candidate-category-name-wise-data');
    Route::post('get-campaign-category-name-wise-data', [DashboardController::class, 'getCampaignCategoryNameWiseData'])->name('get-campaign-category-name-wise-data');
    
    Route::post('ajax-get-campaign-buy-assessments', [DashboardController::class, 'ajaxGetCampaignBuyAssessments'])->name('ajax-get-campaign-buy-assessments');
    Route::post('ajax-campaign-assessment-additional-search', [DashboardController::class, 'ajaxCampaignAssessmentAdditionalSearch'])->name('ajax-campaign-assessment-additional-search');
    Route::post('campaign-assessment-additional-addtocart', [DashboardController::class, 'campaignAssessmentAdditionalAddtocart'])->name('campaign-assessment-additional-addtocart');
    Route::post('campaign-assessment-additional-remove-cart', [DashboardController::class, 'campaignAssessmentAdditionalRemovetocart'])->name('campaign-assessment-additional-remove-cart');
    
    Route::post('check-coupon-code', [DashboardController::class, 'checkCouponCode']);
    

    Route::get('ajax-get-cart-product', [DashboardController::class, 'ajaxGetCartProduct'])->name('ajax-get-cart-product');
    Route::post('product-remove-cart', [DashboardController::class, 'productRemoveCart'])->name('product-remove-cart');
    Route::get('ajax-get-product-name', [DashboardController::class, 'ajaxGetProductName'])->name('ajax-get-product-name');

    //CheckOut
    Route::post('checkout-page', [CheckoutController::class, 'checkout'])->name('checkout.page');
    Route::post('checkout', [CheckoutController::class, 'afterpayment'])->name('checkout.credit-card');

    
    Route::get('my-basket', [DashboardController::class, 'myBasket'])->name('my.order');
    Route::get('my-order-history/{id}', [DashboardController::class, 'myOrderHistory'])->name('my.order.history');
    
    
    /*
      |--------------------------------------------------------------------------
      | Routes For News Management
      |--------------------------------------------------------------------------
    */
        Route::prefix('news-setup')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('news.index');
            Route::get('indexAjax', [NewsController::class, 'indexAjax'])->name('news.indexAjax');
            Route::post('/store',  [NewsController::class, 'store'])->name('news.store');
            Route::get('/delete/{id}', [NewsController::class, 'delete'])->name('news.delete');
        });

    /*
     |--------------------------------------------------------------------------
     | Routes For Users Management
     |--------------------------------------------------------------------------
   */
    Route::prefix('users')->group(function () {
        Route::get('/user/{client_id}', [UserController::class, 'index'])->name('users.index.user');
        Route::get('/ent/{ent_id}', [UserController::class, 'indexent'])->name('users.index.ent');
        Route::get('indexAjax/{client_id}/{user_id}/{type}', [UserController::class, 'indexAjax'])->name('users.indexAjax');
        Route::post('/store/{client_id}',  [UserController::class, 'store'])->name('users.store');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    });
    Route::prefix('clients')->group(function () {
      Route::get('/', [UserController::class, 'clients'])->name('clients.index');
      Route::post('/create', [UserController::class, 'clientcreate'])->name('clients.indexAjax');
  });

    Route::get('attachment/file/{filename}', [CampaignController::class, 'fileResponse']);
});


