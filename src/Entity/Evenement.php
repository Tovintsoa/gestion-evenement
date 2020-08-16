<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
    private $nomEvenement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionEvenement;

    /**
     * @ORM\Column(type="float")
     */
    private $budgetEvenement;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebutEvenement;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFinEvenement;


    /**
     * @ORM\OneToMany(targetEntity=PhotosEvenement::class, mappedBy="evenements", orphanRemoval=true)
     */
    private $photosEvenement;

    /**
     * @ORM\Column(type="json")
     */
    private $lieu_evenement = [];

    /**
     * @ORM\Column(type="json")
     */
    private $type_evenement = [];

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="evenements")
     */
    private $createurEvenement;











    public function __construct()
    {
        $this->photosEvenement = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): self
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getDescriptionEvenement(): ?string
    {
        return $this->descriptionEvenement;
    }

    public function setDescriptionEvenement(string $descriptionEvenement): self
    {
        $this->descriptionEvenement = $descriptionEvenement;

        return $this;
    }

    public function getBudgetEvenement(): ?float
    {
        return $this->budgetEvenement;
    }

    public function setBudgetEvenement(float $budgetEvenement): self
    {
        $this->budgetEvenement = $budgetEvenement;

        return $this;
    }



    public function getDateDebutEvenement(): ?\DateTimeInterface
    {
        return $this->dateDebutEvenement;
    }

    public function setDateDebutEvenement(\DateTimeInterface $dateDebutEvenement): self
    {
        $this->dateDebutEvenement = $dateDebutEvenement;

        return $this;
    }

    public function getDateFinEvenement(): ?\DateTimeInterface
    {
        return $this->dateFinEvenement;
    }

    public function setDateFinEvenement(?\DateTimeInterface $dateFinEvenement): self
    {
        $this->dateFinEvenement = $dateFinEvenement;

        return $this;
    }

    /**
     * @return Collection|PhotosEvenement[]
     */
    public function getPhotosEvenement(): Collection
    {
        return $this->photosEvenement;
    }

    public function addPhotosEvenement(PhotosEvenement $photosEvenement): self
    {
        if (!$this->photosEvenement->contains($photosEvenement)) {
            $this->photosEvenement[] = $photosEvenement;
            $photosEvenement->setEvenements($this);
        }

        return $this;
    }

    public function removePhotosEvenement(PhotosEvenement $photosEvenement): self
    {
        if ($this->photosEvenement->contains($photosEvenement)) {
            $this->photosEvenement->removeElement($photosEvenement);
            // set the owning side to null (unless already changed)
            if ($photosEvenement->getEvenements() === $this) {
                $photosEvenement->setEvenements(null);
            }
        }

        return $this;
    }

    public function getLieuEvenement(): ?array
    {
        return $this->lieu_evenement;
    }

    public function setLieuEvenement(array $lieu_evenement): self
    {
        $this->lieu_evenement = $lieu_evenement;

        return $this;
    }

    public function getTypeEvenement(): ?array
    {
        return $this->type_evenement;
    }

    public function setTypeEvenement(array $type_evenement): self
    {
        $this->type_evenement = $type_evenement;

        return $this;
    }

    public function __toString() {
        return (string) $this->getId();
    }

    public function getCreateurEvenement(): ?Utilisateur
    {
        return $this->createurEvenement;
    }

    public function setCreateurEvenement(?Utilisateur $createurEvenement): self
    {
        $this->createurEvenement = $createurEvenement;

        return $this;
    }

}
