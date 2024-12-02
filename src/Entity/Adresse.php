<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="adresse")
     */
    private $ville;

    public function __construct()
    {
        $this->ville = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getVille(): Collection
    {
        return $this->ville;
    }

    public function addVille(Personne $ville): self
    {
        if (!$this->ville->contains($ville)) {
            $this->ville[] = $ville;
            $ville->setAdresse($this);
        }

        return $this;
    }

    public function removeVille(Personne $ville): self
    {
        if ($this->ville->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getAdresse() === $this) {
                $ville->setAdresse(null);
            }
        }

        return $this;
    }
}
