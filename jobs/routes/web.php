<?php
header('Access-Control-Allow-Origin: *');
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
//
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['auth.shop'])->name('home');

Route::get('/testcode', 'AppController@testcode')->name('testcode');

Route::post('/discountset_job', 'AppController@discountset_job')->name('discountset_job');
Route::post('/checkmetafields_job', 'AppController@checkmetafields_job')->name('checkmetafields_job');
Route::post('/includesnippets_job', 'AppController@includesnippets_job')->name('includesnippets_job');

Route::post('/find_product_title', 'AppController@find_product_title')->name('find_product_title');
Route::get('/find_product', 'AppController@find_product_title')->name('find_product');
Route::get('/GetProducts', 'AppController@GetProducts')->name('GetProducts');
Route::Post('/SaveData', 'AppController@SaveData')->name('SaveData');
Route::post('DeleteDiscountSet', 'AppController@DeleteDiscountSet')->name('DeleteDiscountSet');

Route::get('GetProductDiscountSet', 'AppController@GetProductDiscountSet')->name('GetProductDiscountSet');
Route::post('ProcessDiscountSet', 'AppController@ProcessDiscountSet')->name('ProcessDiscountSet');
Route::get('ProcessDeleteDicountSet', 'AppController@ProcessDeleteDicountSet')->name('ProcessDeleteDicountSet');
Route::get('GetDiscountSetProducts', 'AppController@GetDiscountSetProducts')->name('GetDiscountSetProducts');

Route::post('GetCartPrices', 'ApiController@GetCartPrices')->name('GetCartPrices');


Route::get('customer_pricing.js', 'ApiController@customer_pricing')->name('customer_pricing');
Route::get('csp_install_check.js', 'ApiController@csp_install_check')->name('csp_install_check');
Route::get('cspqb.js', 'ApiController@cspqb')->name('cspqb');


Route::get('GetProductDiscount', 'ApiController@GetProductDiscount')->name('GetProductDiscount');
Route::get('get_qb_discount_banner_data', 'ApiController@get_qb_discount_banner_data')->name('get_qb_discount_banner_data');

Route::post('CreateDraftOrder', 'ApiController@CreateDraftOrder')->name('CreateDraftOrder');
