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
     * @ORM\ManyToMany(targetEntity=TypeEvenement::class, inversedBy="evenements")
     */
    private $type_evenement;

    /**
     * @ORM\OneToMany(targetEntity=EvenementLieuEvenement::class, mappedBy="id_evenement")
     */
    private $evenementLieuEvenements;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur_evenement_id;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="interesseEvnements")
     */
    private $interesseEvenement;











    public function __construct()
    {
        $this->photosEvenement = new ArrayCollection();
        $this->type_evenement = new ArrayCollection();
        $this->evenementLieuEvenements = new ArrayCollection();
        $this->interesseEvenement = new ArrayCollection();

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



    public function __toString() {
        return (string) $this->getId();
    }



    /**
     * @return Collection|TypeEvenement[]
     */
    public function getTypeEvenement(): Collection
    {
        return $this->type_evenement;
    }

    public function addTypeEvenement(TypeEvenement $typeEvenement): self
    {
        if (!$this->type_evenement->contains($typeEvenement)) {
            $this->type_evenement[] = $typeEvenement;
        }

        return $this;
    }

    public function removeTypeEvenement(TypeEvenement $typeEvenement): self
    {
        if ($this->type_evenement->contains($typeEvenement)) {
            $this->type_evenement->removeElement($typeEvenement);
        }

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
            $evenementLieuEvenement->setIdEvenement($this);
        }

        return $this;
    }

    public function removeEvenementLieuEvenement(EvenementLieuEvenement $evenementLieuEvenement): self
    {
        if ($this->evenementLieuEvenements->contains($evenementLieuEvenement)) {
            $this->evenementLieuEvenements->removeElement($evenementLieuEvenement);
            // set the owning side to null (unless already changed)
            if ($evenementLieuEvenement->getIdEvenement() === $this) {
                $evenementLieuEvenement->setIdEvenement(null);
            }
        }

        return $this;
    }

    public function getCreateurEvenementId(): ?Utilisateur
    {
        return $this->createur_evenement_id;
    }

    public function setCreateurEvenementId(?Utilisateur $createur_evenement_id): self
    {
        $this->createur_evenement_id = $createur_evenement_id;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getInteresseEvenement(): Collection
    {
        return $this->interesseEvenement;
    }

    public function addInteresseEvenement(Utilisateur $interesseEvenement): self
    {
        if (!$this->interesseEvenement->contains($interesseEvenement)) {
            $this->interesseEvenement[] = $interesseEvenement;
        }

        return $this;
    }

    public function removeInteresseEvenement(Utilisateur $interesseEvenement): self
    {
        if ($this->interesseEvenement->contains($interesseEvenement)) {
            $this->interesseEvenement->removeElement($interesseEvenement);
        }

        return $this;
    }

}
