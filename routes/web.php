<?php

use App\Models\ManageUrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ManageUrlController;
use Illuminate\Support\Facades\Auth;

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
    $urls = ManageUrl::all();
    return view('guest', ['urls' => $urls]);
});

Route::get('/dashboard', function () {
    $urls = ManageUrl::all();
    return view('dashboard', ['urls' => $urls]);
})->middleware(['auth'])->name('dashboard');

// Route::get('/admin/pages', function () {
//     return view('layouts.admin.admin');
// })->middleware(['auth'])->name('admin');

Route::get('/access-link', [ManageUrlController::class, 'accessLink']);

require __DIR__.'/auth.php';
