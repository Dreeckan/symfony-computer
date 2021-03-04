<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use App\Traits\HasBrandTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasPriceTrait;
use App\Traits\HasTimestampTrait;
use App\Traits\HasTypeTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComponentRepository::class)
 */
class Component
{
    use HasBrandTrait;
    use HasNameTrait;
    use HasPriceTrait;
    use HasTimestampTrait;
    use HasTypeTrait;

    const AVAILABLE_TYPES = [
        'CPU'                 => 'cpu',
        'Mémoire vive'        => 'ram',
        'Carte graphique'     => 'graphicCard',
        'Boitier'             => 'case',
        'Alimentation'        => 'power',
        'Disque dur (ou SSD)' => 'hdd',
        'Carte mère'          => 'motherBoard',
        'Carte réseau'        => 'network',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Computer::class, mappedBy="components")
     */
    private $computers;

    public function __construct()
    {
        $this->computers = new ArrayCollection();
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Computer[]
     */
    public function getComputers(): Collection
    {
        return $this->computers;
    }

    public function addComputer(Computer $computer): self
    {
        if (!$this->computers->contains($computer)) {
            $this->computers[] = $computer;
            $computer->addComponent($this);
        }

        return $this;
    }

    public function removeComputer(Computer $computer): self
    {
        if ($this->computers->removeElement($computer)) {
            $computer->removeComponent($this);
        }

        return $this;
    }

    public function getTypes(): array
    {
        return self::AVAILABLE_TYPES;
    }

    public function getTypeLabel(): ?string
    {
        return array_search($this->getType(), self::AVAILABLE_TYPES);
    }

    public function __toString(): string
    {
        return (string) $this->getName().' ('.$this->getTypeLabel().')';
    }
}
