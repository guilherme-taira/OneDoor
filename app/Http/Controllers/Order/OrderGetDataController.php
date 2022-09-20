<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

interface RequestHttp{
    public function resource();
    public function get($resource);
}

class OrderGetDataController implements RequestHttp
{
    const URL_BASE_GET_TRAKING = "https://api.onedoor.com.br";

    // VARIAVEIS PRIVADAS
    private $id;
    private $pedido;

    public function __construct($id,$pedido)
    {
        $this->id = $id;
        $this->pedido = $pedido;
    }

    public function resource()
    {
        return $this->get('/v1/orders/partners/'.$this->getId());
    }

    public function get($resource){

        // ENDPOINT PARA REQUISICAO
        try {
            $endpoint = self::URL_BASE_GET_TRAKING.$resource;

            // conexao com o banco para pegar token
            $auth = DB::connection('ecommerce')->table('token')->where('user_id', 'onedoor')->first();

            $headers = array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Bearer {$auth->access_token}",
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            echo "<pre>";
            $data = json_decode($response);
            if($data->status->current == 'DELIVERY_FINISHED'){
                foreach ($data->status->steps as $value) {
                    if('DELIVERY_FINISHED' == $value->status){
                        print_r($value);
                    }
                }

                /**
                 *  IMPLEMENTAÇÃO DE FINALIZADO
                 */

                //orders::where('id_pedido',$this->getId())->update(['flag_finalizado' => 'X']);
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set the value of pedido
     *
     * @return  self
     */
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }
}
