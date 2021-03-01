<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasNameTrait
{
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}