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

Route::get('/clear-cache', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return 'FINISHED';  
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');






/*
|--------------------------------------------------------------------------
|-------------------------- ---Admin Routes--- ----------------------------
|--------------------------------------------------------------------------
*/


//Auth
Route::group( ['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/login','Backend\Auth\AdminAuthController@showLoginForm')->name('login');
    Route::post('/login', 'Backend\Auth\AdminAuthController@login')->name('login.submit');
    Route::get('logout/', 'Backend\Auth\AdminAuthController@logout')->name('logout');
    Route::get('/', 'Backend\AdminController@index')->name('dashboard');




    //Functionalities
    Route::post('create', 'Backend\AdminController@createAdmin');
    Route::get('company/create', 'Backend\AdminController@companyCreateForm')->name('company.create');
    Route::get('customer/create', 'Backend\AdminController@customerCreateForm')->name('customer.create');
    Route::post('user/create', 'Backend\AdminController@userCreate')->name('user.create.submit');
    Route::get('company/update/{id}', 'Backend\CompanyController@edit')->name('company.update');
    Route::post('company/update/{id}', 'Backend\CompanyController@update')->name('company.update.submit');
    Route::post('customer/update', 'Backend\CustomerController@update');
    Route::post('user/change', 'Backend\AdminController@user_change_password');
    Route::post('company/ban', 'Backend\AdminController@companyBan');
    Route::post('customer/ban', 'Backend\AdminController@customerBan');
    Route::post('admin/ban', 'Backend\AdminController@customerBan');
    Route::get('users', 'Backend\AdminController@users');
    Route::get('admins', 'Backend\AdminController@admins');
    Route::get('profile', 'Backend\AdminController@profile');
    Route::get('profile/own', 'Backend\AdminController@show');
    Route::post('profile/update', 'Backend\AdminController@update');




    //Product-Part

    Route::get('product/all', 'Backend\ProductController@index')->name('products');
    Route::get('product/create', 'Backend\ProductController@create')->name('product.create');
    Route::post('product/create', 'Backend\ProductController@store')->name('product.create.submit');
    Route::get('product/update/{id}', 'Backend\ProductController@edit')->name('product.update');
    Route::post('product/update/{id}', 'Backend\ProductController@update')->name('product.update.submit');
    Route::get('product/show', 'Backend\ProductController@show');
    Route::get('product/delete/{id}', 'Backend\ProductController@destroy')->name('product.delete');
    Route::post('product/image/upload', 'Backend\ProductController@uploadImage');
    Route::post('product/image/setpriority', 'Backend\ProductController@setPriority');
    Route::get('product/image/delete', 'Backend\ProductController@deleteImage');



        
    //Category
    Route::get('category/all', 'Backend\CategoryController@index')->name('categories');
    Route::get('category/create', 'Backend\CategoryController@create')->name('category.create');
    Route::post('category/create', 'Backend\CategoryController@store')->name('category.create.submit');
    Route::get('category/update/{id}', 'Backend\CategoryController@edit')->name('category.update');
    Route::post('category/update/{id}', 'Backend\CategoryController@update')->name('category.update.submit');
    Route::get('category/show', 'Backend\CategoryController@show')->name('category.show');;
    Route::get('category/delete/{id}', 'Backend\CategoryController@destroy')->name('category.delete');

    


    //Subcategory
    Route::get('subcategory/all', 'Backend\SubcategoryController@index')->name('subcategories');
    Route::get('subcategory/create', 'Backend\SubcategoryController@create')->name('subcategory.create');
    Route::post('subcategory/create', 'Backend\SubcategoryController@store')->name('subcategory.create.submit');
    Route::get('subcategory/update/{id}', 'Backend\SubcategoryController@edit')->name('subcategory.update');
    Route::post('subcategory/update/{id}', 'Backend\SubcategoryController@update')->name('subcategory.update.submit');
    Route::get('subcategory/show', 'Backend\SubcategoryController@show')->name('subcategory.show');
    Route::get('subcategory/delete/{id}', 'Backend\SubcategoryController@destroy')->name('subcategory.delete');





    //Division
    Route::get('division/all', 'Backend\DivisionController@index')->name('division');
    Route::get('division/create', 'Backend\DivisionController@create')->name('division.create');
    Route::post('division/create', 'Backend\DivisionController@store')->name('division.create.submit');
    Route::get('division/update', 'Backend\DivisionController@edit')->name('division.update');
    Route::post('division/update', 'Backend\DivisionController@update')->name('division.update.submit');
    Route::get('division/show', 'Backend\DivisionController@show')->name('division.show');
    Route::get('division/delete', 'Backend\DivisionController@destroy')->name('division.delete');




    //District
    Route::get('district/all', 'Backend\DistrictController@index')->name('districts');
    Route::get('district/create', 'Backend\DistrictController@create')->name('district.create');;
    Route::post('district/create', 'Backend\DistrictController@store')->name('district.create.submit');
    Route::get('district/update', 'Backend\DistrictController@edit')->name('district.update');
    Route::post('district/update', 'Backend\DistrictController@update')->name('district.update.submit');
    Route::get('district/show', 'Backend\DistrictController@show')->name('district.show');
    Route::get('district/delete', 'Backend\DistrictController@destroy')->name('district.delete');





    //Upazilla
    Route::get('upazilla/all', 'Backend\UpazillaController@index')->name('upazillas');
    Route::get('upazilla/create', 'Backend\UpazillaController@create')->name('upazilla.create');
    Route::post('upazilla/create', 'Backend\UpazillaController@store')->name('upazilla.create.submit');
    Route::get('upazilla/update', 'Backend\UpazillaController@edit')->name('upazilla.update');
    Route::post('upazilla/update', 'Backend\UpazillaController@update')->name('upazilla.update.submit');
    Route::get('upazilla/show', 'Backend\UpazillaController@show')->name('upazilla.show');
    Route::get('upazilla/delete', 'Backend\UpazillaController@destroy')->name('upazilla.delete');





    //Union
    Route::get('union/all', 'Backend\UnionController@index')->name('unions');
    Route::get('union/create', 'Backend\UnionController@create')->name('union.create');
    Route::post('union/create', 'Backend\UnionController@store')->name('union.create.submit');
    Route::get('union/update', 'Backend\UnionController@edit')->name('union.update');
    Route::post('union/update', 'Backend\UnionController@update')->name('union.update.submit');
    Route::get('union/show', 'Backend\UnionController@show')->name('union.show');
    Route::get('union/delete', 'Backend\UnionController@destroy')->name('union.delete');





    //Unit
    Route::get('unit/all', 'Backend\UnitController@index')->name('units');
    Route::get('unit/create', 'Backend\UnitController@create')->name('unit.create');
    Route::post('unit/create', 'Backend\UnitController@store')->name('unit.create.submit');
    Route::get('unit/update', 'Backend\UnitController@edit')->name('unit.update');
    Route::post('unit/update', 'Backend\UnitController@update')->name('unit.update.submit');
    Route::get('unit/show', 'Backend\UnitController@show')->name('unit.show');
    Route::get('unit/delete', 'Backend\UnitController@destroy')->name('unit.delete');


    //Realtime=jquery
    Route::get('/get-subcategories/{id}', function ($id) {
        return json_encode(App\Models\Subcategory::where('category_id', $id)->get());
    }); 
    Route::get('/get-district/{id}', function ($id) {
        return json_encode(App\Models\District::where('division_id', $id)->get());
    }); 
    Route::get('/get-upazilla/{id}', function ($id) {
        return json_encode(App\Models\Upazilla::where('district_id', $id)->get());
    });
    Route::get('/get-union/{id}', function ($id) {
        return json_encode(App\Models\Union::where('upazilla_id', $id)->get());
    });

   }) ;