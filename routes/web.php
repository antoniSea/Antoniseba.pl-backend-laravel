<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TasksController;
use App\Models\User;
use App\Http\Controllers\PortfolioItemsController;
use App\Http\Controllers\PortfolioTypesController;
use App\Models\PortfolioType;
use App\Http\Controllers\MessageController;

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


require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// routes for vertified users checked by middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/portfolio/nowy', [PortfolioItemsController::class, 'create'])->name('portfolio-items.create');
    Route::post('/dashboard/portfolio/nowy', [PortfolioItemsController::class, 'store'])->name('portfolio-items.store');
    Route::get('/dashboard/portfolio',  [PortfolioItemsController::class, 'index'])->name('portfolio-items.index');
    Route::delete('/dashboard/portfolio/{id}',  [PortfolioItemsController::class, 'destroy'])->name('portfolio-items.delete');
    Route::get('/dashboard/portfolio/{id}', [PortfolioItemsController::class, 'edit'])->name('portfolio-items.edit');
    Route::put('/dashboard/portfolio/{id}', [PortfolioItemsController::class, 'update'])->name('portfolio-items.update');

    Route::get('/dashboard/portfolio/typ/nowy', [PortfolioTypesController::class, 'create'])->name('portfolio-type.create');
    Route::post('/dashboard/portfolio/typ/nowy', [PortfolioTypesController::class, 'store'])->name('portfolio-type.store');
    Route::get('/dashboard/portfolio/typ/lista', [PortfolioTypesController::class, 'index'])->name('portfolio-type.index');
    Route::delete('/dashboard/portfolio/typ/{id}', [PortfolioTypesController::class, 'destroy'])->name('portfolio-type.delete');
    Route::get('/dashboard/portfolio/typ/{id}', [PortfolioTypesController::class, 'show'])->name('portfolio-type.show');
    Route::put('/dashboard/portfolio/typ/{id}', [PortfolioTypesController::class, 'update'])->name('portfolio-type.update');
    
    Route::get('/dashboard/wiadomosci/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/dashboard/wiadomosci', [MessageController::class, 'index'])->name('messages.index');
    Route::delete('/dashboard/wiadomosci/{id}', [MessageController::class, 'destroy'])->name('messages.delete');
});