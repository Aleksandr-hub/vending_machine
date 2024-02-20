<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalCost = null;

    #[ORM\Column(nullable: true)]
    private ?float $change_amount = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFulfilled = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): static
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getChangeAmount(): ?float
    {
        return $this->change_amount;
    }

    public function setChangeAmount(?float $change_amount): static
    {
        $this->change_amount = $change_amount;

        return $this;
    }

    public function getIsFulfilled(): ?bool
    {
        return $this->isFulfilled;
    }

    public function setIsFulfilled(bool $isFulfilled): self
    {
        $this->isFulfilled = $isFulfilled;

        return $this;
    }

    public function isIsFulfilled(): ?bool
    {
        return $this->isFulfilled;
    }
}
