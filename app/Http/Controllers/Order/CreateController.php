<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\orders;
use DateTime;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    const URL_BASE_ONEDOOR_CREATE = "https://api-dev.onedoor.com.br";

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

        $Data = [
            "companyId" => "62d073c8a5478722377055be",
            "number" => $this->getOrcamento(),
            "forecastDeliveryDate" => $this->getTime() . 'Z', // format "2022-07-21T17:59:01.000Z"
            "deliveryCompanyName" => "Embaleme comércio de Emabalagem e Festas",
            "deliveryCompanyId" => "62d073c8a5478722377055be",
            "sendSms" => "false",
            "purchaseData" => [
                "documentType" => "DECLARATION",
                "companyiD" => "62d073c8a5478722377055be",
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
                        "latitude" => -21.6134463,
                        "longitude" => -48.4074324
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

        $json = json_encode($Data);
        // echo "<pre>";
        // print_r(json_decode($json));

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InF4Q242N0JhLWdJRWxkMG1pd1V5YiJ9.eyJodHRwczovL25hbWVzcGFjZS5leHRyYWZpZWxkcy9jb21wYW5pZXMiOnsiYnJhbmNoZXMiOltdLCJwYXJlbnQiOnsiY29tcGFueUlkIjoiNjJkMDczYzhhNTQ3ODcyMjM3NzA1NWJlIiwiY29tcGFueU5hbWUiOiJFbWJhbGVtZSIsImlzUGFyZW50Ijp0cnVlfX0sImlzcyI6Imh0dHBzOi8vb25lZG9vci1kZXYudXMuYXV0aDAuY29tLyIsInN1YiI6InA1aEY5R1hvY3JYc3NJRGVaSGRlck9MMVRQODRwTUtFQGNsaWVudHMiLCJhdWQiOiJodHRwczovL29uZWRvci1xdWFya3VzLmRldiIsImlhdCI6MTY1ODc1MDkzNCwiZXhwIjoxNjU4ODM3MzM0LCJhenAiOiJwNWhGOUdYb2NyWHNzSURlWkhkZXJPTDFUUDg0cE1LRSIsInNjb3BlIjoicmVhZDpjb21wYW5pZXMgdXBkYXRlOmNvbXBhbmllcyBjcmVhdGU6dXNlcnMgdXBkYXRlOnVzZXJzIHJlYWQ6dXNlcnMgZGVsZXRlOnVzZXJzIG1hbmFnZU90aGVyczp1c2VycyBjcmVhdGU6YnJhbmNoQ29tcGFuaWVzIG1hbmFnZTpvcmRlcnM6ZXh0ZXJuYWwgY3JlYXRlOm9yZGVyczpleHRlcm5hbCIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyIsInBlcm1pc3Npb25zIjpbInJlYWQ6Y29tcGFuaWVzIiwidXBkYXRlOmNvbXBhbmllcyIsImNyZWF0ZTp1c2VycyIsInVwZGF0ZTp1c2VycyIsInJlYWQ6dXNlcnMiLCJkZWxldGU6dXNlcnMiLCJtYW5hZ2VPdGhlcnM6dXNlcnMiLCJjcmVhdGU6YnJhbmNoQ29tcGFuaWVzIiwibWFuYWdlOm9yZGVyczpleHRlcm5hbCIsImNyZWF0ZTpvcmRlcnM6ZXh0ZXJuYWwiXX0.gkIgcbCkn6VCjxShU0RHPy7uDqbCxOG93PeSQH7JkZL4LDHMj2iJNUS0uZqrSJYgNiEU9KdYENg35xbWbmfz7xlV8RN6joJlNiR5toNHEhUkH8LWWOejowg-jxgYHl6LIVwuILUiRIp7S7fOfWy3PVPUZtTJH36ro2fh0UiKUFrzSIKDcPDTu3jNNeQTmzFA1N1NlBQcU48pyHS0BRet-Cp5JB53ZaX0ghJrV_Nx-yUEatAlf8PSM64Jo1qaOj1v1EN5AT-nyKAYVi-vcYMt8RSaW2FpuQDTH3BJWeJuequvDALSdRpRnZyFN1nUhXxxh6zka1Q3Gm-xXO7SNdScxg",
        );

        $dataJson = json_encode($Data, JSON_PRETTY_PRINT);
        // echo "<pre>";
        // print_r($dataJson);
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
        echo "HTTP CODE : " . $httpcode;
        if ($httpcode == '201') {
            orders::where('ORCNUM', $this->getOrcamento())->update(['Flag_Processado' => '', 'response' => $response]);
        } else {
            orders::where('ORCNUM', $this->getOrcamento())->update(['flag_erro' => 'X', 'response' => json_decode($response, true)]);
        }
        // echo "<pre>";
        // print_r(json_decode($response, false));
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
}
