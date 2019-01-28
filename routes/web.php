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

/*Route::get('/', function () {
    return view('welcome');
});*/

//首頁
Route::get('/','HomeController@indexPage');

//使用者
Route::group(['prefix' => 'user'],function (){
    Route::group(['prefix' => 'auth'],function (){
        //顯示使用者註冊頁面
        Route::get('/sign-up', 'UserAuthController@signUpPage');
        //處理使用者註冊
        Route::post('/sign-up', 'UserAuthController@signUpProcess');
        //顯示使用者登入頁面
        Route::get('/sign-in', 'UserAuthController@signInPage');
        //使用者登入處理
        Route::post('/sign-in', 'UserAuthController@signInProcess');
        //使用者登入
        Route::get('/sign-out', 'UserAuthController@signOut');
    });
});

//商品
Route::group(['prefix' => 'merchandise'],function (){
    Route::get('/', 'MerchandiseController@merchandiseListPage');
    Route::get('/create', 'MerchandiseController@merchandiseCreateProcess');
    Route::get('/manage', 'MerchandiseController@merchandiseManageListPage');
    Route::group(['prefix' => '{merchandise_id}'],function (){
        Route::get('/', 'MerchandiseController@merchandiseItemPage');
        Route::get('/edit', 'MerchandiseController@merchandiseItemEditPage');
        Route::put('/', 'MerchandiseController@merchandiseItemUpdateProcess');
        Route::post('/buy', 'MerchandiseController@merchandiseItemBuyProcess');
    });
});


// 交易
Route::get('/transaction', 'TransactionController@transactionListPage');