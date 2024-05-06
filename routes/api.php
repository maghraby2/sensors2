<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorReadingController;





Route::get('sensor-readings/{sensor}', [SensorReadingController::class, 'show']);

Route::post('sensor-readings', [SensorReadingController::class, 'store']);
