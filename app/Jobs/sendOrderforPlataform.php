<?php

namespace App\Jobs;

use App\Http\Controllers\Order\CreateController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendOrderforPlataform implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     private $ORCNUM;
     private $value;
     private $name;
     private $documento;
     private $telefone;
     private $email;
     private $endereco;
     private $cep;
     private $complemento;
     private $numero;
     private $bairro;
     private $cidade;
     private $UF;
     private $updated_at;

     public function __construct($ORCNUM,$value,$name,$documento,$telefone,$email,$endereco,$cep,$complemento,$numero,$bairro,$cidade,$UF,$updated_at)
    {
        $this->ORCNUM = $ORCNUM;
        $this->value = $value;
        $this->name = $name;
        $this->documento = $documento;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->endereco = $endereco;
        $this->cep = $cep;
        $this->complemento = $complemento;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->UF = $UF;
        $this->$updated_at = $updated_at;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $CreateController = new CreateController($this->getORCNUM(),$this->getValue(),$this->getValue(),$this->getName(),$this->getDocumento(),$this->getTelefone(),$this->getEmail(),$this->getEndereco(),$this->getCep(),$this->getComplemento(),$this->getNumero(),$this->getComplemento(),$this->getCidade(),$this->getUF(),$this->getUpdated_at());
        $CreateController->resource();
    }

     /**
      * Get the value of ORCNUM
      */
     public function getORCNUM()
     {
          return $this->ORCNUM;
     }

     /**
      * Get the value of value
      */
     public function getValue()
     {
          return $this->value;
     }

     /**
      * Get the value of name
      */
     public function getName()
     {
          return $this->name;
     }

     /**
      * Get the value of documento
      */
     public function getDocumento()
     {
          return $this->documento;
     }

     /**
      * Get the value of telefone
      */
     public function getTelefone()
     {
          return $this->telefone;
     }

     /**
      * Get the value of email
      */
     public function getEmail()
     {
          return $this->email;
     }

     /**
      * Get the value of endereco
      */
     public function getEndereco()
     {
          return $this->endereco;
     }

     /**
      * Get the value of cep
      */
     public function getCep()
     {
          return $this->cep;
     }

     /**
      * Get the value of complemento
      */
     public function getComplemento()
     {
          return $this->complemento;
     }

     /**
      * Get the value of numero
      */
     public function getNumero()
     {
          return $this->numero;
     }

     /**
      * Get the value of bairro
      */
     public function getBairro()
     {
          return $this->bairro;
     }

     /**
      * Get the value of cidade
      */
     public function getCidade()
     {
          return $this->cidade;
     }

     /**
      * Get the value of UF
      */
     public function getUF()
     {
          return $this->UF;
     }

     /**
      * Get the value of updated_at
      */
     public function getUpdated_at()
     {
          return $this->updated_at;
     }
}
