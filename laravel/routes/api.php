<?php

use App\Http\Controllers\MemoController;
use Illuminate\Support\Facades\Route;


Route::post('/memos', [MemoController::class, 'store']);
