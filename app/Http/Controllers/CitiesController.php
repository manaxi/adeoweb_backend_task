<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CitiesController extends Controller
{
    public function getCities()
    {
        $city = City::all();
        return response()->json(['cities' => $city], 200);
    }
}
