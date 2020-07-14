<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client(['headers' => ['Accept' => 'application/json']]); 
        $response = $client->request('GET', 'https://api.meteo.lt/v1/places', ['verify' => false]);
        $data = json_decode($response->getBody()->getContents(), true);
        foreach($data as $item)
        {
            DB::table('cities')->insert(['code' => $item['code'], 
            'name' => $item['name'],
            'administrativeDivision' => $item['administrativeDivision'],
            'countryCode' => $item['countryCode']]);
        }
    }
}
