<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function ($router) {
    // USERS
    $router->get('user/{userId}', 'UserController@showOneUser');

    $router->post('user/register', 'UserController@register');
    $router->post('user/login', 'UserController@login');

    $router->put('user/isActive', 'UserController@updateUserisActive');


    // PERSONAL INFO
    $router->get('personalInfo', 'PersonalInfoController@showAllPersonalInfo');
    $router->get('personalInfo/{userId}', 'PersonalInfoController@showOnePersonalInfo');

    $router->post('personalInfo', 'PersonalInfoController@addPersonalInfo');

    $router->put('personalInfo', 'PersonalInfoController@updatePersonalInfo');

    $router->delete('personalInfo/{personalInfoId}', 'PersonalInfoController@deletePersonalInfo');

    // WORK HISTORY
    $router->get('workHistory', 'WorkHistoryController@showAllWorkHistory');
    $router->get('workHistory/{workHistoryId}', 'WorkHistoryController@showOneWorkHistory');

    $router->post('workHistory', 'WorkHistoryController@addWorkHistory');

    $router->put('workHistory', 'WorkHistoryController@updateWorkHistory');

    $router->delete('workHistory/{workHistoryId}', 'WorkHistoryController@deleteWorkHistory');

    // EDUCATIONAL BACKGROUND
    $router->get('educationBG', 'EducationBGController@showAllEducationBG');
    $router->get('educationBG/{educationId}', 'EducationBGController@showOneEducationBG');

    $router->post('educationBG', 'EducationBGController@addEducationBG');

    $router->put('educationBG', 'EducationBGController@updateEducationBG');

    $router->delete('educationBG/{educationId}', 'EducationBGController@deleteEducationBG');

    // CHARACTER REFERENCES
    $router->get('characterRef', 'CharacterRefController@showAllCharacterRef');
    $router->get('characterRef/{charRefId}', 'CharacterRefController@showOneCharacterRef');

    $router->post('characterRef', 'CharacterRefController@addCharacterRef');

    $router->put('characterRef', 'CharacterRefController@updateCharacterRef');

    $router->delete('characterRef/{charRefId}', 'CharacterRefController@deleteCharacterRef');
});
