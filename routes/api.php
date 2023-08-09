<?php

use App\Http\Controllers\ConversionController;
use Illuminate\Support\Facades\Route;

Route::get('/conversions', [ConversionController::class, 'conversionListForBase']);
