<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $endpoint = self::URL_BASE_ONDEDOOR . $resource;

        $ch = curl_init();

        $Data = [
            "client_id" => "p5hF9GXocrXssIDeZHderOL1TP84pMKE",
            "client_secret" => "4XFLVU8-Sz2UbLenO8edA0T7RmFZJQ7u41Y--fGg_XwocLYwQ8gYJHFxa_ShgXad",
            "audience" => "https://onedor-quarkus.dev",
            "grant_type" => "client_credentials"
        ];

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InF4Q242N0JhLWdJRWxkMG1pd1V5YiJ9.eyJodHRwczovL25hbWVzcGFjZS5leHRyYWZpZWxkcy9jb21wYW5pZXMiOnsiYnJhbmNoZXMiOltdLCJwYXJlbnQiOnsiY29tcGFueUlkIjoiNjJkMDczYzhhNTQ3ODcyMjM3NzA1NWJlIiwiY29tcGFueU5hbWUiOiJFbWJhbGVtZSIsImlzUGFyZW50Ijp0cnVlfX0sImlzcyI6Imh0dHBzOi8vb25lZG9vci1kZXYudXMuYXV0aDAuY29tLyIsInN1YiI6InA1aEY5R1hvY3JYc3NJRGVaSGRlck9MMVRQODRwTUtFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL29uZWRvci1xdWFya3VzLmRldiIsImlhdCI6MTY1ODI1Mzc3NywiZXhwIjoxNjU4MzQwMTc3LCJhenAiOiJwNWhGOUdYb2NyWHNzSURlWkhkZXJPTDFUUDg0cE1LRSIsInNjb3BlIjoicmVhZDpjb21wYW5pZXMgdXBkYXRlOmNvbXBhbmllcyBjcmVhdGU6dXNlcnMgdXBkYXRlOnVzZXJzIHJlYWQ6dXNlcnMgZGVsZXRlOnVzZXJzIG1hbmFnZU90aGVyczp1c2VycyBjcmVhdGU6YnJhbmNoQ29tcGFuaWVzIG1hbmFnZTpvcmRlcnM6ZXh0ZXJuYWwgY3JlYXRlOm9yZGVyczpleHRlcm5hbCIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyIsInBlcm1pc3Npb25zIjpbInJlYWQ6Y29tcGFuaWVzIiwidXBkYXRlOmNvbXBhbmllcyIsImNyZWF0ZTp1c2VycyIsInVwZGF0ZTp1c2VycyIsInJlYWQ6dXNlcnMiLCJkZWxldGU6dXNlcnMiLCJtYW5hZ2VPdGhlcnM6dXNlcnMiLCJjcmVhdGU6YnJhbmNoQ29tcGFuaWVzIiwibWFuYWdlOm9yZGVyczpleHRlcm5hbCIsImNyZWF0ZTpvcmRlcnM6ZXh0ZXJuYWwiXX0.UHdAHYzX4gSk-p1xmGpDavRcvZS4oLvHfrk7J7LEStE1S_YYwguaXNEZDuKxyP5waECT4eb60BR-peF5Oa2tqk7HDIiqvChOCPFyVefX1tea21qSDCKBvv_oEy0XHIbt1mIDSf5SywOWpHUFykaPvFSTGedhFfOyQMAJzlfjTBXipDTaad1OZjOsIcRTcXqmEJI4Y2WiN57DIR730VbEnQQ4fSqXf3DC9BV4nggMMT_iy5Q8q3aoz4vXyFftYUwM5eCDKVI2thCiZKs33kGmtoha9ZzltfX0D16FlXXAmV7-AD8xIkdM4T-BFkQJD9y4U-idaKYI8i0mugj4RBuhSA",
        );

        $dataJson = json_encode($Data);

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

        $auth = DB::connection('ecommerce')->table('token')->where('user_id', 'onedoor')->first();

        $DateAmanha = new DateTime($auth->DataModify);
        $DateAmanha->modify('+ 12hours');

        // NOW
        $data = new DateTime();

        if (isset($auth)) {
            if ($DateAmanha->format('Y-m-d H:i:s') < $data->format('Y-m-d H:i:s')) {
                echo "ATUALIZOU";
                DB::connection('ecommerce')->update("update token set access_token = '$access_token->access_token' where id = ?", [$auth->id]);
            }
        } else {
            $data = new DateTime();
            DB::connection('ecommerce')->insert(
                'insert into token (access_token, type,user_id,dataModify) values (?, ?, ?, ?)',
                [$access_token->access_token, 'Bearer', 'onedoor', $data->format('Y-m-d H:i:s')],
            );
        }
    }
}
