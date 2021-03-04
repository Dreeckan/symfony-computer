<?php

namespace App\Entity;

use App\Repository\ComputerRepository;
use App\Traits\HasDescriptionTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasTimestampTrait;
use App\Traits\HasTypeTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComputerRepository::class)
 */
class Computer
{
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;
    use HasTypeTrait;

    const AVAILABLE_TYPES = [
        'desktop' => 'Ordinateur de bureau',
        'laptop'  => 'Ordinateur portable',
        'tablet'  => 'Tablette',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Device::class, inversedBy="computers", cascade={"persist"})
     * @ORM\JoinTable(name="computer_has_device")
     */
    private $devices;

    /**
     * @ORM\ManyToMany(targetEntity=Component::class, inversedBy="computers", cascade={"persist"})
     * @ORM\JoinTable(name="computer_has_component")
     */
    private $components;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->devices = new ArrayCollection();
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        $this->devices->removeElement($device);

        return $this;
    }

    /**
     * @return Collection|Component[]
     */
    public function getComponents(): Collection
    {
        return $this->components;
    }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        $this->components->removeElement($component);

        return $this;
    }

    public function getTypes(): array
    {
        return array_flip(self::AVAILABLE_TYPES);
    }

    public function getPrice(): float
    {
        $price = 0;
        foreach ($this->getComponents() as $component) {
            $price += $component->getRealPrice();
        }

        foreach ($this->getDevices() as $device) {
            $price += $device->getRealPrice();
        }
        return $price;
    }

    public function getTypeLabel(): ?string
    {
        if (empty(self::AVAILABLE_TYPES[$this->getType()])) {
            return null;
        }
        return self::AVAILABLE_TYPES[$this->getType()];
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        // Je parcours tous les types de périphériques qui doivent être associés à mon ordinateur
        foreach (Device::AVAILABLE_TYPES as $type => $name) {
            // Pour chaque type, je cherche les périphériques associés ayant le type $type
            $devicesOfType = [];
            /** @var Device $device */
            foreach ($this->getDevices() as $device) {
                if ($device->getType() == $type) {
                    $devicesOfType[] = $device;
                }
            }

            // S'il n'y pas pas (ou qu'il y a trop) de périphérique de ce type, mon ordinateur n'est pas complet / pas valide
            if (count($devicesOfType) != 1) {
                return false;
            }
        }

        // Je fais de même avec les composants associés à mon ordinateur
        foreach (Component::AVAILABLE_TYPES as $name => $type) {
            // Pour chaque type, je cherche les composants associés ayant le type $type
            $componentsOfType = [];
            /** @var Component $component */
            foreach ($this->getComponents() as $component) {
                if ($component->getType() == $type) {
                    $componentsOfType[] = $component;
                }
            }

            // S'il n'y pas pas (ou qu'il y a trop) de composant de ce type, mon ordinateur n'est pas complet / pas valide
            if (count($componentsOfType) != 1) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
