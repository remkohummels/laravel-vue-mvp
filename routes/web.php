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

// -- Common Routes
{
    Route::get('/', 'Common\HomeController@index');

    // Authentication Routes
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');
}


// -- Frontend Routes
Route::group(['middleware' => 'auth.restaurant'], function () {
    Route::prefix('dashboard')->group(function() {
        Route::get('/', 'Frontend\DashboardController@index')->name('dashboard');
        Route::get('/restaurant-info', 'Frontend\DashboardController@getRestaurantInfo');
        Route::get('/smg-score', 'Frontend\DashboardController@getSmgScore');
    });

    Route::prefix('product-mix')->group(function() {
        Route::get('/', 'Frontend\ProductMixController@index')->name('product.mix');
        Route::get('/info', 'Frontend\ProductMixController@getInfo');
        Route::post('/update', 'Frontend\ProductMixController@update');
        Route::get('/export-pdf','Frontend\ProductMixController@exportPDF');
        Route::get('/export-excel', 'Frontend\ProductMixController@exportExcel');
        Route::get('/download/{fileType?}', 'Frontend\ProductMixController@downloadFile');
    });

    Route::prefix('sales-input')->group(function() {
        Route::get('/', 'Frontend\SalesInputController@index')->name('sales.input');
        Route::get('/info', 'Frontend\SalesInputController@getInfo');
        Route::post('/update', 'Frontend\SalesInputController@update');
        Route::get('/export-pdf','Frontend\SalesInputController@exportPDF');
        Route::get('/export-excel', 'Frontend\SalesInputController@exportExcel');
        Route::get('/alert-info/{date}', 'Frontend\SalesInputController@getSalesAlertInfo');
    });

    Route::prefix('product-projection')->group(function() {
        Route::get('/', 'Frontend\ProductProjectionController@index')->name('product.projection');
        Route::post('/getInfo', 'Frontend\ProductProjectionController@getInfo');
        Route::post('/override','Frontend\ProductProjectionController@override');
        Route::get('/export-pdf/{expectedSales?}/{mod?}/{shift?}','Frontend\ProductProjectionController@exportPDF');
    });

    Route::prefix('hours-operation')->group(function() {
        Route::get('/', 'Frontend\HoursOperationController@index')->name('hours.operation');
        Route::get('/info', 'Frontend\HoursOperationController@getInfo');
        Route::post('/update', 'Frontend\HoursOperationController@update');
    });
});


// -- Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

});


// -- Special Route: for example, read and return the image

Route::get('smgdata/download', 'Admin\SMGController@download');
