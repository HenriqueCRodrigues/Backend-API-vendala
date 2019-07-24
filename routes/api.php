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

Route::post('register','UserController@create');

Route::group(['prefix' => 'products', 'middleware' => ['auth:api', 'cors']], function($api)
{
    $api->post('insert', 'ProductController@insert');
    $api->post('all', 'ProductController@getAll');
    $api->delete('{id}/delete', 'ProductController@destroy');
    $api->get('{id}', 'ProductController@show');
    $api->post('{id}/update', 'ProductController@update');
});

