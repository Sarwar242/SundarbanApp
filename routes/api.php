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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', 'Api\SubcategoryController@test');

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('logout', 'Api\AuthController@logout');

Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Api\ResetPasswordController@reset');


Route::get('email/resend', 'Api\VerificationController@resend')
            ->name('verification.resend');
            
Route::get('email/verify/{id}/{hash}', 'Api\VerificationController@verify')
            ->name('verification.verify');


//Product-Part->middleware('auth:api');

Route::get('product/all', 'Api\ProductController@index');
Route::post('product/create', 'Api\ProductController@store');
Route::post('product/update', 'Api\ProductController@update');
Route::get('product/show', 'Api\ProductController@show');
Route::get('product/delete', 'Api\ProductController@destroy');
Route::post('product/image/upload', 'Api\ProductController@uploadImage');
Route::post('product/image/setpriority', 'Api\ProductController@setPriority');
Route::get('product/image/delete', 'Api\ProductController@deleteImage');




//Category
Route::get('category/all', 'Api\CategoryController@index');
Route::post('category/create', 'Api\CategoryController@store');
Route::post('category/update', 'Api\CategoryController@update');
Route::get('category/show', 'Api\CategoryController@show');
Route::get('category/delete', 'Api\CategoryController@destroy');




//Subcategory
Route::get('subcategory/all', 'Api\SubcategoryController@index');
Route::post('subcategory/create', 'Api\SubcategoryController@store')->name('api.test');
Route::post('subcategory/update', 'Api\SubcategoryController@update');
Route::get('subcategory/show', 'Api\SubcategoryController@show');
Route::get('subcategory/delete', 'Api\SubcategoryController@destroy');



