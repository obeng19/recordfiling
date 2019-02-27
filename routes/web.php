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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['middleware'=> ['guest']], function() {

Route::get('/login', ['uses' => 'LoginController@getLogin', 'as' => 'login']);
Route::post('/login', ['uses' => 'LoginController@postLogin', 'as' => 'post_login']);
Route::get('/test', ['uses' => 'LoginController@gettest', 'as' => 'test']);
Route::get('/guest/{id}', ['uses' => 'FileController@subcat', 'as' => 'file.docs.guest']);
Route::post('/tab', ['uses' => 'LoginController@guest_table', 'as' => 'file.docs.show']);
    Route::get('/guest/download/{id}', ['uses' => 'LoginController@download', 'as' => 'file.guest.download']);



});

Route::group(['middleware'=> ['auth']], function() {

Route::get('/', ['uses' => 'DashboardController@goto_main_route', 'as' => 'app.home']);
Route::get('/dashboard', ['uses' => 'DashboardController@index', 'as' => 'app.dashboard']);
Route::match(['get', 'post'], '/change-password', ['uses' => 'DashboardController@password', 'as' => 'app.password']);
Route::get('/logout', ['uses' => 'DashboardController@logout', 'as' => 'app.logout']);


Route::middleware('can:view-system-settings')->group(function () {
    Route::prefix('regions')->group(function () {
        Route::get( 'index', ['uses' => 'RegionController@index', 'as' => 'settings.regions.index']);
        Route::match(['get', 'post'], 'create', ['uses' => 'RegionController@create', 'as' => 'settings.regions.create']);
        Route::match(['get', 'post'], 'edit/{id}', ['uses' => 'RegionController@edit', 'as' => 'settings.regions.edit']);
        Route::get('delete/{id}', ['uses' => 'RegionController@delete', 'as' => 'settings.regions.delete']);
    });
});

Route::middleware('can:view-system-settings')->group(function () {
    Route::prefix('category')->group(function () {
        Route::get( 'index', ['uses' => 'CategoryController@index', 'as' => 'settings.category.index']);
        Route::match(['get', 'post'], 'create', ['uses' => 'CategoryController@create', 'as' => 'settings.category.create']);
        Route::match(['get', 'post'], 'edit/{id}', ['uses' => 'CategoryController@edit', 'as' => 'settings.category.edit']);
        Route::get('delete/{id}', ['uses' => 'CategoryController@delete', 'as' => 'settings.category.delete']);
    });
});
Route::middleware('can:view-system-settings')->group(function () {
    Route::prefix('subcategory')->group(function () {
        Route::get( 'index', ['uses' => 'SubcategoryController@index', 'as' => 'settings.subcategory.index']);
        Route::match(['get', 'post'], 'create', ['uses' => 'SubcategoryController@create', 'as' => 'settings.subcategory.create']);
        Route::match(['get', 'post'], 'edit/{id}', ['uses' => 'SubcategoryController@edit', 'as' => 'settings.subcategory.edit']);
        Route::get('delete/{id}', ['uses' => 'SubcategoryController@delete', 'as' => 'settings.subcategory.delete']);
    });
});

    Route::middleware('can:view-management-users')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/index', ['uses' => 'UserController@index', 'as' => 'settings.management.user.index']);
            Route::get('/create/{id?}', ['uses' => 'UserController@create', 'as' => 'settings.management.user.create']);
//            Route::get('/hos/{id}', ['uses' => 'UserController@hos_get', 'as' => 'management.user.hos_get']);
            Route::post( '/create', ['uses' => 'UserController@store', 'as' => 'settings.management.user.store']);
            Route::get( '/edit/{id}', ['uses' => 'UserController@edit', 'as' => 'settings.management.user.edit']);
            Route::post( '/update/{id}', ['uses' => 'UserController@update', 'as' => 'settings.management.user.update']);
            Route::get( '/lock/{id}', ['uses' => 'UserController@lock', 'as' => 'settings.management.user.lock']);
            Route::get( '/delete/{id}', ['uses' => 'UserController@delete', 'as' => 'settings.management.user.delete']);


        });

    });
    Route::middleware('can:view-management-users')->group(function () {
        Route::prefix('role')->group(function () {
            Route::get( '/index', ['uses' => 'RoleController@index', 'as' => 'settings.management.role.index']);
            Route::match(['GET','POST'], '/create', ['uses' => 'RoleController@create', 'as' => 'settings.management.role.create']);
            Route::match(['GET','POST'], '/edit/{id}', ['uses' => 'RoleController@edit', 'as' => 'settings.management.role.edit']);


        });

    });
    Route::middleware('can:view-system-settings')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::match(['get', 'post'], '/create', ['uses' => 'RegionController@create', 'as' => 'settings.regions.create']);


        });
    });

    Route::middleware('can:view-activity-monitor')->group(function () {
        Route::prefix('audit')->group(function () {
            Route::get('/index', ['uses' => 'AuditTrailController@index', 'as' => 'report.audit.trail.index']);
        });

    });
    Route::middleware('can:view-file')->group(function () {
        Route::prefix('file')->group(function () {
            Route::get('/index', ['uses' => 'FileController@index', 'as' => 'file.docs.index']);
            Route::get('/download/{id}', ['uses' => 'FileController@download', 'as' => 'file.docs.download']);
            Route::get('/sub/{id}', ['uses' => 'FileController@subcat', 'as' => 'file.docs.get']);
            Route::get('/delete/{id}', ['uses' => 'FileController@delete', 'as' => 'file.docs.delete']);
            Route::get('/guest_see/{id}', ['uses' => 'FileController@guest_see', 'as' => 'file.docs.guest_see']);
            Route::match(['GET', 'POST'], '/create', ['uses' => 'FileController@create', 'as' => 'file.docs.create']);
            Route::match(['GET', 'POST'], '/edit/{id}', ['uses' => 'FileController@edit', 'as' => 'file.docs.edit']);

        });

    });
    Route::middleware('can:view-file-report')->group(function () {
        Route::prefix('report')->group(function () {
            Route::get('/index', ['uses' => 'FileReportController@index', 'as' => 'report.file.index']);
        });

    });
    Route::middleware('can:view-user-profile')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::get('/edit/{id}', ['uses' => 'ProfileController@edit', 'as' => 'profile.edit']);
            Route::post('/update/{id}', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);
        });
    });
    Route::middleware('can:view-system-permission')->group(function () {
        Route::prefix('permission')->group(function () {
            Route::match(['GET','POST'],'/create', ['uses' => 'PermissionController@create', 'as' => 'settings.permission.create']);
//            Route::post('/update/{id}', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);
        });
    });
});


