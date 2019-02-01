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
Route::get('/','MerchandiseController@indexPage');

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
        //FB登入
        Route::get('/facebook-sign-in','UserAuthController@facebookSignInProcess');
        //FB登入重新導向授權資料處理
        Route::get('/facebook-sign-in-callback','UserAuthController@facebookSignInCallbackProcess');
    });
});

//商品
Route::group(['prefix' => 'merchandise'],function (){
    //商品清單
    Route::get('/', 'MerchandiseController@merchandiseListPage');
    //商品新增
    Route::get('/create', 'MerchandiseController@merchandiseCreateProcess')->middleware(['user.auth.admin']);
    //商品管理清單
    Route::get('/manage', 'MerchandiseController@merchandiseManageListPage')->middleware(['user.auth.admin']);
    //指定商品
    Route::group(['prefix' => '{merchandise_id}'],function (){
        //商品單品檢視
        Route::get('/', 'MerchandiseController@merchandiseItemPage');
        Route::group(['middleware' => ['user.auth.admin']],function (){
            //商品單品頁面檢視
            Route::get('/edit', 'MerchandiseController@merchandiseItemEditPage');
            //商品單品修改
            Route::put('/', 'MerchandiseController@merchandiseItemUpdateProcess');
        });
        //購買商品
        Route::post('/buy', 'MerchandiseController@merchandiseItemBuyProcess')->middleware(['user.auth']);
    });
});


// 交易
Route::get('/transaction', 'TransactionController@transactionListPage');