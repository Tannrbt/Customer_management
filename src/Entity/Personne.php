<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( 
     * min = 5, 
     * max = 50, 
     * minMessage = "Le nom doit comporter au moins {{ limit }} caractères", 
     * maxMessage = "Le nom doit comporter au plus {{ limit }} caractères" 
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\NotEqualTo( 
     * value = 0, 
     * message = "L'age ne doit pas être égal à 0 " 
     * )
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="ville")
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
