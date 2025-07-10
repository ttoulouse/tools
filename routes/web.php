<?php

use App\Mail\feivendorpo;
use App\Mail\abqvendorpo;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/cms/gcal', 'CMSController@gcal');

Route::get('/orders', 'OrdersController@index');
Route::get('/orders/issues', 'OrdersController@issues');

Route::get('/orders/{id}', 'OrdersController@show');

Route::get('/find/orders', 'OrdersController@find');

Route::post('/find/orders/search', 'OrdersController@returnorder');

Route::post('orders/{OrderID}/po','OrdersController@createpo');
Route::post('orders/{OrderID}/{PONum}/edit','OrdersController@editpo');
Route::post('orders/{OrderID}/{PONum}/update','OrdersController@updatepo');

Route::get('/stock/update', 'StockController@update');
Route::get('/stock/find', 'StockController@find');
Route::get('/stock/find/vendor', 'StockController@findvendor');
Route::get('/stock/find/po', 'StockController@findpo');
Route::get('/stock/returnstock/{id}', 'StockController@show');
Route::get('/stock/openpos', 'StockController@openpos');
Route::get('/stock/{id}', 'StockController@invoiceitem');

Route::get('/inquiry/find/item', 'InquiryController@finditem');
Route::get('/inquiry/find/itemsales', 'InquiryController@itemsales');
Route::get('/inquiry/find/vendor', 'InquiryController@findvendor');
Route::get('/inquiry/find/povendor', 'InquiryController@pofindvendor');
Route::get('/inquiry/find/item/{id}', 'InquiryController@showitem');

Route::post('/inquiry/find/item', 'InquiryController@returnitem');
Route::post('/inquiry/find/itemsales', 'InquiryController@returnitemsales');
Route::post('/inquiry/find/vendor', 'InquiryController@returnvendor');
Route::post('/inquiry/find/povendor', 'InquiryController@poreturnvendor');


Route::post('stock/update/change','StockController@change');
Route::post('stock/find/search','StockController@returnstock');
Route::post('stock/find/vendor','StockController@returnvendor');
Route::post('stock/find/po','StockController@returnpo');
Route::post('/stock/createpo', 'StockController@createpo');
Route::post('/stock/editpo', 'StockController@editpo');
Route::post('/stock/{id}', 'StockController@saveinvoice');

Route::get('/po/noinv', 'POController@noinv');
Route::get('/po/partialinv', 'POController@partialinv');
Route::get('/po/find', 'POController@find');
Route::get('/po/cusfind', 'POController@cusfind');
Route::get('/po/salesfind', 'POController@salesfind');
Route::get('/po/find/vendor', 'POController@findvendor');

Route::get('/po/find/search/{id}', 'POController@returnpoget');
Route::post('/po/find/search', 'POController@returnpo');
Route::post('/po/find/cussearch', 'POController@cusreturnpo');
Route::post('/po/find/salessearch', 'POController@salesreturnpo');
Route::post('/po/shipped/{PONum}', 'POController@shipped');
Route::post('/po/find/returnvendor', 'POController@returnvendor');

Route::get('/vendor/createrule/{vendor}', 'VendorController@createrule');
Route::get('/vendor/editvendor/{vendor}', 'VendorController@editvendor2');
Route::get('/vendor/findvendor', 'VendorController@findvendor');
Route::get('/vendor/search', 'VendorController@search');
Route::get('/vendor/createvendor','VendorController@createvendor');
Route::get('/vendor/editvendor','VendorController@editvendor');
Route::post('/vendor/findvendor', 'VendorController@returnvendorlist');
Route::post('/vendor/createrule', 'VendorController@saverule');
Route::post('/vendor/editrule', 'VendorController@editrule');
Route::post('/vendor/search', 'VendorController@returnvendor');
Route::post('/vendor/createvendor','VendorController@savevendor');
Route::post('/vendor/savevendor/{vendor}','VendorController@savevendor2');

Route::post('/reports/tax', 'ReportsController@tax');
Route::get('/reports/tax/date', 'ReportsController@taxdate');
Route::get('/reports/open', 'ReportsController@open');

Route::post('/product/findvendor', 'ProductController@returnvendor');
Route::post('/product/vendor/update/{vendor}', 'ProductController@updatevendor');
Route::post('/product/bulkdiscontinue', 'ProductController@uploaddiscontinue');

Route::get('/product/findvendor', 'ProductController@findvendor');
Route::get('/product/findcode', 'ProductController@findcode');
Route::get('/product/vendor/{vendor}', 'ProductController@vendor');
Route::get('/product/bulkdiscontinue', 'ProductController@bulkdiscontinue');

Route::group([
    'middleware' => ['auth', 'admin'],
    'prefix' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('/users', 'UserManagementController@index')->name('admin.users.index');
    Route::get('/users/create', 'UserManagementController@create')->name('admin.users.create');
    Route::post('/users', 'UserManagementController@store')->name('admin.users.store');
    Route::delete('/users/{user}', 'UserManagementController@destroy')->name('admin.users.destroy');
    Route::get('/users/{id}/edit', 'UserManagementController@edit')->name('admin.users.edit');
    Route::put('/users/{id}', 'UserManagementController@update')->name('admin.users.update');

});


Route::get('/mail', 'POController@mailview');

Route::post('/po/archive/{ponum}', 'POController@archive')->name('po.archive');

Route::get('/po/feimail', function () {

	\Config::set('services.mailgun.domain', 'factory-express.com');
	\Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');

	Mail::to('trentt@factory-express.com')->send(new feivendorpo);
});

Route::get('/po/abqmail', function () {

	\Config::set('services.mailgun.domain', 'factory-express.com');
	\Config::set('services.mailgun.secret', 'key-69748ac1f479af654aa6aa5caacc3cd2');
	Mail::to('trentt@factory-express.com')->send(new abqvendorpo);
});


