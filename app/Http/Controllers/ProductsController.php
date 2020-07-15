<?php

namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Category;
use App\Product;
use App\Http\Resources\Product as ProductResource;

class ProductsController extends Controller
{
    public function getProducts()
    {
        // Get products
        $products = Product::paginate(10);
        // return collection of products as a resource
        return ProductResource::collection($products);
    }

    /**
     * Show product by certain id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    /** Store product
     * @param Request $request
     * @return ProductResource|\Illuminate\Http\JsonResponse|null
     */
    public function storeProduct(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:55|min:5',
            'sku' => 'required|min:9',
            'price' => 'numeric|required',
            'status' => ['required', Rule::in(['0', '1'])],
            'categories' => 'required',
        ]);
        $product = $request->isMethod('put') ? Product::findOrFail($request->product_id) : new Product;
        $product->id = $request->product_id;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->status = $request->status;

        if ($validatedData->fails()) {
            foreach ($validatedData->errors()->getMessages() as $item)
                $errors[] = $item;
            return response()->json(['errors' => $errors], 200);
        } else {
            $product->save();
            if (isset($request->categories))
                $product->categories()->sync($request->categories);
            else
                $product->categories()->sync(array());

            if ($product->save())
                return new ProductResource($product);
        }
        return null;
    }

    /** Delete product
     * @param $id - product id
     * @return ProductResource
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->delete())
            return new ProductResource($product);
    }

    /** Show recommended products by current weather
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function recommendedProducts($cityCode)
    {
        $currentTime = Carbon::now()->minute(0)->seconds(0)->toDateTimeString();
        if (Cache::has($cityCode))
            $cityForecast = Cache::get($cityCode);
        else
            $cityForecast = $this->getCityForecast($cityCode);

        if (isset($cityForecast['place'])) {
            foreach ($cityForecast['forecastTimestamps'] as $key => $value) {
                if ($value['forecastTimeUtc'] == $currentTime)
                    $forecast = $value;
            }
            $data = [
                'city' => $cityForecast['place']['name'],
                'current_weather' => $forecast['conditionCode'],
                'current_temp' => $forecast['airTemperature'],
                'forecast_source' => 'LHMT - api.meteo.lt',
                'recommended_products' => $this->getProductsByCondition($forecast['conditionCode'])
            ];
            return response()->json($data, 200);
        } else
            return response()->json($cityForecast, 200);
    }

    /**
     * Getting product categories that matches weather condition
     * @param $conditionCode - weather condition code
     * @return LengthAwarePaginator Returining paginated result for products from categories
     */
    public function getProductsByCondition($conditionCode)
    {
        $categories = Category::where('weather', '=', $conditionCode)->get();
        foreach ($categories as $item)
            $products[] = $item->products;
        return $this->paginate($products);
    }

    /**
     * Get long term forecast by city code from METEO API
     * @param $cityCode - city code
     * @return mixed - returns json response from meteo api
     */
    public function getCityForecast($cityCode)
    {
        $minutes = 240;
        $cityForecast = Cache::remember($cityCode, $minutes, function () use ($cityCode) {
            $client = new Client([
                'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                'verify' => false,
            ]);
            try {
                $response = $client->get("https://api.meteo.lt/v1/places/${cityCode}/forecasts/long-term");
                $data = $response->getBody()->getContents();
                return json_decode($data, true);
            } catch (ClientException $e) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
        });
        return $cityForecast;
    }

    /** Paginating result for array
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $result = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $result->setPath(LengthAwarePaginator::resolveCurrentPath());
    }
}
