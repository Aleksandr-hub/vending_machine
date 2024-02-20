<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders(): array
    {
        return $this->orderRepository->findAll();
    }

    public function getLatestUnfulfilledOrder(): ?Order
    {
        return $this->orderRepository->findOneBy(['isFulfilled' => false]);
    }


}
