<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: AdressesRepository::class)]
#[ApiResource]
class Adresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $numero = null;

    #[ORM\Column(length: 255)]
    private ?string $voierue = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $codepostal = null;

    #[ORM\ManyToMany(targetEntity: Clients::class, inversedBy: 'adresses')]
    private Collection $clientid;

    public function __construct()
    {
        $this->clientid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getVoierue(): ?string
    {
        return $this->voierue;
    }

    public function setVoierue(string $voierue): self
    {
        $this->voierue = $voierue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * @return Collection<int, Clients>
     */
    public function getClientid(): Collection
    {
        return $this->clientid;
    }

    public function addClientid(Clients $clientid): self
    {
        if (!$this->clientid->contains($clientid)) {
            $this->clientid->add($clientid);
        }

        return $this;
    }

    public function removeClientid(Clients $clientid): self
    {
        $this->clientid->removeElement($clientid);

        return $this;
    }
}
