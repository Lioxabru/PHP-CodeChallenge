<?php

namespace App\Repositories;
use GuzzleHttp\Client;

class Vehicle
{
	public $url = 'https://one.nhtsa.gov/webapi/api/';

	public function show($modelYear, $manufacturer, $model, $withRating)
	{
		try {
			$client = new Client();
			$response = $client->request('GET', $this->url . 'SafetyRatings' . '/modelyear/'. $modelYear . '/make/' . $manufacturer . '/model/' . $model);
			$vehicles = json_decode($response->getBody(), true);
			if ($withRating)
			{
                $results = $vehicles['Results'];
                $rating_array = array();
                foreach ($results as $result) {
                    $client = new Client();
                    $res = $client->request('GET', $this->url . 'SafetyRatings' . '/VehicleId/' . $result['VehicleId']);
                    $ratings = json_decode($res->getBody(), true);
                    $rating_array[] = $ratings['Results'][0]['OverallRating'];
                }

                $vehicles = array();
                $count = 0;
                
                foreach ($results as $result) {
                    $vehicles[] = array(
                        'CrashRating' => $rating_array[$count],
                        'Description' => $result['VehicleDescription'],
                        'VehicleId' => $result['VehicleId']
                    );
                    $count++;
                }
                return array(
                    'Count' => $count,
                    'Message' => 'Results returned successfully',
                    'Results' => $vehicles
                );
            }

            return $vehicles;

        } catch (\Exception $e) {
            return array(
                'Count' => 0,
                'Message' => 'No results found for this request',
                'Results' => array()
            );
        }
    }
}