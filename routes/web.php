<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;


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

// Route::get('/', function () {
//     phpinfo();
// });
Route::get('/',[mainController::class,'mainDashboard'])->name('mainDashboard');
Route::get('showPrsInf',[mainController::class,'showPrsInf'])->name('showPrsInf');
Route:: post('RegPrsInf',[mainController::class,'RegPrsInf'])->name('RegPrsInf');
Route::post('updateUserInf',[mainController::class,'updateUserInf'])->name('updateUserInf');
Route::post('EnableDisableUser',[mainController::class,'EnableDisableUser'])->name('EnableDisableUser');
Route::post('DeleteUserTemp',[mainController::class,'DeleteUserTemp'])->name('DeleteUserTemp');
Route::post('RestoreUser',[mainController::class,'RestoreUser'])->name('RestoreUser');
Route::post('deletePermanently',[mainController::class,'deletePermanently'])->name('deletePermanently');
