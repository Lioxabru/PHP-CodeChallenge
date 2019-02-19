<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\Repositories\Vehicle;

class VehiclesController extends Controller
{
    
    protected $vehicle;


    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function index(Request $request)
    {
        $data = $this->vehicle->show($request->input('modelYear'), $request->input('manufacturer'), $request->input('model'),  false);

        return response()->json($data);
    }

    public function show($modelYear, $manufacturer, $model, Request $request)
    {
        $withRating = false;

        if ($request->has('withRating')){

            $withRating = $request->input('withRating') == 'true';
        }

        $data = $this->vehicle->show($modelYear, $manufacturer, $model, $withRating);

        return response()->json($data);
    }
}