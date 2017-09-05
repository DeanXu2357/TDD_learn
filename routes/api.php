<?php

use Illuminate\Http\Request;
use App\Models\Fruits;

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/', function () {
        return ['Fruits' => 'Delicious and healthy!'];
    });

    // $api->get('/fruits', function () {
    //     return ['data' => Fruits::all()];
    // });

    $api->get('/fruits', 'App\Http\Controllers\FruitsController@index');
    $api->get('/fruit/{name}', 'App\Http\Controllers\FruitsController@show');

    # 認證使用者API
    $api->post('authenticate', 'App\Http\Controllers\AuthenticateController@authenticate');
    $api->post('logout', 'App\Http\Controllers\AuthenticateController@logout');
    $api->get('token', 'App\Http\Controllers\AuthenticateController@getToken');
});

// todo 之後試著用$api->group()改寫放在上面
$api->version('v1', ['middleware' => 'api.auth'], function ($api) {
    $api->get('authenticated_user', 'App\Http\Controllers\AuthenticateController@authenticatedUser');
    $api->post('fruits', 'App\Http\Controllers\FruitsController@store');
    $api->delete('fruits/{id}', 'App\Http\Controllers\FruitsController@destroy');
});
