<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');


Route::get('password/reset','Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
//Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
//Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/signin', ['as' => 'login', 'uses' => 'HomeController@signin']);
Route::get('/signup', ['as' => 'signup', 'uses' => 'HomeController@signup']);
Route::post('/signup/store', ['as' => 'signup_save', 'uses' => 'HomeController@signupSave']);
Route::post('/submitted', ['as' => 'cached', 'uses' => 'HomeController@tempSave']);
//Route::post('/submitted', ['as' => 'cached', 'uses' => 'HomeController@tempSave']);
Route::get('/success', ['as' => 'success', 'uses' => 'HomeController@SignUpSuccess']);

Route::get('/ticker', ['as' => 'home', 'uses' => 'HomeController@ticker']);
Route::get('/first-run', ['as' => 'home', 'uses' => 'HomeController@first_run']);
Route::get('/daily-update', ['as' => 'home', 'uses' => 'HomeController@daily_update']);
Route::get('/fetch', ['as' => 'home', 'uses' => 'HomeController@fetch']);
//Route redirecting to Youtube Videos
Route::get('/knowledge-center/videos', ['as' => 'videos', 'uses' => 'HomeController@videos']);

Route::post('/uniqueemail', ['as' => 'uniqueemail', 'uses' => 'HomeController@validateEmail']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
Route::post('auth', ['as' => 'auth', 'uses' => 'HomeController@auth']);

Route::get('stocks', 'DashboardController@getStocks');

//Route::group(['prefix' => 'portal','middleware' => ['web']], function () {
Route::group(['prefix' => 'portal','middleware' => ['auth']], function () {

    Route::auth();

//    Route::get('/', function ()    {
//        // Uses Auth Middleware
//        return view('roboplanner.dashboard');
//    });

    Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('/spreadsheet', ['as' => 'spreadsheet', 'uses' => 'DashboardController@spreadsheet']);

    Route::get('/algo_values', ['as' => 'algo_values', 'uses' => 'DashboardController@algo_values']);
    // Clients
//    Route::group(['prefix' => 'clients', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'clients', 'middleware'],function(){
        Route::get('/', ['as' => 'clients', 'uses' => 'ClientController@index']);
        Route::get('/profile/{id}', ['as' => 'client_profile', 'uses' => 'ClientController@profile']);
        Route::get('/edit/{id}', ['as' => 'client_edit', 'uses' => 'ClientController@edit']);
        Route::get('/update/{id}', ['as' => 'client_update', 'uses' => 'ClientController@update']);
        Route::get('/delete/{id}', ['as' => 'client_destroy', 'uses' => 'ClientController@destroy']);
        Route::get('/dashboard/{id?}', ['as' => 'dashboard_show', 'uses' => 'DashboardController@dashboard_show']);
    });

    //
    Route::get('/logout', ['as' => 'logout', 'uses' => 'HomeController@logout']);
//    Route::group(['prefix' => 'permissions', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'permissions', 'middleware'],function(){
        Route::get('/', ['as' =>'permission_list', 'uses' => 'PermissionController@index']);
        Route::get('/add', ['as' =>'permission_add', 'uses' => 'PermissionController@create']);
        Route::post('/store', ['as' =>'permission_store', 'uses' => 'PermissionController@store']);
        Route::get('/edit/{id}', ['as' =>'permission_edit', 'uses' => 'PermissionController@edit']);
        Route::post('/update/{id}', ['as' =>'permission_update', 'uses' => 'PermissionController@update']);
        Route::get('/delete/{id}',	['as' =>'permission_delete',    'uses' => 'PermissionController@destroy']);
    });


