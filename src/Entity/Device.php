<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use App\Traits\HasBrandTrait;
use App\Traits\HasDescriptionTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasPriceTrait;
use App\Traits\HasTimestampTrait;
use App\Traits\HasTypeTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    use HasBrandTrait;
    use HasDescriptionTrait;
    use HasNameTrait;
    use HasPriceTrait;
    use HasTimestampTrait;
    use HasTypeTrait;

    const AVAILABLE_TYPES = [
        'keyboard' => 'Clavier',
        'screen'   => 'Écran',
        'speaker'  => 'Enceintes',
        'mouse'    => 'Souris',
        'webcam'   => 'Webcam',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Computer::class, mappedBy="devices")
     */
    private $computers;

    public function __construct()
    {
        $this->created_at = new DateTime();
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
            $computer->addDevice($this);
        }

        return $this;
    }

    public function removeComputer(Computer $computer): self
    {
        if ($this->computers->removeElement($computer)) {
            $computer->removeDevice($this);
        }

        return $this;
    }
}
