<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasBrandTrait
{
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $brand;


    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}