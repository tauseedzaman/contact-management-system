<?php

use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/categories', [ManagementController::class, 'categories'])->name('categories');
    Route::get('/create-category', [ManagementController::class, 'create_category'])->name('category.create');
    Route::post('/create-category', [ManagementController::class, 'store_category'])->name('category.store');

    Route::get('/contacts', [ManagementController::class, 'contacts'])->name('contacts');
    Route::get('/create-contact', [ManagementController::class, 'create_contact'])->name('contact.create');
    Route::post('/create-contact', [ManagementController::class, 'store_contact'])->name('contact.store');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
