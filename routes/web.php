<?php

use App\Http\Controllers\BlockchainTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blockchain-transaction/{user}', [BlockchainTransactionController::class, 'index'])->name('blockchain.transaction');
