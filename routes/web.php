<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\SenangPayController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\OrderMoreController;
use App\Http\Controllers\Admin\NotificationTemplateController;


/**
 * Admin login
 */

Route::middleware(['checkorder'])->group(function () {
    Route::get('/',[FrontendController::class,'index'])->name('home');
    Route::get('popup',[FrontendController::class,'popup'])->name('model.popup');
    Route::get('cartitem',[FrontendController::class,'cartitem'])->name('cartitem.item');
    Route::get('cart_item',[CartController::class,'cartitem'])->name('cart.item');
    Route::get('cart_delete',[CartController::class,'cartremove'])->name('cart.delete');    
    Route::get('preferences',[CartController::class,'checkout'])->name('cart.checkout');
    Route::get('cartplus',[CartController::class,'cartqtyplus'])->name('cart.plus');
    Route::get('cartqtyminus',[CartController::class,'cartqtyminus'])->name('cart.minus');
    Route::post('preferencesitem',[CartController::class,'preferences'])->name('cart.preferences');
    Route::get('cart_payment',[CartController::class,'paymentoption'])->name('cart.payment');
    Route::post('place_order',[OrderController::class,'place_order'])->name('order.place');
   Route::post('applycoupon',[CartController::class,'applycoupon'])->name('product.applycoupon');
   
    Route::get('ApplyCoupon',[CartController::class,'coupon'])->name('apply.coupon');
    
   
});
 
 Route::get('modelpopup',[FrontendController::class,'modeldata'])->name('model.modeldata');
Route::get('order_track',[OrderController::class,'trackorder'])->name('order.order_track');
  Route::get('place_order_success',[OrderController::class,'order_success'])->name('order.place.success');

  Route::get('ordersuccess',[OrderController::class,'success']);
  Route::get('non_veg',[FrontendController::class,'nonfilter'])->name('non.filter');
  Route::get('order_more',[OrderController::class,'order_more'])->name('order.more');

  Route::get('popplusadd_on',[FrontendController::class,'plusadd_on'])->name('add.plus');
  Route::get('send_cash_notification', [NotificationTemplateController::class, 'sendCashNotification'])->name('send.cash.notification');



  Route::get('morepopup',[OrderMoreController::class,'morepopup'])->name('moreorder.popup');
   Route::get('morecartitem',[OrderMoreController::class,'morecartitem'])->name('ordermorecartitem.item');
      Route::get('ordermore_cart_item',[OrderMoreController::class,'cart_item_data'])->name('ordermorecartitem.data');
    Route::get('ordermore_preferences',[OrderMoreController::class,'order_pre'])->name('ordermorecart.checkout');
 Route::post('order_more_placeorder',[OrderMoreController::class,'moreorder'])->name('moreorder.place');

/**
 * Pages
 */
Route::get('about-us', 'HomeController@about_us')->name('about-us');
Route::get('terms-and-conditions', 'HomeController@terms_and_conditions')->name('terms-and-conditions');
Route::get('privacy-policy', 'HomeController@privacy_policy')->name('privacy-policy');

/**
 * Auth
 */
Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthenticated.']);
    return response()->json([
        'errors' => $errors,
    ], 401);
})->name('authentication-failed');

/**
 * Payment
 */
Route::group(['prefix' => 'payment-mobile'], function () {
    Route::get('/', 'PaymentController@payment')->name('payment-mobile');
    Route::get('set-payment-method/{name}', 'PaymentController@set_payment_method')->name('set-payment-method');
});

Route::get('payment-success', 'PaymentController@success')->name('payment-success');
Route::get('payment-fail', 'PaymentController@fail')->name('payment-fail');

$is_published = 0;
try {
    $full_data = include('Modules/Gateways/Addon/info.php');
    $is_published = $full_data['is_published'] == 1 ? 1 : 0;
} catch (\Exception $exception) {}

