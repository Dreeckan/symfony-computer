<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use App\Traits\HasBrandTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasPriceTrait;
use App\Traits\HasTimestampTrait;
use App\Traits\HasTypeTrait;
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
}
