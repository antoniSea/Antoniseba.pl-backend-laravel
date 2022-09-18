<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TasksController;
use App\Models\User;
use App\Http\Controllers\PortfolioItemsController;

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
});