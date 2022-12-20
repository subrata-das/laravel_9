<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\TaskSearchControllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->name('Api.V1.')->group(function () {
    Route::apiResource('task', TaskController::class);
    Route::post('/search/byTitle', [TaskSearchControllers::class, 'byTitle']);
    Route::post('/search/byDueDate', [TaskSearchControllers::class, 'byDueDate']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Not found'
    ], 404);
})->name('api.fallback');