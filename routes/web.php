<?php

use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [App\Http\Livewire\Dashboard::class, '__invoke'])->name('dashboard');
});

Route::get('basic-table', [App\Http\Livewire\BasicTable::class, '_invoke'])->name('basictables');
Route::get('mon1', [App\Http\Livewire\Monitoring::class, '_invoke'])->name('cpu.show');

Route::middleware(['auth:sanctum', 'verified'])->prefix('plan')->group(function () {
    Route::get('home', [App\Http\Livewire\Plan\Home::class, '__invoke'])->name('plan.home');
    Route::get('/', [App\Http\Livewire\Plan\Show::class, '__invoke'])->name('plan.show');
    Route::get('request', [App\Http\Livewire\Plan\Request::class, '__invoke'])->name('plan.request');
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('stock')->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->get('/', App\Http\Livewire\StockHome::class)->name('stock.home');
    Route::middleware(['auth:sanctum', 'verified'])->get('header', App\Http\Livewire\StockOuts::class)->name('stock.header');
    Route::middleware(['auth:sanctum', 'verified'])->get('transections', [App\Http\Livewire\Stock\Transections::class, '__invoke'])->name('stock.transections');
});
