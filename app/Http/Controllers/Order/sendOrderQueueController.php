<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

interface RequestOneDoorApiIntern{
    public function get($resource);
    public function resource();
}

class sendOrderQueueController extends Controller
{

    const URL_BASE_API = 'http://127.0.0.1:8000/api/v1/pedido';

    private $ORCNUM;

    public function __construct($ORCNUM)
    {
        $this->ORCNUM = $ORCNUM;
    }

    public function resource(){
        return $this->get('?orcamento='.$this->getORCNUM());
    }


    public function get($resource){

        // ENDPOINT PARA REQUISICAO
        $endpoint = self::URL_BASE_API.$resource;
        echo "ENDPOINT . " . $endpoint . "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "HTTP CODE : " . $httpcode;
        return response()->json($response);
    }

    /**
     * Get the value of ORCNUM
     */
    public function getORCNUM()
    {
        return $this->ORCNUM;
    }
}
