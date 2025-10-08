<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuctionController;
use App\Models\Auction;

Route::get('/', [AuctionController::class, 'index'])->name('auctions.index');
Route::get('/resetear', [AuctionController::class, 'reset'])->name('auctions.reset');
Route::get('/crear-remate', [AuctionController::class, 'create'])->name('auctions.create');

Route::get('/remate/{auction}/editar', [AuctionController::class, 'edit'])->name('auctions.edit');
Route::put('/remate/{auction}/editar', [AuctionController::class, 'update'])->name('auctions.update');
Route::delete('/remate/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
Route::post('/crear-remate', [AuctionController::class, 'store'])->name('auctions.store');
Route::get('/remate/{auction}/calcular', [AuctionController::class, 'calculate'])->name('auctions.calculate');
Route::post('/auction/{auction}/print-tab', [AuctionController::class, 'printTab'])->name('auctions.print.tab');
Route::post('/auction/{auction}/print-all', [AuctionController::class, 'printAll'])->name('auctions.print.all');
Route::post('/auction/{auction}/generate-ticket', [AuctionController::class, 'generateTicket'])->name('auctions.generate-ticket');
Route::post('/auction/{auction}/print-all-tickets', [AuctionController::class, 'printAllTickets'])->name('auctions.print-all-tickets');
