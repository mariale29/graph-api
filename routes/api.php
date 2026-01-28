<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/nodes', [NodeController::class, 'index']);
Route::post('/nodes', [NodeController::class, 'store']);
Route::get('/parent', [NodeController::class, 'getParent']);
Route::get('/children/{node}', [NodeController::class, 'getChildren']);
Route::delete('/nodes/{node}', [NodeController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
