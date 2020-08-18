<?php

namespace App\Entity;

use App\Repository\EvenementLieuEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementLieuEvenementRepository::class)
 */
class EvenementLieuEvenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="evenementLieuEvenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_evenement;

    /**
     * @ORM\ManyToOne(targetEntity=LieuEvenement::class, inversedBy="evenementLieuEvenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_lieuEvenement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseEvenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEvenement(): ?Evenement
    {
        return $this->id_evenement;
    }

    public function setIdEvenement(?Evenement $id_evenement): self
    {
        $this->id_evenement = $id_evenement;

        return $this;
    }

    public function getIdLieuEvenement(): ?LieuEvenement
    {
        return $this->id_lieuEvenement;
    }

    public function setIdLieuEvenement(?LieuEvenement $id_lieuEvenement): self
    {
        $this->id_lieuEvenement = $id_lieuEvenement;

        return $this;
    }

    public function getAdresseEvenement(): ?string
    {
        return $this->adresseEvenement;
    }

    public function setAdresseEvenement(?string $adresseEvenement): self
    {
        $this->adresseEvenement = $adresseEvenement;

        return $this;
    }
}