//    Route::group(['prefix' => 'roles', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'roles', 'middleware'],function(){
        Route::get('/', ['as' =>'role_list', 'uses' => 'RoleController@index']);
        Route::get('/add', ['as' =>'role_add', 'uses' => 'RoleController@create']);
        Route::post('/store', ['as' =>'role_store', 'uses' => 'RoleController@store']);
        Route::get('/edit/{id}', ['as' =>'role_edit', 'uses' => 'RoleController@edit']);
        Route::post('/update/{id}', ['as' =>'role_update', 'uses' => 'RoleController@update']);
        Route::get('/delete/{id}',	['as' =>'role_delete',    'uses' => 'RoleController@destroy']);
    });

    Route::group(['prefix' => 'categories', 'middleware'],function(){
        Route::get('/', ['as' =>'category_list', 'uses' => 'CategoryController@index']);
        Route::get('/add', ['as' =>'category_add', 'uses' => 'CategoryController@create']);
        Route::post('/store', ['as' =>'category_store', 'uses' => 'CategoryController@store']);
        Route::get('/edit/{id}', ['as' =>'category_edit', 'uses' => 'CategoryController@edit']);
        Route::post('/update/{id}', ['as' =>'category_update', 'uses' => 'CategoryController@update']);
        Route::get('/delete/{id}',	['as' =>'category_delete',    'uses' => 'CategoryController@destroy']);
    });

    Route::group(['prefix' => 'values', 'middleware'],function(){
        Route::get('/', ['as' =>'value_list', 'uses' => 'ValueController@index']);
        Route::get('/add', ['as' =>'value_add', 'uses' => 'ValueController@create']);
        Route::post('/store', ['as' =>'value_store', 'uses' => 'ValueController@store']);
        Route::post('/set', ['as' =>'value_set', 'uses' => 'ValueController@set']);
        Route::get('/all_values', ['as' =>'all_values', 'uses' => 'ValueController@all_values']);
        Route::get('/edit/{id}', ['as' =>'value_edit', 'uses' => 'ValueController@edit']);
        Route::post('/update/{id}', ['as' =>'value_update', 'uses' => 'ValueController@update']);
        Route::any('/check_unique_name', ['as' =>'check_unique_name', 'uses' => 'ValueController@checkUniqueName']);
        Route::get('/delete/{id}',  ['as' =>'value_delete',    'uses' => 'ValueController@destroy']);
    });


//    Route::group(['prefix' => 'users', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'users', 'middleware'],function(){
        Route::get('/',['as' => 'users', 'uses' => 'UserController@index']);
        Route::get('/create',['as' => 'user_create', 'uses' => 'UserController@create']);
        Route::get('/edit/{id}',['as' => 'user_edit', 'uses' => 'UserController@edit']);

        Route::post('/store',['as' => 'user_store', 'uses' => 'UserController@save']);
        Route::post('/update/{id}',['as' => 'user_update', 'uses' => 'UserController@save']);
        Route::get('/delete/{id}',['as' => 'user_destroy', 'uses' => 'UserController@destroy']);

        Route::get('/profile/{id?}',['as' => 'user_show', 'uses' => 'UserController@show']);

        Route::post('/client_template',['as' => 'client_template', 'uses' => 'UserController@client_template']);

        Route::post('/meta_update/{id}',['as' => 'meta_update', 'uses' => 'UserController@meta_update']);

        Route::post('/assign_role/{id}',['as' => 'user_assign_role', 'uses' => 'UserController@assign_role']);

//        Route::get('/dashboard/{id?}', ['as' => 'dashboard_show', 'uses' => 'DashboardController@dashboard_show']);

    });

    Route::group(['prefix' => 'flags', 'middleware'],function(){
        Route::get('/',['as' => 'flags', 'uses' => 'FlagController@index']);
        Route::get('/create',['as' => 'flags_create', 'uses' => 'FlagController@create']);
        Route::post('/store',['as' => 'flags_store', 'uses' => 'FlagController@store']);
        Route::get('/edit/{id}',['as' => 'flags_edit', 'uses' => 'FlagController@edit']);
        Route::post('/update/{id}',['as' => 'flags_update', 'uses' => 'FlagController@update']);
        Route::get('/delete/{id}', ['as' =>'flags_delete',    'uses' => 'FlagController@destroy']);
     });

