<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    const URL_BASE_ONEDOOR_CREATE = "https://api.onedoor.com.br"; //

    private $orcamento;
    private $total;
    private $prepaid;
    // CLIENT DATA
    private $name;
    private $document;
    private $phoneNumber;
    private $email;
    private $street;
    private $zipCode;
    private $complement;
    private $number;
    private $district;
    private $city;
    private $state;
    private $time;

    public function __construct($orcamento, $total, $prepaid, $name, $document, $phoneNumber, $email, $street, $zipCode, $complement, $number, $district, $city, $state, $time)
    {
        $this->orcamento = $orcamento;
        $this->total = $total;
        $this->prepaid = $prepaid;
        $this->name = $name;
        $this->document = $document;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->complement = $complement;
        $this->number = $number;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->time = $time;
    }

    public function resource()
    {
        return $this->get('/v1/orders/partners');
    }

    public function get($resource)
    {

        // ENDPOINT PARA REQUISICAO
        $endpoint = self::URL_BASE_ONEDOOR_CREATE . $resource;

        /**
         * Array com dados para persistir
         */
        // SOMA 2 horas a mais da hora de criação do pedido
        $date = new DateTime($this->getTime());
        $date->modify('+4 hours');
        $this->setTime($date->format('Y-m-d\TH:i:s.u'));

        // GET COORDENADAS GEOCODE API
        $dadosjson = json_decode(json_encode($this->getGeoCode($this->getCity(), $this->getStreet(), $this->getNumber(), $this->getDistrict())));

        try {
            $Data = [
                "companyId" => "62cd78c39f35ff21644973c0",
                "number" => $this->getOrcamento(),
                "forecastDeliveryDate" => $this->getTime() . 'Z', // format "2022-07-21T17:59:01.000Z"
                "deliveryCompanyName" => "Embaleme comércio de Emabalagem e Festas",
                "deliveryCompanyId" => "62cd78c39f35ff21644973c0",
                "sendSms" => "true",
                "purchaseData" => [
                    "documentType" => "DECLARATION",
                    "companyiD" => "62cd78c39f35ff21644973c0",
                    "number" => $this->getOrcamento(),
                    "total" => $this->getTotal(),
                ],
                "payments" => [
                    "prepaid" => $this->getPrepaid(),
                    "pending" => 0,
                    "methods" => [
                        [
                            "value" => $this->getTotal(),
                            "currency" => "R$",
                            "type" => "PREPAID",
                            "method" => "CREDIT",
                            "methodInfo" => "DEBIT",
                            "changeFor" => 0
                        ],
                        [
                            "value" => 0,
                            "currency" => "R$",
                            "type" => "PENDING",
                            "method" => "CREDIT",
                            "methodInfo" => "string",
                            "changeFor" => 0
                        ],
                    ]
                ],
                "recipient" => [
                    "name" => $this->getName(), // DADOS DO CLIENTE
                    "document" => $this->getDocument(),
                    "phoneNumber" => $this->getPhoneNumber(),
                    "email" => $this->getEmail(),
                    "address" => [
                        "street" => $this->getStreet(),
                        "zipCode" => $this->getZipCode(),
                        "complement" => $this->getComplement(),
                        "number" => $this->getNumber(),
                        "district" => $this->getDistrict(),
                        "city" => $this->getCity(),
                        "state" => $this->getState(),
                        "location" => [
                            "latitude" => $dadosjson->latitude,
                            "longitude" => $dadosjson->longitude
                        ],
                    ],
                ],
                "items" => [
                    [
                        "description" => "Preenchido automaticamente, favor editar",
                        "quantity" => 1,
                        "price" => $this->getTotal(),
                    ]
                ],
                "weight" => 1,
                "dimensions" => [
                    "length" => 1,
                    "height" => 1,
                    "width" => 1
                ],
                "pickupAddress" => [
                    "street" => "Padre Juliao",
                    "zipCode" => "13610230",
                    "district" => "Centro",
                    "number" => "1312",
                    "city" => "Leme",
                    "state" => "SP",
                    "location" => [
                        "latitude" => -21.6136568,
                        "longitude" => -48.3562922
                    ]
                ]
            ];
        } catch (\ErrorException $th) {
            $Data = [
                "companyId" => "62cd78c39f35ff21644973c0",
                "number" => $this->getOrcamento(),
                "forecastDeliveryDate" => $this->getTime() . 'Z', // format "2022-07-21T17:59:01.000Z"
                "deliveryCompanyName" => "Embaleme comércio de Emabalagem e Festas",
                "deliveryCompanyId" => "62cd78c39f35ff21644973c0",
                "sendSms" => "true",
                "purchaseData" => [
                    "documentType" => "DECLARATION",
                    "companyiD" => "62cd78c39f35ff21644973c0",
                    "number" => $this->getOrcamento(),
                    "total" => $this->getTotal(),
                ],
                "payments" => [
                    "prepaid" => $this->getPrepaid(),
                    "pending" => 0,
                    "methods" => [
                        [
                            "value" => $this->getTotal(),
                            "currency" => "R$",
                            "type" => "PREPAID",
                            "method" => "CREDIT",
                            "methodInfo" => "DEBIT",
                            "changeFor" => 0
                        ],
                        [
                            "value" => 0,
                            "currency" => "R$",
                            "type" => "PENDING",
                            "method" => "CREDIT",
                            "methodInfo" => "string",
                            "changeFor" => 0
                        ],
                    ]
                ],
                "recipient" => [
                    "name" => $this->getName(), // DADOS DO CLIENTE
                    "document" => $this->getDocument(),
                    "phoneNumber" => $this->getPhoneNumber(),
                    "email" => $this->getEmail(),
                    "address" => [
                        "street" => $this->getStreet(),
                        "zipCode" => $this->getZipCode(),
                        "complement" => $this->getComplement(),
                        "number" => $this->getNumber(),
                        "district" => $this->getDistrict(),
                        "city" => $this->getCity(),
                        "state" => $this->getState(),
                        "location" => [
                            "latitude" => -0,
                            "longitude" => -0
                        ],
                    ],
                ],
                "items" => [
                    [
                        "description" => "Preenchido automaticamente, favor editar",
                        "quantity" => 1,
                        "price" => $this->getTotal(),
                    ]
                ],
                "weight" => 1,
                "dimensions" => [
                    "length" => 1,
                    "height" => 1,
                    "width" => 1
                ],
                "pickupAddress" => [
                    "street" => "Padre Juliao",
                    "zipCode" => "13610230",
                    "district" => "Centro",
                    "number" => "1312",
                    "city" => "Leme",
                    "state" => "SP",
                    "location" => [
                        "latitude" => -21.6136568,
                        "longitude" => -48.3562922
                    ]
                ]
            ];
        }

        $json = json_encode($Data);

        // print_r(json_decode($json));
        // echo "<hr>";
        // conexao com o banco para pegar token
        $auth = DB::connection('ecommerce')->table('token')->where('user_id', 'onedoor')->first();

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer {$auth->access_token}",
        );

        $dataJson = json_encode($Data, JSON_PRETTY_PRINT);
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
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //echo "<pre>";
        print_r(json_decode($response, false));
        echo "HTTP CODE : " . $httpcode;

        // RESPONSE DECODIFICADO
        $res = json_decode($response, false);

        try {
            if ($httpcode == '201') {
                if (!empty($res->trackingUrl)) {
                    orders::where('ORCNUM', $this->getOrcamento())->update(['Flag_Processado' => '', 'response' => $res->trackingUrl. "-> $httpcode",'id_pedido' => $res->id,'flag_aguardando' => 'X']);
                    Log::channel('onedoorError')->info($res->trackingUrl);
                } else {
                    Log::channel('onedoorError')->info($httpcode);
                    orders::where('ORCNUM', $this->getOrcamento())->update(['Flag_Processado' => '', 'response' => "Cadastrado com sucesso! $httpcode",'id_pedido' => $res->id]);
                }
            } else {
                if (!empty($res)) { // SE A RESPOSTA NÂO TIVER VAZIA
                    try {
                        if($res->trackingUrl){ // SE TIVER SETADO O VALOR TRACKING URL REMOVE O ERRO
                            orders::where('ORCNUM', $this->getOrcamento())->update(['Flag_Processado' => '', 'response' => $res->trackingUrl. "-> $httpcode",'id_pedido' => $res->id,'flag_aguardando' => 'X']);
                            Log::channel('onedoorError')->info($res->trackingUrl);
                        }
                    } catch (\Exception $e) {
                        if($res){
                            Log::channel('onedoorError')->info('SEM RESPOSTA NA REQUISICAO'.$e->getMessage().'--->'. $e->getCode());
                            orders::where('ORCNUM', $this->getOrcamento())->update(['flag_erro' => 'X', 'Flag_Processado' => '', 'response' => json_encode($res)]);
                        }else{
                            // GRAVA O ERRO NO LOG
                            Log::channel('onedoorError')->info($e->getMessage().'--->'. $e->getCode());
                            orders::where('ORCNUM', $this->getOrcamento())->update(['flag_erro' => 'X', 'Flag_Processado' => '', 'response' => $e->getMessage()]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // ERROR JSON
        $error = [
            "error" => [
                "Message" => $e->getMessage(),
                "StatusCode" => "$httpcode",
            ],
        ];
            orders::where('ORCNUM', $this->getOrcamento())->update(['flag_erro' => 'X', 'Flag_Processado' => '', 'response' => json_encode($error)]);
        }

    }

    /**
     * Get the value of orcamento
     */
    public function getOrcamento()
    {
        return $this->orcamento;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get the value of prepaid
     */
    public function getPrepaid()
    {
        return $this->prepaid;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Get the value of zipCode
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Get the value of complement
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Get the value of number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the value of district
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the value of state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the value of time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }


    public function Endereco(array $endereco)
    {
        $regex = "[ ]";
        $replecement = "+";
        return preg_replace($regex, $replecement, $endereco['end']);
    }

    public function getGeoCode($cidade, $rua, $numero, $bairro)
    {

        $endereco = [];
        $endereco['end'] = $cidade . '+' . $rua . '+' . $numero . '+' . $bairro;

        $endpoint2 = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $this->Endereco($endereco) . "&key=AIzaSyAgtArGP-BFZEi-Rs5Wwi8CzSQtiZBjObU";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $jsonData = json_decode($response);

        try {
            $endereco['latitude'] = $jsonData->results[0]->geometry->location->lat;
            $endereco['longitude'] = $jsonData->results[0]->geometry->location->lng;

            return $endereco;
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }
    }
}
