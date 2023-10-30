<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\User;

// $router->get('a',function(){
//     dd(User::create([
//         'fullName' => 'zahra',

//     ]));
// });

$router->group(['prefix'=>'api/v1'], function () use ($router) {
    $router->group(['prefix'=>'users'], function () use ($router) {
        $router->get('find', 'API\V1\UsersController@remove');
        $router->post('', 'API\V1\UsersController@store');
        $router->put('', 'API\V1\UsersController@updateInfo');
        $router->put('change-password', 'API\V1\UsersController@updatePassword');
        $router->DELETE('', 'API\V1\UsersController@remove');
        $router->get('', 'API\V1\UsersController@index');
        
    });
    $router->group(['prefix'=> 'categories'], function () use ($router) {
        $router->post('', 'API\V1\CategoriesController@store');
        $router->DELETE('', 'API\V1\CategoriesController@remove');
        $router->put('', 'API\V1\CategoriesController@updateInfo');
        $router->get('', 'API\V1\CategoriesController@index');
    });

    $router->group(['prefix'=> 'quizzes'], function () use ($router) {
        $router->post('', 'API\V1\QuizzesController@store');
        $router->DELETE('', 'API\V1\QuizzesController@remove');
        // $router->put('', 'API\V1\CategoriesController@updateInfo');
        // $router->get('', 'API\V1\CategoriesController@index');
    });

       
});
