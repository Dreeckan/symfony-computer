<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasTypeTrait
{
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $type;


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}