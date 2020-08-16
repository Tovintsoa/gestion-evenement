<?php

namespace App\Entity;

use App\Repository\PhotosEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosEvenementRepository::class)
 */
class PhotosEvenement
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
    private $imageEvenement;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="photosEvenement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evenements;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageEvenement(): ?string
    {
        return $this->imageEvenement;
    }

    public function setImageEvenement(string $imageEvenement): self
    {
        $this->imageEvenement = $imageEvenement;

        return $this;
    }

    public function getEvenements(): ?Evenement
    {
        return $this->evenements;
    }

    public function setEvenements(?Evenement $evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }
}
