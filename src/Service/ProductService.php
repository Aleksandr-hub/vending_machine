<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function getProductByName(string $name)
    {
        return $this->productRepository->findOneByName($name);
    }

}
