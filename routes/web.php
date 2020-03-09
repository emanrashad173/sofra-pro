<?php

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

//admin

Route::group(['middleware' =>['auth', 'auto-check-permission'],'prefix' => 'admin'],function()
{
  Route::resource('/role','RoleController' );
  Route::resource('/user','UserController' );
  Route::get('/', function () {
      return view('admin-home');
  });
  Route::group(['namespace' => 'Admin'],function()
  {
      Route::resource('/city','CityController' );
      Route::resource('/district','DistrictController' );
      Route::resource('/setting','SettingController' );
      Route::resource('/category','CategoryController' );
      Route::resource('/contact','ContactController' );
      Route::resource('/payment','PaymentController' );
      Route::resource('/payment-method','PaymentMethodController' );
      Route::resource('/offer','OfferController' );
      Route::resource('/order','OrderController' );
      Route::resource('/client','ClientController' );
      Route::resource('/restaurant','RestaurantController' );
      Route::get('/restaurant/{id}/active','RestaurantController@active' )->name('active-restaurant');
      Route::get('/restaurant/{id}/deactive','RestaurantController@deactive' )->name('deactive-restaurant');
      Route::get('/client/{id}/active','ClientController@active' )->name('active-client');
      Route::get('/client/{id}/deactive','ClientController@deactive' )->name('deactive-client');
      Route::get('/change-password','UserController@changePassword')->name('user.change-password');
      Route::post('/update-password','UserController@updatePassword')->name('user.update-password');;
 });


});


//front
Route::group(['namespace'=>'Front'],function()
{
  Route::get('/home', 'MainController@home');
  Route::get('/all-offers', 'MainController@offers');
  Route::get('/restaurant-page/{restaurant}','MainController@restaurantProducts');
  Route::get('/product-show/{id}', 'MainController@productShow');
  Route::get('/contact','MainController@contact');
  Route::post('/contact-save','MainController@contactSave');
  Route::get('/contact','MainController@contact');
  Route::get('/comments/{restaurant}','MainController@comments');


  //client
  Route::group(['namespace' => 'Client','prefix' => 'client'],function()
  {
    Route::get('/register-client' , 'AuthController@register');
    Route::post('/registered' , 'AuthController@registerSave');
    Route::get('/login-client' , 'AuthController@login');
    Route::post('/login-submit' , 'AuthController@loginSubmit');
    Route::get('/reset-password-client','AuthController@resetPassword');
    Route::post('/password-reset' ,'AuthController@passwordReset');
    Route::get('/new-password-client','AuthController@newPassword');
    Route::post('/password-changed' ,'AuthController@passwordChanged');

    //client-auth
    Route::group(['middleware' => 'auth:web-client'],function()
    {
        Route::get('/profile-client','AuthController@profile');
        Route::put('/profile-set','AuthController@profileSet');
        Route::get('/my-orders','MainController@myOrder');
        Route::get('/my-previous-orders','MainController@previousOrder');
        Route::get('/deliver-order/{id}','MainController@deliverOrder');
        Route::get('/decline-order/{id}','MainController@declineOrder');
        Route::post('/create-comment/{id}','MainController@commentCreate');
        Route::get('/add-to-cart/{id}','MainController@addToCart');
        Route::get('/product-remove/{id}','MainController@removeProduct');
        Route::get('/cart','MainController@cart');
        Route::get('/new-order/{id}','MainController@newOrder');
        Route::put('/create-order/{id}','MainController@createOrder');
        Route::get('/logout','AuthController@logout');
    });
  });

  //restaurant
  Route::group(['namespace' => 'Restaurant','prefix' => 'restaurant'],function()
  {
    Route::get('/register-restaurant' , 'AuthController@register');
    Route::post('/registered' , 'AuthController@registerSave');
    Route::get('/login-restaurant' , 'AuthController@login');
    Route::post('/logined' , 'AuthController@loginSave');
    Route::get('/reset-password-restaurant','AuthController@resetPassword');
    Route::post('/password-reset' ,'AuthController@passwordReset');
    Route::get('/new-password-restaurant','AuthController@newPassword');
    Route::post('/password-changed' ,'AuthController@passwordChanged');

    // restaurant-auth
    Route::group(['middleware' => 'auth:web-restaurant'],function()
    {
        Route::get('/profile-restaurant','AuthController@profile');
        Route::put('/profile-set','AuthController@profileSet');
        Route::get('/new-product','MainController@newProduct');
        Route::post('/create-product','MainController@productCreate');
        Route::get('/edit-product/{id}','MainController@editProduct');
        Route::put('/update-product/{id}','MainController@productUpdate');
        Route::get('/new-offer','MainController@newOffer');
        Route::post('/create-offer','MainController@offerCreate');
        Route::get('/edit-offer/{id}','MainController@editOffer');
        Route::put('/update-offer/{id}','MainController@offerUpdate');
        Route::delete('/offer-delete/{id}','MainController@offerDelete');
        Route::get('/offers','MainController@offers');
        Route::get('/products','MainController@products');
        Route::delete('/product-delete/{id}','MainController@productDelete');
        Route::get('/new-orders','MainController@newOrder');
        Route::get('/current-orders','MainController@currentOrder');
        Route::get('/previous-orders','MainController@previousOrder');
        Route::get('/accept-order/{id}','MainController@acceptOrder');
        Route::get('/confirm-order/{id}','MainController@confirmOrder');
        Route::get('/reject-order/{id}','MainController@rejectOrder');
        Route::get('/logout','AuthController@logout');


    });
  });

});


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
