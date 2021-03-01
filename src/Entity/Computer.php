<?php

namespace App\Entity;

use App\Repository\ComputerRepository;
use App\Traits\HasDescriptionTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasTimestampTrait;
use App\Traits\HasTypeTrait;
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

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Device::class, inversedBy="computers")
     * @ORM\JoinTable(name="computer_has_device")
     */
    private $devices;

    /**
     * @ORM\ManyToMany(targetEntity=Component::class, inversedBy="computers")
     * @ORM\JoinTable(name="computer_has_component")
     */
    private $components;

    public function __construct()
    {
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
}
