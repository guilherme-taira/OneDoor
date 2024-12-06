<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
date_default_timezone_set('America/Sao_Paulo');

interface RequestOnedoor
{
    public function resource();
    public function get($resource);
}

class AuthController implements RequestOnedoor
{
    const URL_BASE_ONDEDOOR = "https://auth.onedoor.com.br"; // https://onedoor-prod.us.auth0.com PROD // https://onedoor-dev.us.auth0.com DEV
    const URL_BASE_ONEDOOR_DEV = "https://onedoor-dev.us.auth0.com";
    public function resource()
    {
        return $this->get('/oauth/token');
    }

    public function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = self::URL_BASE_ONEDOOR_DEV . $resource;

        $Data = [
            "client_id" => env('ONEDOOR_CLIENT_ID'), // PROD env('ONEDOOR_CLIENT_ID')
            "client_secret" => env('ONEDOOR_CLIENT_SECRET'), // PROD env('ONEDOOR_CLIENT_SECRET')
            "audience" => env('ONEDOOR_AUDIENCE'), // PROD env('ONEDOOR_AUDIENCE')
            "grant_type" => env('ONEDOOR_GRANT_TYPE') // PROD env('ONEDOOR_GRANT_TYPE')
        ];

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
        );

        $dataJson = json_encode($Data);

        $auth = DB::connection('ecommerce')->table('token')->where('user_id', 'onedoor')->first();

        $DateAmanha = new DateTime($auth->DataModify);
        $DateAmanha->modify('+ 24hours');
        //print_r($DateAmanha);
        // NOW
        $data = new DateTime();
        // DATA BANCO
        $dataBanco = new DateTime($auth->DataModify);

        if (isset($auth)) {
            try {
                if ($dataBanco->format('Y-m-d H:i:s') > $data->format('Y-m-d H:i:s')) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $endpoint);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $access_token = json_decode($response);
                    print_r($access_token);
                    echo "ATUALIZOU";
                    DB::connection('ecommerce')->table('token')
                        ->where('id', $auth->id)
                        ->update(['access_token' => $access_token->access_token, 'DataModify' => $DateAmanha->format('Y-m-d H:i:s')]);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);

            $access_token = json_decode($response);

            $data = new DateTime();
            DB::connection('ecommerce')->insert(
                'insert into token (access_token, type,user_id,dataModify) values (?, ?, ?, ?)',
                [$access_token->access_token, 'Bearer', 'onedoor', $data->format('Y-m-d H:i:s')],
            );
        }
    }
}
