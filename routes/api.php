<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix'=>'v1','namespace'=>'Api'],function()
{
    //general
    Route::get('cities','MainController@cities');
    Route::get('districts','MainController@districts');
    Route::get('categories','MainController@categories');
    Route::get('payment-methods','MainController@paymentMethods');
    Route::get('settings','MainController@settings');
    Route::get('restaurants','MainController@restaurants');
    Route::get('restaurant','MainController@restaurant');
    Route::get('list-of-restaurant-products','MainController@listRestaurantProducts');
    Route::get('list-of-restaurant-comments','MainController@listRestaurantComments');
    Route::get('offers','MainController@offers');
    Route::get('offer','MainController@offer');
    Route::post('contact-us','MainController@contactUs');


    Route::group(['prefix'=>'client','namespace'=>'Client'],function(){
        //client-un-auth
        Route::post('register' ,'AuthController@register');
        Route::post('login' ,'AuthController@login');
        Route::post('reset-password' ,'AuthController@resetPassword');
        Route::post('new-password' ,'AuthController@newPassword');




        Route::group(['middleware' => 'auth:api-client'],function(){
          //client-auth
          Route::post('register-token','AuthController@registerToken');
          Route::post('remove-token','AuthController@removeToken');
          Route::post('edit-profile' ,'AuthController@profile');
          Route::post('create-comment' ,'MainController@commentCreate');
          Route::post('create-order' ,'MainController@orderCreate');
          Route::get('notifications' ,'MainController@notification');
          Route::get('my-orders' ,'MainController@orders');
          Route::post('deliver-order' , 'MainController@deliveredOrder');
          Route::post('decline-order' , 'MainController@declinedOrder');
          Route::get('order' ,'MainController@orderShow');





        });

    });
    Route::group(['prefix'=>'restaurant','namespace'=>'Restaurant'],function(){
        //restaurant-un-auth
        Route::post('register' ,'AuthController@register');
        Route::post('login' ,'AuthController@login');
        Route::post('reset-password' ,'AuthController@resetPassword');
        Route::post('new-password' ,'AuthController@newPassword');

        Route::group(['middleware' => 'auth:api-restaurant'],function(){
          //restaurant-auth
          Route::post('register-token','AuthController@registerToken');
          Route::post('remove-token','AuthController@removeToken');
          Route::post('edit-profile' ,'AuthController@profile');
          Route::post('create-product' ,'MainController@productCreate');
          Route::post('edit-product' ,'MainController@productEdit');
          Route::post('delete-product' ,'MainController@productDelete');
          Route::get('my-products' ,'MainController@products');
          Route::post('create-offer' ,'MainController@offerCreate');
          Route::post('edit-offer' ,'MainController@offerEdit');
          Route::post('delete-offer' ,'MainController@offerDelete');
          Route::get('my-offers' ,'MainController@offers');
          Route::get('notifications' ,'MainController@notification');
          Route::get('commission' ,'MainController@commission');
          Route::get('my-orders' , 'MainController@myOrders');
          Route::get('order-details' , 'MainController@orderDetails');
          Route::post('accept-order' , 'MainController@acceptOrder');
          Route::post('confirm-order' , 'MainController@confirmOrder');
          Route::post('reject-order' , 'MainController@rejectOrder');


        });

    });

});
