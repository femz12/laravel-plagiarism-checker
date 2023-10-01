<?php

use DavidO\PGChecker\PGChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('api/plagiarism/webhook/{status}/{token}', function (Request $request, $status, $token) {
    return (new PGChecker)->saveResult($request, $status, $token);
});
