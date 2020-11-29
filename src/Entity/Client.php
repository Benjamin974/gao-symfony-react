<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity=Attribution::class, mappedBy="client", cascade={"persist", "remove"}, orphanRemoval=true)
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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
            $attribution->setClient($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): ?self
    {
        if ($this->attributions->contains($attribution)) {
            $this->attributions->removeElement($attribution);
            // set the owning side to null (unless already changed)
            if ($attribution->getClient() === $this) {
                $attribution->setClient(null);
            }
        }

        return $this;
    }
}
