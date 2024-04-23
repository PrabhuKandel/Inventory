<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranscationController;


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
// Route::get('products/{product_id}/warehouses/{warehouse_id}/availability',[TranscationController::class,'checkQuantity']);
Route::get('branchs/{branch_id}/products/{product_id}/warehouses/{warehouse_id}/availability',[TranscationController::class,'calculateAvailability']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
