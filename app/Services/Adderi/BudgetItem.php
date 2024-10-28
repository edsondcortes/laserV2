<?php

namespace App\Services\Adderi;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Config;

class BudgetItem
{
    private Adderi $adderi;

    public function __construct(Adderi $adderi)
    {
        $this->adderi = $adderi;
    }

    public function index(array $budgets):\Illuminate\Http\Client\Response
    {
        $params = [
            'orcamentos' => $budgets
        ];
        return Http::withToken($this->adderi->getToken())
            ->acceptJson()
            ->retry(1, 100, function ($exception, $request){
                if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                    return false;
                }
                $request->withToken($this->adderi->newToken());
                return true;
            })
            ->get($this->adderi->url.'/orcamento/item/index', $params);
    }

}
