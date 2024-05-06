<?php

namespace App\Http\Controllers;

use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorReadingController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'sensor_readings' => 'required|array',
        'sensor_readings.*.sensor_name' => 'required|string',
        'sensor_readings.*.value' => 'required|numeric',
    ]);

    foreach ($validatedData['sensor_readings'] as $readingData) {
        $reading = new SensorReading();
        $reading->sensor_name = $readingData['sensor_name'];
        $reading->value = $readingData['value'];
        $reading->save();
    }

    return response()->json(['message' => 'Readings stored successfully'], 201);
}

    public function show($sensor)
    {
        $readings = SensorReading::where('sensor_name', $sensor)->get();
        return response()->json($readings, 200);
    }
}
