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
Route::post('hashpass', 'Api\AdminController@hash');

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('logout', 'Api\AuthController@logout')->middleware('auth:api');
Route::post('password/change', 'Api\AuthController@change_password')->middleware('auth:api');

Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');

//Route::post('password/reset', 'Api\ResetPasswordController@reset');


Route::get('email/resend', 'Api\VerificationController@resend')
            ->name('verification.resend');

Route::get('email/verify/{id}/{hash}', 'Api\VerificationController@verify')
            ->name('verification.verify');



/*
|--------------------------------------------------------------------------
| Follow and Review Rating API Routes
|--------------------------------------------------------------------------
*/
Route::post('company/follow', 'Api\FollowController@follow');
Route::get('company/followers', 'Api\FollowController@followers');
Route::get('company/following', 'Api\FollowController@following');
Route::post('company/rate', 'Api\RatingController@rate');









/*
|--------------------------------------------------------------------------
| Companies API Routes
|--------------------------------------------------------------------------
*/

Route::get('companies', 'Api\CompanyController@companies');
Route::get('company/profile', 'Api\CompanyController@profile');
Route::get('company/delete', 'Api\CompanyController@destroy')->middleware('auth:api');
Route::post('company/update', 'Api\CompanyController@update')->middleware('auth:api');





/*
|--------------------------------------------------------------------------
| Customers API Routes
|--------------------------------------------------------------------------
*/

Route::get('customers', 'Api\CustomerController@customers');
Route::get('customer/profile', 'Api\CustomerController@profile');
Route::get('customer/delete', 'Api\CustomerController@destroy')->middleware('auth:api');
Route::post('customer/update', 'Api\CustomerController@update')->middleware('auth:api');



/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
// Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')
//     ->name('api.passport.token');
// Route::post('admin/login', 'Api\AdminController@login');
// Route::get('admin/logout', 'Api\AdminController@logout')->middleware('auth:api');
// Route::post('admin/password/change', 'Api\AdminController@change_password')->middleware('auth:api');
// Route::get('admin/show', 'Api\AdminController@show')
//         ->middleware(['auth:api']);


// Route::post('admin/create', 'Api\AdminController@createAdmin');
// Route::post('admin/user/create', 'Api\AdminController@userCreate');
// Route::post('admin/company/update', 'Api\CompanyController@update');
// Route::post('admin/customer/update', 'Api\CustomerController@update');
// Route::post('admin/user/change', 'Api\AdminController@user_change_password');
// Route::post('admin/company/ban', 'Api\AdminController@companyBan');
// Route::post('admin/customer/ban', 'Api\AdminController@customerBan');
// Route::post('admin/admin/ban', 'Api\AdminController@customerBan');
// Route::get('admin/users', 'Api\AdminController@users');
// Route::get('admin/admins', 'Api\AdminController@admins');
// Route::get('admin/profile', 'Api\AdminController@profile');
// Route::get('admin/profile/own', 'Api\AdminController@show');
// Route::post('admin/profile/update', 'Api\AdminController@update');







//Product-Part->middleware('auth:api');

Route::get('products', 'Api\ProductController@index');
Route::post('product/create', 'Api\ProductController@store')->middleware('auth:api');
Route::post('product/update', 'Api\ProductController@update')->middleware('auth:api');
Route::get('product/show', 'Api\ProductController@show');
Route::get('product/delete', 'Api\ProductController@destroy')->middleware('auth:api');
Route::post('product/image/upload', 'Api\ProductController@uploadImage')->middleware('auth:api');
Route::post('product/image/setpriority', 'Api\ProductController@setPriority')->middleware('auth:api');
Route::get('product/image/delete', 'Api\ProductController@deleteImage')->middleware('auth:api');




//Category
Route::get('categories', 'Api\CategoryController@index');
Route::post('category/create', 'Api\CategoryController@store')->middleware('auth:api');
Route::post('category/update', 'Api\CategoryController@update')->middleware('auth:api');
Route::get('category/show', 'Api\CategoryController@show');
Route::get('category/delete', 'Api\CategoryController@destroy')->middleware('auth:api');




//Subcategory
Route::get('subcategories', 'Api\SubcategoryController@index');
Route::post('subcategory/create', 'Api\SubcategoryController@store')->middleware('auth:api');
Route::post('subcategory/update', 'Api\SubcategoryController@update')->middleware('auth:api');
Route::get('subcategory/show', 'Api\SubcategoryController@show');
Route::get('subcategory/delete', 'Api\SubcategoryController@destroy')->middleware('auth:api');



