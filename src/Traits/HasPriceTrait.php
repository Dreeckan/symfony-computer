<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasPriceTrait
{
    /**
     * @ORM\Column(type="integer")
     */
    private $price;


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}