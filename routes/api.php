<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;





Route::get('sensor-readings/{sensor}', [SensorReadingController::class, 'show']);
Route::get('sensor-readings', [SensorReadingController::class, 'store']);
