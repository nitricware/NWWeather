<?php

namespace NitricWare;

use CurlHandle;
use NitricWare\INWWRelais;

class NWWRelaisWindy implements INWWRelais
{
    private string $apiURL = "https://stations.windy.com/api/v2/observation/update";
    public function handleData(NWWWundergroundJSONData $data): bool
    {
        $payLoad = [
            "id" => $data->id,
            "PASSWORD" => $data->PASSWORD,
            "windspeedmph" => $data->windspeedmph,
            "windgustmph" => $data->windgustmph,
            "winddir" => $data->winddir,
            "humidity" => $data->humidity,
            "dewptf" => $data->dewptf,
            "baromin" => $data->baromin,
            "uv" => $data->UV,
            "solarradiation" => $data->solarradiation,
            "rainin" => $data->rainin,
            "tempf" => $data->tempf,
            "softwaretype" => $data->softwaretype,
            "stationtype" => NWWeatherSettings::$stationType
        ];

        $apiUrlWithPayload = $this->buildUrlWithPayload($payLoad);
        $ch = $this->createCurlHandler($apiUrlWithPayload);
        $response = $this->executeCurlHandle($ch);

        $db = new NWWRelaisSQLite();
        $db->log("NWWRelaisWindy", $response);

        return true;
    }

    private function createCurlHandler($apiUrlWithPayLoad) : CurlHandle {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrlWithPayLoad);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return $ch;
    }

    private function buildUrlWithPayload(array $data): string {
        return $this->apiURL . "?" . http_build_query($data);
    }

    private function executeCurlHandle(CurlHandle $curlHandle): string {
        $response = curl_exec($curlHandle);
        if (!$response) {
            return curl_error($curlHandle);
        }

        return $response;
    }
}