<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Product;
class ProductsController extends Controller
{
    /**
     * Show recommended products by current weather
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recommendedProducts()
    {
        $minutes = 360;
    }
    /**
     * Show product by certain id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        $products = Product::find($id);

        return response()->json($products);
    }
    /**
     * Show recommended products by current weather
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCityForecast($cityName)
    {
        $minutes = 240;
    }
}
