<?php

use App\Models\Price;
use App\Commands\SendingCommand;
use App\Http\Services\ParserService;
use App\Http\Services\GetFearService;
use App\Http\Services\SendingService;
use Illuminate\Support\Facades\Route;
use App\Http\Services\GetCourseService;
use App\Http\Services\SaveCourseService;
use App\Http\Services\DeleteCourseService;
use App\Http\Controllers\SetHookController;
use App\Http\Controllers\GetCourseController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/setWebhook', [SetHookController::class, 'setWebhook']);
// Route::get('/getCourse', [ParserService::class, 'parser']);


