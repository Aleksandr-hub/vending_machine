<?php

namespace App\Service;

use App\Repository\CoinRepository;

class CoinService
{
    private $coinRepository;

    public function __construct(CoinRepository $coinRepository)
    {
        $this->coinRepository = $coinRepository;
    }

    public function getAllCoins(): array
    {
        return $this->coinRepository->findAll();
    }

}
