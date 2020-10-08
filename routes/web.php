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

    //Authorization
    Route::get('/login','Backend\Auth\AdminAuthController@showLoginForm')->name('login');
    Route::post('/login', 'Backend\Auth\AdminAuthController@login')->name('login.submit');
    Route::get('logout/', 'Backend\Auth\AdminAuthController@logout')->name('logout');

    //Dashboard
    Route::get('/', 'Backend\AdminController@index')->name('dashboard');




    // ********Functionalities*********

    //Admin
    Route::get('admin/create', 'Backend\AdminController@createAdmin')->name('admin.create');
    Route::post('admin/create', 'Backend\AdminController@storeAdmin')->name('admin.create.submit');
    Route::post('admin/ban', 'Backend\AdminController@customerBan');
    Route::get('admin/update/{id}', 'Backend\AdminController@editAdmin')->name('admin.update');
    Route::post('admin/update/{id}', 'Backend\AdminController@updateAdmin')->name('admin.update.submit');
    Route::get('admins', 'Backend\AdminController@admins')->name('admins');
    Route::get('profile/{username}', 'Backend\AdminController@profile')->name('profile');
    Route::get('profile', 'Backend\AdminController@show')->name('profile.own');
    Route::post('profile/update', 'Backend\AdminController@update');
   


    //User
    Route::post('user/create', 'Backend\AdminController@userCreate')->name('user.create.submit');
    Route::post('user/change', 'Backend\AdminController@user_change_password')->name('user.password.change.submit');
    Route::get('users', 'Backend\AdminController@users');




    //Company
    Route::get('companies', 'Backend\CompanyController@index')->name('companies');
    Route::get('company/create', 'Backend\CompanyController@create')->name('company.create');
    Route::get('company/update/{id}', 'Backend\CompanyController@edit')->name('company.update');
    Route::get('company/profile/{slug}', 'Backend\CompanyController@profile')->name('company.profile');
    Route::post('company/update/{id}', 'Backend\CompanyController@update')->name('company.update.submit');
    Route::post('company/delete/{id}', 'Backend\CompanyController@destroy')->name('company.delete');
    Route::post('company/ban/{id}', 'Backend\AdminController@companyBan')->name('company.ban');


    //Customer
    Route::get('customers', 'Backend\CustomerController@index')->name('customers');
    Route::get('customer/create', 'Backend\CustomerController@create')->name('customer.create');
    Route::get('customer/update/{id}', 'Backend\CustomerController@edit')->name('customer.update');
    Route::post('customer/update/{id}', 'Backend\CustomerController@update')->name('customer.update.submit');
    Route::get('customer/ban', 'Backend\CustomerController@ban');
    Route::get('customer/profile/{username}', 'Backend\CustomerController@profile')->name('customer.profile');




    //Product-Part

    Route::get('products', 'Backend\ProductController@index')->name('products');
    Route::get('product/create', 'Backend\ProductController@create')->name('product.create');
    Route::post('product/create', 'Backend\ProductController@store')->name('product.create.submit');
    Route::get('product/update/{id}', 'Backend\ProductController@edit')->name('product.update');
    Route::post('product/update/{id}', 'Backend\ProductController@update')->name('product.update.submit');
    Route::get('product/show/{slug}', 'Backend\ProductController@show')->name('product.show');
    Route::get('product/delete/{id}', 'Backend\ProductController@destroy')->name('product.delete');
    Route::post('product/image/upload/{id}', 'Backend\ProductController@uploadImage')->name('product.image.store');
    Route::post('product/image/setpriority/{id}', 'Backend\ProductController@setPriority');
    Route::get('product/image/delete/{id}', 'Backend\ProductController@deleteImage')->name('product.image.delete');



        
    //Category
    Route::get('categories', 'Backend\CategoryController@index')->name('categories');
    Route::get('category/create', 'Backend\CategoryController@create')->name('category.create');
    Route::post('category/create', 'Backend\CategoryController@store')->name('category.create.submit');
    Route::get('category/update/{id}', 'Backend\CategoryController@edit')->name('category.update');
    Route::post('category/update/{id}', 'Backend\CategoryController@update')->name('category.update.submit');
    Route::get('category/show/{id}', 'Backend\CategoryController@show')->name('category.show');;
    Route::get('category/delete/{id}', 'Backend\CategoryController@destroy')->name('category.delete');

    


    //Subcategory
    Route::get('subcategories', 'Backend\SubcategoryController@index')->name('subcategories');
    Route::get('subcategory/create', 'Backend\SubcategoryController@create')->name('subcategory.create');
    Route::post('subcategory/create', 'Backend\SubcategoryController@store')->name('subcategory.create.submit');
    Route::get('subcategory/update/{id}', 'Backend\SubcategoryController@edit')->name('subcategory.update');
    Route::post('subcategory/update/{id}', 'Backend\SubcategoryController@update')->name('subcategory.update.submit');
    Route::get('subcategory/show/{id}', 'Backend\SubcategoryController@show')->name('subcategory.show');
    Route::get('subcategory/delete/{id}', 'Backend\SubcategoryController@destroy')->name('subcategory.delete');





    //Division
    Route::get('divisions', 'Backend\DivisionController@index')->name('divisions');
    Route::get('division/create', 'Backend\DivisionController@create')->name('division.create');
    Route::post('division/create', 'Backend\DivisionController@store')->name('division.create.submit');
    Route::get('division/update/{id}', 'Backend\DivisionController@edit')->name('division.update');
    Route::post('division/update/{id}', 'Backend\DivisionController@update')->name('division.update.submit');
    Route::get('division/show/{id}', 'Backend\DivisionController@show')->name('division.show');
    Route::get('division/delete/{id}', 'Backend\DivisionController@destroy')->name('division.delete');




    //District
    Route::get('districts', 'Backend\DistrictController@index')->name('districts');
    Route::get('district/create', 'Backend\DistrictController@create')->name('district.create');;
    Route::post('district/create', 'Backend\DistrictController@store')->name('district.create.submit');
    Route::get('district/update/{id}', 'Backend\DistrictController@edit')->name('district.update');
    Route::post('district/update/{id}', 'Backend\DistrictController@update')->name('district.update.submit');
    Route::get('district/show/{id}', 'Backend\DistrictController@show')->name('district.show');
    Route::get('district/delete/{id}', 'Backend\DistrictController@destroy')->name('district.delete');





    //Upazilla
    Route::get('upazillas', 'Backend\UpazillaController@index')->name('upazillas');
    Route::get('upazilla/create', 'Backend\UpazillaController@create')->name('upazilla.create');
    Route::post('upazilla/create', 'Backend\UpazillaController@store')->name('upazilla.create.submit');
    Route::get('upazilla/update/{id}', 'Backend\UpazillaController@edit')->name('upazilla.update');
    Route::post('upazilla/update/{id}', 'Backend\UpazillaController@update')->name('upazilla.update.submit');
    Route::get('upazilla/show/{id}', 'Backend\UpazillaController@show')->name('upazilla.show');
    Route::get('upazilla/delete/{id}', 'Backend\UpazillaController@destroy')->name('upazilla.delete');





    //Union
    Route::get('unions', 'Backend\UnionController@index')->name('unions');
    Route::get('union/create', 'Backend\UnionController@create')->name('union.create');
    Route::post('union/create', 'Backend\UnionController@store')->name('union.create.submit');
    Route::get('union/update/{id}', 'Backend\UnionController@edit')->name('union.update');
    Route::post('union/update/{id}', 'Backend\UnionController@update')->name('union.update.submit');
    Route::get('union/show/{id}', 'Backend\UnionController@show')->name('union.show');
    Route::get('union/delete/{id}', 'Backend\UnionController@destroy')->name('union.delete');





    //Unit
    Route::get('units', 'Backend\UnitController@index')->name('units');
    Route::get('unit/create', 'Backend\UnitController@create')->name('unit.create');
    Route::post('unit/create', 'Backend\UnitController@store')->name('unit.create.submit');
    Route::get('unit/update/{id}', 'Backend\UnitController@edit')->name('unit.update');
    Route::post('unit/update/{id}', 'Backend\UnitController@update')->name('unit.update.submit');
    Route::get('unit/show/{id}', 'Backend\UnitController@show')->name('unit.show');
    Route::get('unit/delete/{id}', 'Backend\UnitController@destroy')->name('unit.delete');


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