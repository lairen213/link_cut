<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;

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

Route::get('/', function () {
    return view('main');
});//Main page, where you can cut links

Route::post('create_link', [LinkController::class, 'createLink'])->name('create.link');
Route::get('{link_slug}', [LinkController::class, 'redirectToLink'])->name('redirect.to.link');//Page that's redirect to original addresses of cutted links
