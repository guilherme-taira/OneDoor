<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

interface RequestOnedoor
{
    public function resource();
    public function get($resource);
}

class AuthController implements RequestOnedoor
{
    const URL_BASE_ONDEDOOR = "https://onedoor-dev.us.auth0.com";

    public function resource()
    {
        return $this->get('/oauth/token');
    }

    public function get($resource)
    {

        // ENDPOINT PARA REQUISICAO
        $endpont = self::URL_BASE_ONDEDOOR . $resource;

        $curl = curl_init();

        $Data = [
            "client_id" => "p5hF9GXocrXssIDeZHderOL1TP84pMKE",
            "client_secret" => "4XFLVU8-Sz2UbLenO8edA0T7RmFZJQ7u41Y--fGg_XwocLYwQ8gYJHFxa_ShgXad",
            "audience" => "https://onedor-quarkus.dev",
            "grant_type" => "client_credentials"
        ];

        $dataJson = json_encode($Data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpont,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataJson
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        print_r($response);
    }
}
