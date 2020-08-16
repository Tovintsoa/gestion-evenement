<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motdepasseUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="createurEvenement")
     */
    private $evenements;



    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(?string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public function getLoginUtilisateur(): ?string
    {
        return $this->loginUtilisateur;
    }

    public function setLoginUtilisateur(string $loginUtilisateur): self
    {
        $this->loginUtilisateur = $loginUtilisateur;

        return $this;
    }

    public function getMailUtilisateur(): ?string
    {
        return $this->mailUtilisateur;
    }

    public function setMailUtilisateur(string $mailUtilisateur): self
    {
        $this->mailUtilisateur = $mailUtilisateur;

        return $this;
    }

    public function getTelephoneUtilisateur(): ?string
    {
        return $this->telephoneUtilisateur;
    }

    public function setTelephoneUtilisateur(?string $telephoneUtilisateur): self
    {
        $this->telephoneUtilisateur = $telephoneUtilisateur;

        return $this;
    }

    public function getMotdepasseUtilisateur(): ?string
    {
        return $this->motdepasseUtilisateur;
    }

    public function setMotdepasseUtilisateur(string $motdepasseUtilisateur): self
    {
        $this->motdepasseUtilisateur = $motdepasseUtilisateur;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setCreateurEvenement($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getCreateurEvenement() === $this) {
                $evenement->setCreateurEvenement(null);
            }
        }

        return $this;
    }



}
