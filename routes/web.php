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

Auth::routes(['register'=>false]);

Route::get('/',function (){
    return redirect("/".app()->getLocale());
});
Route::get("/ar","IndexController@index");

Route::group(['prefix'=>'admin','middleware'=>'auth:web'],function (){
    Route::get('/','Admin\IndexController@index');
    /*****************Slider*************************/

    Route::group(['permission:view_slider'],function (){
        Route::get('/slider','Admin\SliderContentController@index');
        Route::post('/save/slider','Admin\SliderContentController@create');
        Route::post("/slider/{id}/update",'Admin\SliderContentController@update');
        Route::post("/slider/{id}/delete",'Admin\SliderContentController@delete');
        Route::post("/slider/{id}",'Admin\SliderContentController@show');
    });

    /******************Services **********************/

    Route::group(['permission:view_services'],function (){
        Route::get('/services','Admin\ServicesController@index');
        Route::post('/save/services','Admin\ServicesController@create');
        Route::post("/service/{id}/delete",'Admin\ServicesController@delete');
        Route::post("/service/{id}",'Admin\ServicesController@show');
        Route::post("/service/{id}/update","Admin\ServicesController@update");
    });
    /***************************News************************/
    Route::group(['permission:view_news'],function (){
        Route::get('/news',"Admin\NewsController@index");
        Route::post('/save/news','Admin\NewsController@create');
        Route::post("/news/{id}/delete",'Admin\NewsController@delete');
        Route::post("/news/{id}",'Admin\NewsController@show');
        Route::post("/news/{id}/update","Admin\NewsController@update");
    });

    /**********************Messages************************/
   Route::group(['permission:view_messages'],function (){
       Route::get('/messages','Admin\MessageController@index');
       Route::post("/message/{id}/delete",'Admin\MessageController@delete');
   });


    /********************Permission*************/
    Route::group(['middleware'=>'permission:super_admin'],function (){
        Route::get("/permissions",'Admin\PermssionController@index');
        Route::get('/permission/{id}',['uses'=>'Admin\PermssionController@getPermission']);
        Route::post('/permission/set',['uses'=>'Admin\PermssionController@setPermission']);
    });
    /******************System constant*******************/

    Route::group(['middleware'=>'permission:system_constant'],function (){
        Route::get('/system/constant',"Admin\SystemController@index");
        Route::post('/system/constant/all',"Admin\SystemController@getConstant");
        Route::post('/system/save',"Admin\SystemController@saveConstant");
    });

    /*********************Courses**********************/
    Route::group(['middleware'=>'permission:view_courses'],function (){
        Route::get('/courses','Admin\CoursesController@index');
        Route::post("/save/courses",'Admin\CoursesController@create');
        Route::post("/course/{id}","Admin\CoursesController@show");
        Route::post("/course/{id}/update","Admin\CoursesController@update");
        Route::post("/course/{id}/delete","Admin\CoursesController@delete");
    });


    /***********************Orders************************/
    Route::group(['middleware'=>'permission:view_courses'],function (){
        Route::get('/orders','Admin\OrdersController@index');
        Route::post('/orders/{id}/delete',"Admin\OrdersController@delete");
    });

   /****************profile********************/
    Route::get("/profile","admin\profileController@index");
    Route::post('/profile/update',"admin\profileController@update");
    /*****************************************/
    Route::post("/courses/type","Admin\SystemController@getType");
});
