<?php

namespace App\Services\Adderi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Integer;

class Adderi
{
    public $url;

    public function __construct()
    {
        $this->url = Config::get('externalapis.adderi.url');
    }

    private function autenticate(): \Illuminate\Http\Client\Response
    {
        $content = [
            'grant_type' => 'client_credentials',
            'scope' => '*',
            'client_id' => Config::get('externalapis.adderi.client_id'),
            'client_secret' => Config::get('externalapis.adderi.client_secret'),
        ];
        return Http::acceptJson()->post($this->url.'/token', $content);

    }

    public function getToken():string
    {
        try{
            $token = Cache::get('adderi.token');
            if ($token === null){
                $token = $this->newToken();
            }
            return $token;
        }catch (\Exception $e){
            throw new \LogicException($e->getMessage());
        }
    }

    public function newToken():string
    {
        try{
            $response = $this->autenticate();

            if (!$response->successful()){
                $response->throw();
            }

            $token = $response->json();
            Cache::put('adderi.token', $token['access_token'], $token['expires_in']);
            return Cache::get('adderi.token');
        }catch (\Exception $e){
            throw new \RuntimeException($e->getMessage());
        }

    }

    public function budget(): Budget
    {
        return new Budget($this);
    }

    public function budgetItem(): BudgetItem
    {
        return new BudgetItem($this);
    }

    public function people(): People
    {
        return new People($this);
    }

    public function reduceNumber($number): int
    {
        $aux = ltrim($number, '1');
        $numberBudget = ltrim($aux, '0');

        return $numberBudget;
    }


}