if (!$is_published) {
    Route::group(['prefix' => 'payment'], function () {

        //SSLCOMMERZ
        Route::group(['prefix' => 'sslcommerz', 'as' => 'sslcommerz.'], function () {
            Route::get('pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
            Route::post('success', [SslCommerzPaymentController::class, 'success'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('failed', [SslCommerzPaymentController::class, 'failed'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('canceled', [SslCommerzPaymentController::class, 'canceled'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //PAYPAL
        Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
            Route::get('pay', [PaypalPaymentController::class, 'payment']);
            Route::any('success', [PaypalPaymentController::class, 'success'])->name('success')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;
            Route::any('cancel', [PaypalPaymentController::class, 'cancel'])->name('cancel')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;
        });

        //STRIPE
        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
            Route::get('pay', [StripePaymentController::class, 'index'])->name('pay');
            Route::get('token', [StripePaymentController::class, 'payment_process_3d'])->name('token');
            Route::get('success', [StripePaymentController::class, 'success'])->name('success');
        });

        //RAZOR-PAY
        Route::group(['prefix' => 'razor-pay', 'as' => 'razor-pay.'], function () {
            Route::get('pay', [RazorPayController::class, 'index']);
            Route::post('payment', [RazorPayController::class, 'payment'])->name('payment')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //SENANG-PAY
        Route::group(['prefix' => 'senang-pay', 'as' => 'senang-pay.'], function () {
            Route::get('pay', [SenangPayController::class, 'index']);
            Route::any('callback', [SenangPayController::class, 'return_senang_pay']);
        });

        //PAYSTACK
        Route::group(['prefix' => 'paystack', 'as' => 'paystack.'], function () {
            Route::get('pay', [PaystackController::class, 'index'])->name('pay');
            Route::post('payment', [PaystackController::class, 'redirectToGateway'])->name('payment');
            Route::get('callback', [PaystackController::class, 'handleGatewayCallback'])->name('callback');
        });

        //PAYMOB
        Route::group(['prefix' => 'paymob', 'as' => 'paymob.'], function () {
            Route::any('pay', [PaymobController::class, 'credit'])->name('pay');
            Route::any('callback', [PaymobController::class, 'callback'])->name('callback');
        });

        //FLUTTERWAVE
        Route::group(['prefix' => 'flutterwave-v3', 'as' => 'flutterwave-v3.'], function () {
            Route::get('pay', [FlutterwaveController::class, 'initialize'])->name('pay');
            Route::get('callback', [FlutterwaveController::class, 'callback'])->name('callback');
        });

        //BKASH
        Route::group(['prefix' => 'bkash', 'as' => 'bkash.'], function () {
            // Payment Routes for bKash
            Route::get('make-payment', [BkashPaymentController::class, 'make_tokenize_payment'])->name('make-payment');
            Route::any('callback', [BkashPaymentController::class, 'callback'])->name('callback');

            // Refund Routes for bKash
            // Route::get('refund', 'BkashRefundController@index')->name('bkash-refund');
            // Route::post('refund', 'BkashRefundController@refund')->name('bkash-refund');
        });

        //MERCADOPAGO
        Route::group(['prefix' => 'mercadopago', 'as' => 'mercadopago.'], function () {
            Route::get('pay', [MercadoPagoController::class, 'index'])->name('index');
            Route::post('make-payment', [MercadoPagoController::class, 'make_payment'])->name('make_payment');
        });
    });
}


/**
 * Currency
 */
Route::get('add-currency', function () {
    $currencies = file_get_contents("installation/currency.json");
    $decoded = json_decode($currencies, true);
    $keep = [];
    foreach ($decoded as $item) {
        array_push($keep, [
            'country' => $item['name'],
            'currency_code' => $item['code'],
            'currency_symbol' => $item['symbol_native'],
            'exchange_rate' => 1,
        ]);
    }
    DB::table('currencies')->insert($keep);
    return response()->json(['ok']);
});