//    Route::group(['prefix' => 'logs', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'logs', 'middleware' ],function(){
        Route::get('/',['as' => 'logs', 'uses' => 'LogController@index']);
        Route::get('/user/{id?}',['as' => 'user_logs', 'uses' => 'LogController@getUserLog']);
        Route::get('/delete_all/{id?}',['as' => 'delete_user_logs', 'uses' => 'LogController@deleteAll']);
        Route::get('/delete/{id?}',['as' => 'delete_log', 'uses' => 'LogController@delete']);
        Route::get('/delete_from_user/{id?}',['as' => 'delete_log_from_user', 'uses' => 'LogController@deleteFromUser']);
        Route::get('/clearlog',['as' => 'clear_logs', 'uses' => 'LogController@clearLog']);
    });
//    Route::group(['prefix' => 'page', 'middleware' => 'web'],function(){
    Route::group(['prefix' => 'page', 'middleware'],function(){
        Route::get('/',['as' => 'page', 'uses' => 'PageController@index']);
        Route::get('/create',['as' => 'page_create', 'uses' => 'PageController@create']);
        Route::post('/store',['as' => 'page_store', 'uses' => 'PageController@save']);
        Route::get('/edit/{id}',['as' => 'page_edit', 'uses' => 'PageController@edit']);
        Route::post('/update/{id}',['as' => 'page_update', 'uses' => 'PageController@update']);
        Route::get('/delete/{id}', ['as' =>'page_delete',    'uses' => 'PageController@destroy']);
    });

    Route::group(['prefix' => 'taxes', 'middleware' ],function(){
        Route::get('/',['as' => 'taxes', 'uses' => 'TaxController@index']);
        Route::get('/create',['as' => 'tax_create', 'uses' => 'TaxController@create']);
        Route::post('/store',['as' => 'tax_store', 'uses' => 'TaxController@store']);
        Route::get('/edit/{id}',['as' => 'tax_edit', 'uses' => 'TaxController@edit']);
        Route::post('/update/{id}',['as' => 'tax_update', 'uses' => 'TaxController@update']);
        Route::get('/delete/{id}', ['as' =>'tax_delete',    'uses' => 'TaxController@destroy']);
    });

    Route::group(['prefix' => 'post', 'middleware'],function(){
        Route::get('/',['as' => 'post', 'uses' => 'PostController@index']);
        Route::get('/create',['as' => 'post_create', 'uses' => 'PostController@create']);
        Route::post('/store',['as' => 'post_store', 'uses' => 'PostController@store']);
        Route::get('/edit/{id}',['as' => 'post_edit', 'uses' => 'PostController@edit']);
        Route::post('/update/{id}',['as' => 'post_update', 'uses' => 'PostController@update']);
        Route::get('/delete/{id}', ['as' =>'post_delete',    'uses' => 'PostController@destroy']);
    });
});

Route::post('/check_symbols',['as' => 'check_symbols','uses' => 'ClientController@checkSymbols']);
#Route::get('/post/{slug}', ['uses' => 'HomeController@getPost'])->where('slug', '([A-Za-z0-9\-\/]+)');
Route::get('/knowledge-center/blog', ['as' => 'blog', 'uses' => 'HomeController@blog']);
Route::get('/knowledge-center/blog/category/{slug}', ['as' => 'category', 'uses' => 'HomeController@blogCategory'])->where('slug', '([A-Za-z0-9\-\/]+)');
Route::get('/knowledge-center/blog/archive/{slug}', ['as' => 'archive', 'uses' => 'HomeController@blogArchive'])->where('slug', '([A-Za-z0-9\-\/]+)');
Route::get('/knowledge-center/blog/post/{slug}', ['as' => 'post_blog', 'uses' => 'HomeController@getBlogPost'])->where('slug', '([A-Za-z0-9\-\/]+)');

//Sub pages dynamic routes
Route::get('{slug}', ['uses' => 'HomeController@getPage'])->where('slug', '([A-Za-z0-9\-\/]+)');
//Post dynamic routes


