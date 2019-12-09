<?php

use App\Events\TemperatureUpdateEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


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


Route::resource('/attend', 'AttendanceController');

Route::resource('/temperature', 'TemperatureController');

Route::resource('/student', 'StudentController');

Route::resource('/faculty', 'FacultyController');

Route::resource('/user', 'UserController');

Route::resource('/register', 'RegisterController')->except([
    'edit'
]);;

Route::resource('/lesson', 'LessonController');

Route::resource('/lights', 'LightingController');

Route::resource('/emotion', 'EmotionController');

Route::resource('/user', 'UserController');

Route::resource('/venue', 'VenueController');

Route::resource('/replacement', 'ReplacementController');

Route::get('/test', 'RegisterController@checkAttend');

//Route::get('/venue', function (Request $request)
//{
//   $temperature = $request->input('temperature');
//    event(new TemperatureUpdateEvent($temperature));
//    return Response::make('Updated!');
//});

