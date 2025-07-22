<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReportMail;

Route::get('/test-mail', function () {
    $name = 'Yuvan';
    $filePath = storage_path('app/test.pdf');

    // Create a dummy file if not present
    if (!file_exists($filePath)) {
        file_put_contents($filePath, 'This is a test PDF content.');
    }

    Mail::to('yuvansarran1001@gmail.com')->send(new SendReportMail($name, $filePath));

    return 'Test mail sent!';
});


Route::view('/register', 'auth.register');
Route::view('/login', 'auth.login');
Route::view('/items', 'items');

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
//     return view('welcome');
// });



Route::get('/', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/edit/{id}', [UserController::class, 'edit']);
Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);



// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// CRUD UI routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index')->middleware('auth.jwt');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create')->middleware('auth.jwt');
Route::post('/items', [ItemController::class, 'store'])->name('items.store')->middleware('auth.jwt');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit')->middleware('auth.jwt');
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update')->middleware('auth.jwt');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy')->middleware('auth.jwt');


// Route::get('/', function () {
//     return view('home.index');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
