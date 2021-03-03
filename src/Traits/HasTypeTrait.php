<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
// On inclue les annotations pour les assertions (conditions à vérifier pour une propriété)
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ATTENTION !
 * Les classes utilisant ce trait doivent implémenter une méthode getTypes
 */
trait HasTypeTrait
{
    /**
     * @ORM\Column(type="string", length=64)
     *
     * Ici, on ajoute un assertion de type Choice, qui va vérifier que la valeur de la propriété type est bien dans les choix retournés par la méthode getTypes (qu'il faut donc implémenter partout où on utilise le trait HasTypeTrait)
     * @Assert\Choice(callback="getTypes")
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