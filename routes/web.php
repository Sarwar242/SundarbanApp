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


//Clear route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});
//Clear config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'run migrate';
});
Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return 'run seed';
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

    // Password Reset
    Route::get('/password/reset','Backend\Auth\AdminAuthController@showLinkRequestForm')
    ->name('password.request');
    Route::post('/password/email','Backend\Auth\ResetPasswordController@sendResetLinkEmail')
    ->name('password.email');

    Route::get('/password/reset/{token}', 'Backend\Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
    Route::post('/password/reset', 'Backend\Auth\ResetPasswordController@reset')
        ->name('password.update');


    //Dashboard
    Route::get('/', 'Backend\AdminController@index')->name('dashboard');




    // ********Functionalities*********

    //Admin
    Route::get('admin/create', 'Backend\AdminController@createAdmin')->name('admin.create');
    Route::post('admin/create', 'Backend\AdminController@storeAdmin')->name('admin.create.submit');
    Route::post('admin/ban', 'Backend\AdminController@adminBan');
    Route::get('admin/update/{id}', 'Backend\AdminController@editAdmin')->name('admin.update');
    Route::post('admin/update/{id}', 'Backend\AdminController@updateAdmin')->name('admin.update.submit');
    Route::get('admins', 'Backend\AdminController@admins')->name('admins');
    Route::get('profile/{username}', 'Backend\AdminController@profile')->name('profile');
    Route::get('profile', 'Backend\AdminController@show')->name('profile.own');
    Route::post('profile/update', 'Backend\AdminController@update');
    Route::get('admin/delete/{id}', 'Backend\AdminController@destroy')->name('admin.delete');



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
    Route::get('company/delete/{id}', 'Backend\CompanyController@destroy')->name('company.delete');
    Route::post('company/ban/{id}', 'Backend\AdminController@companyBan')->name('company.ban');
    Route::post('company/boost/{id}', 'Backend\BoostController@boost')->name('company.boost');
    Route::get('company/boost/delete/{id}', 'Backend\BoostController@destroy')->name('company.boost.delete');
    Route::get('company/featured', 'Backend\BoostController@featured')->name('company.featured');
    Route::get('company/boost/records', 'Backend\BoostController@records')->name('company.records');
    Route::get('company/boost/record/delete/{id}', 'Backend\BoostController@recordDelete')->name('company.record.delete');
    Route::get('api/company/priority', 'Backend\CompanyController@priority');





//Companies in  Location and Category
    Route::get('division/category/companies/{category}/{location}', 'Backend\DivisionController@categoryCompanies')->name('division.category.companies');
    Route::get('division/subcategory/companies/{category}/{location}', 'Backend\DivisionController@subcategoryCompanies')->name('division.subcategory.companies');
    Route::get('district/category/companies/{category}/{location}', 'Backend\DistrictController@categoryCompanies')->name('district.category.companies');
    Route::get('district/subcategory/companies/{category}/{location}', 'Backend\DistrictController@subcategoryCompanies')->name('district.subcategory.companies');
    Route::get('upazilla/category/companies/{category}/{location}', 'Backend\UpazillaController@categoryCompanies')->name('upazilla.category.companies');
    Route::get('upazilla/subcategory/companies/{category}/{location}', 'Backend\UpazillaController@subcategoryCompanies')->name('upazilla.subcategory.companies');
    Route::get('union/category/companies/{category}/{location}', 'Backend\UnionController@categoryCompanies')->name('union.category.companies');
    Route::get('union/subcategory/companies/{category}/{location}', 'Backend\UnionController@subcategoryCompanies')->name('union.subcategory.companies');

//Companies in  Location and Category
    Route::get('division/category/products/{category}/{location}', 'Backend\DivisionController@categoryProducts')->name('division.category.products');
    Route::get('division/subcategory/products/{subcategory}/{location}', 'Backend\DivisionController@subcategoryProducts')->name('division.subcategory.products');

    Route::get('district/category/products/{category}/{location}', 'Backend\DistrictController@categoryProducts')->name('district.category.products');
    Route::get('district/subcategory/products/{subcategory}/{location}', 'Backend\DistrictController@subcategoryProducts')->name('district.subcategory.products');

    Route::get('upazilla/category/products/{category}/{location}', 'Backend\UpazillaController@categoryProducts')->name('upazilla.category.products');
    Route::get('upazilla/subcategory/products/{subcategory}/{location}', 'Backend\UpazillaController@subcategoryProducts')->name('upazilla.subcategory.products');

    Route::get('union/category/products/{category}/{location}', 'Backend\UnionController@categoryProducts')->name('union.category.products');
    Route::get('union/subcategory/products/{subcategory}/{location}', 'Backend\UnionController@subcategoryProducts')->name('union.subcategory.products');



    //Customer
    Route::get('customers', 'Backend\CustomerController@index')->name('customers');
    Route::get('customer/create', 'Backend\CustomerController@create')->name('customer.create');
    Route::get('customer/update/{id}', 'Backend\CustomerController@edit')->name('customer.update');
    Route::post('customer/update/{id}', 'Backend\CustomerController@update')->name('customer.update.submit');
    Route::get('customer/delete/{id}', 'Backend\CustomerController@destroy')->name('customer.delete');
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
    Route::get('category/show/{id}', 'Backend\CategoryController@show')->name('category.show');
    Route::get('category/delete/{id}', 'Backend\CategoryController@destroy')->name('category.delete');
    Route::get('category/locations/companies/{id}', 'Backend\CategoryController@companiesByLocation')->name('category.locations.companies');
    Route::get('api/category/featured', 'Backend\CategoryController@featuredFunc');
    Route::get('api/category/priority', 'Backend\CategoryController@priorityFunc');
    Route::get('api/category/district/{id}', 'Backend\CategoryController@dataTableDist')->name('api.dist.get');
    Route::get('api/category/upazilla/{id}', 'Backend\CategoryController@dataTableUpz')->name('api.upz.get');
    Route::get('api/category/union/{id}', 'Backend\CategoryController@dataTableUnn')->name('api.unn.get');







    //Subcategory
    Route::get('subcategories', 'Backend\SubcategoryController@index')->name('subcategories');
    Route::get('subcategory/create', 'Backend\SubcategoryController@create')->name('subcategory.create');
    Route::post('subcategory/create', 'Backend\SubcategoryController@store')->name('subcategory.create.submit');
    Route::get('subcategory/update/{id}', 'Backend\SubcategoryController@edit')->name('subcategory.update');
    Route::post('subcategory/update/{id}', 'Backend\SubcategoryController@update')->name('subcategory.update.submit');
    Route::get('subcategory/show/{id}', 'Backend\SubcategoryController@show')->name('subcategory.show');
    Route::get('subcategory/locations/companies/{id}', 'Backend\SubcategoryController@companiesByLocation')->name('subcategory.locations.companies');
    Route::get('subcategory/delete/{id}', 'Backend\SubcategoryController@destroy')->name('subcategory.delete');
    Route::get('api/subcategory/featured', 'Backend\SubcategoryController@featuredFunc');
    Route::get('api/subcategory/priority', 'Backend\SubcategoryController@priorityFunc');
    Route::get('api/subcategory/district/{id}', 'Backend\SubcategoryController@dataTableDist')->name('api.dist2.get');    Route::get('api/category/district/{id}', 'Backend\CategoryController@dataTableDist')->name('api.dist.get');
    Route::get('api/subcategory/upazilla/{id}', 'Backend\SubcategoryController@dataTableUpz')->name('api.upz2.get');
    Route::get('api/subcategory/union/{id}', 'Backend\SubcategoryController@dataTableUnn')->name('api.unn2.get');





    //Division
    Route::get('divisions', 'Backend\DivisionController@index')->name('divisions');
    Route::get('division/create', 'Backend\DivisionController@create')->name('division.create');
    Route::post('division/create', 'Backend\DivisionController@store')->name('division.create.submit');
    Route::get('division/update/{id}', 'Backend\DivisionController@edit')->name('division.update');
    Route::post('division/update/{id}', 'Backend\DivisionController@update')->name('division.update.submit');
    Route::get('division/show/{id}', 'Backend\DivisionController@show')->name('division.show');
    Route::get('division/delete/{id}', 'Backend\DivisionController@destroy')->name('division.delete');
    // Route::get('division/view/{id}', 'Backend\DivisionController@destroy')->name('division.delete');




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

    //Notice
    Route::get('notices', 'Backend\NoticeController@index')->name('notices');
    Route::get('notice/create', 'Backend\NoticeController@create')->name('notice.create');
    Route::post('notice/create', 'Backend\NoticeController@store')->name('notice.create.submit');
    Route::get('notice/update/{id}', 'Backend\NoticeController@edit')->name('notice.update');
    Route::post('notice/update/{id}', 'Backend\NoticeController@update')->name('notice.update.submit');
    Route::get('notice/show/{id}', 'Backend\NoticeController@show')->name('notice.show');
    Route::get('notice/delete/{id}', 'Backend\NoticeController@destroy')->name('notice.delete');



    //News
    Route::get('news', 'Backend\NewsController@index')->name('news');
    // Route::get('news/create', 'Backend\NewsController@create')->name('news.create');
    Route::get('news/create/', 'Backend\NewsController@store')->name('news.create.submit');
    Route::get('news/update/{id}', 'Backend\NewsController@edit')->name('news.update');
    Route::post('news/update/{id}', 'Backend\NewsController@update')->name('news.update.submit');
    Route::get('news/show/{id}', 'Backend\NewsController@show')->name('news.show');
    Route::get('news/delete/{id}', 'Backend\NewsController@destroy')->name('news.delete');

    //Blogs
    Route::get('blogs', 'Backend\BlogController@index')->name('blogs');
    // Route::get('blog/create', 'Backend\BlogController@create')->name('blog.create');
    Route::get('blog/create/', 'Backend\BlogController@store')->name('blog.create.submit');
    Route::get('blog/update/{id}', 'Backend\BlogController@edit')->name('blog.update');
    Route::post('blog/update/{id}', 'Backend\BlogController@update')->name('blog.update.submit');
    Route::get('blog/show/{id}', 'Backend\BlogController@show')->name('blog.show');
    Route::get('blog/delete/{id}', 'Backend\BlogController@destroy')->name('blog.delete');






    //Realtime=jquery
    Route::get('/get-companies', function () {
        return json_encode(App\Models\Company::orderBy('name', 'ASC')->get());
    });
    Route::get('/get-customers', function () {
        return json_encode(App\Models\Customer::orderBy('first_name', 'ASC')->get());
    });
    Route::get('/get-admins', function () {
        return json_encode(App\Models\Admin::orderBy('first_name', 'ASC')->get());
    });
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