//Unit
Route::get('units', 'Api\UnitController@index');
Route::post('unit/create', 'Api\UnitController@store')->middleware('auth:api');
Route::post('unit/update', 'Api\UnitController@update')->middleware('auth:api');
Route::get('unit/show', 'Api\UnitController@show');
Route::get('unit/delete', 'Api\UnitController@destroy')->middleware('auth:api');





//Division
Route::get('divisions', 'Api\DivisionController@index');
// Route::post('division/create', 'Api\DivisionController@store');
// Route::post('division/update', 'Api\DivisionController@update');
Route::get('division/show', 'Api\DivisionController@show');
// Route::get('division/delete', 'Api\DivisionController@destroy');




//District
Route::get('districts', 'Api\DistrictController@index');
// Route::post('district/create', 'Api\DistrictController@store');
// Route::post('district/update', 'Api\DistrictController@update');
Route::get('district/show', 'Api\DistrictController@show');
// Route::get('district/delete', 'Api\DistrictController@destroy');





//Upazilla
Route::get('upazillas', 'Api\UpazillaController@index');
// Route::post('upazilla/create', 'Api\UpazillaController@store');
// Route::post('upazilla/update', 'Api\UpazillaController@update');
Route::get('upazilla/show', 'Api\UpazillaController@show');
// Route::get('upazilla/delete', 'Api\UpazillaController@destroy');





//News
Route::get('news', 'Api\NewsController');

//Blogs
Route::get('blogs', 'Api\BlogController');





//Union
Route::get('unions', 'Api\UnionController@index');
Route::get('union/show', 'Api\UnionController@show');




Route::get('/get-categories', function (Request $request) {
    $categories = App\Models\Category::orderBy('bn_name', 'ASC')->get();
    foreach ($categories as $category) {
        $category->subcategories;
    }
    return response()->json([
        "success"  => true,
        "categories" =>$categories,
    ]);
});

Route::get('/get-subcategories', function (Request $request) {
    return response()->json([
        "success"  => true,
        "subcategories" =>App\Models\Subcategory::where('category_id', $request->id)->orderBy('bn_name', 'ASC')->get(),
    ]);
});
Route::get('/get-districts', function (Request $request) {
    return response()->json([
        "success"  => true,
        "districts" =>App\Models\District::where('division_id', $request->id)->orderBy('bn_name', 'ASC')->get(),
    ]);
});
Route::get('/get-upazillas', function (Request $request) {
    return response()->json([
        "success"  => true,
        "upazillas" =>App\Models\Upazilla::where('district_id', $request->id)->orderBy('bn_name', 'ASC')->get(),
    ]);
});
Route::get('/get-unions', function (Request $request) {
    return response()->json([
        "success"  => true,
        "unions" =>App\Models\Union::where('upazilla_id', $request->id)->orderBy('bn_name', 'ASC')->get(),
    ]);
});








/*
|--------------------------------------------------------------------------
| Search API Routes
|--------------------------------------------------------------------------
*/
Route::get('product-search', 'Api\SearchController@productSearch');
Route::get('company-search', 'Api\SearchController@companySearch');
Route::get('search-by-type', 'Api\SearchController@searchByType');
Route::get('product-by-type', 'Api\SearchController@productByType');
Route::get('company-by-type', 'Api\SearchController@companyByType');
Route::get('company-by-location', 'Api\SearchController@companyByLocation');
Route::get('product-by-location', 'Api\SearchController@productByLocation');
Route::get('company-by-subcategory', 'Api\SearchController@companyBySubcategory');




/*
|--------------------------------------------------------------------------
| Notification API Routes
|--------------------------------------------------------------------------
*/
Route::get('user-notifications', 'Api\NotificationController@AllNotifications')->middleware('auth:api');;
Route::get('read-one-notification', 'Api\NotificationController@ReadOne')->middleware('auth:api');;
Route::get('delete-one-notification', 'Api\NotificationController@DeleteOne')->middleware('auth:api');;
Route::get('delete-read-notifications', 'Api\NotificationController@DeleteAlreadyRead')->middleware('auth:api');;
Route::get('delete-all-notifications', 'Api\NotificationController@DeleteAll')->middleware('auth:api');;
Route::get('read-all-notifications', 'Api\NotificationController@ReadAll')->middleware('auth:api');;
