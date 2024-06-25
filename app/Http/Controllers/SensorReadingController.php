<?php

namespace App\Http\Controllers;

use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorReadingController extends Controller
{
    public function store(Request $request)
    {
        // Extract and decode sensor readings from the query parameter
        $sensorReadingsJson = $request->query('sensor_readings');
        $sensorReadings = json_decode($sensorReadingsJson, true);

        if (is_null($sensorReadings)) {
            return response()->json(['error' => 'Invalid sensor_readings parameter'], 400);
        }

        // Manual validation
        if (!is_array($sensorReadings)) {
            return response()->json(['error' => 'sensor_readings must be an array'], 400);
        }

        foreach ($sensorReadings as $readingData) {
            if (!isset($readingData['sensor_name']) || !is_string($readingData['sensor_name'])) {
                return response()->json(['error' => 'Each reading must have a sensor_name of type string'], 400);
            }
            if (!isset($readingData['value']) || !is_numeric($readingData['value'])) {
                return response()->json(['error' => 'Each reading must have a value of type numeric'], 400);
            }
        }

        // Store the sensor readings
        foreach ($sensorReadings as $readingData) {
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