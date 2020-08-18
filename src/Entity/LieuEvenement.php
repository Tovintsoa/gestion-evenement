<?php

namespace App\Entity;

use App\Repository\LieuEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuEvenementRepository::class)
 */
class LieuEvenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomLieuEvenement;

    /**
     * @ORM\OneToMany(targetEntity=EvenementLieuEvenement::class, mappedBy="id_lieuEvenement")
     */
    private $evenementLieuEvenements;



    public function __construct()
    {
        $this->evenementLieuEvenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLieuEvenement(): ?string
    {
        return $this->nomLieuEvenement;
    }

    public function setNomLieuEvenement(string $nomLieuEvenement): self
    {
        $this->nomLieuEvenement = $nomLieuEvenement;

        return $this;
    }

    /**
     * @return Collection|EvenementLieuEvenement[]
     */
    public function getEvenementLieuEvenements(): Collection
    {
        return $this->evenementLieuEvenements;
    }

    public function addEvenementLieuEvenement(EvenementLieuEvenement $evenementLieuEvenement): self
    {
        if (!$this->evenementLieuEvenements->contains($evenementLieuEvenement)) {
            $this->evenementLieuEvenements[] = $evenementLieuEvenement;
            $evenementLieuEvenement->setIdLieuEvenement($this);
        }

        return $this;
    }

    public function removeEvenementLieuEvenement(EvenementLieuEvenement $evenementLieuEvenement): self
    {
        if ($this->evenementLieuEvenements->contains($evenementLieuEvenement)) {
            $this->evenementLieuEvenements->removeElement($evenementLieuEvenement);
            // set the owning side to null (unless already changed)
            if ($evenementLieuEvenement->getIdLieuEvenement() === $this) {
                $evenementLieuEvenement->setIdLieuEvenement(null);
            }
        }

        return $this;
    }

}
