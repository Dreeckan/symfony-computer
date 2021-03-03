<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait HasNameTrait
{
    /**
     * @ORM\Column(type="string", length=128)
     * // Une assertion pour vérifier que notre name n'est pas vide
     * @Assert\NotBlank()
     * // Une autre pour vérifier qu'il contienne au moins 4 caractères
     * @Assert\Length(min=4)
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