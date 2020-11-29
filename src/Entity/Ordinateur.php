<?php

namespace App\Entity;

use App\Repository\OrdinateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdinateurRepository::class)
 */
class Ordinateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Attribution::class, mappedBy="ordinateur", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $attributions;

    public function __construct()
    {
        $this->attributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Attribution[]
     */
    public function getAttribution(): ?Collection
    {
        return $this->attributions;
    }

    public function addAttribution(Attribution $attribution): ?self
    {
        if (!$this->attributions->contains($attribution)) {
            $this->attributions[] = $attribution;
            $attribution->setOrdinateur($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): ?self
    {
        if ($this->attributions->contains($attribution)) {
            $this->attributions->removeElement($attribution);
            // set the owning side to null (unless already changed)
            if ($attribution->getOrdinateur() === $this) {
                $attribution->setOrdinateur(null);
            }
        }

        return $this;
    }
}
