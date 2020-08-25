<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity("mailUtilisateur")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $mailUtilisateur;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeNaissanceUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="createur_evenement_id")
     */
    private $evenements;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginUtilisateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activation_compte;

    /**
     * @ORM\ManyToMany(targetEntity=Evenement::class, mappedBy="interesseEvenement")
     */
    private $interesseEvnements;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $token_expired_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_societe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nif_societe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stat_societe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siege_societe;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->interesseEvnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->mailUtilisateur;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateDeNaissanceUtilisateur(): ?\DateTimeInterface
    {
        return $this->dateDeNaissanceUtilisateur;
    }

    public function setDateDeNaissanceUtilisateur(?\DateTimeInterface $dateDeNaissanceUtilisateur): self
    {
        $this->dateDeNaissanceUtilisateur = $dateDeNaissanceUtilisateur;

        return $this;
    }

    public function getAdresseUtilisateur(): ?string
    {
        return $this->adresseUtilisateur;
    }

    public function setAdresseUtilisateur(?string $adresseUtilisateur): self
    {
        $this->adresseUtilisateur = $adresseUtilisateur;

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
            $evenement->setCreateurEvenementId($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getCreateurEvenementId() === $this) {
                $evenement->setCreateurEvenementId(null);
            }
        }

        return $this;
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

    public function setPrenomUtilisateur(?string $prenomUtilisateur): self
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

    public function getActivationCompte(): ?bool
    {
        return $this->activation_compte;
    }

    public function setActivationCompte(bool $activation_compte): self
    {
        $this->activation_compte = $activation_compte;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getInteresseEvnements(): Collection
    {
        return $this->interesseEvnements;
    }

    public function addInteresseEvnement(Evenement $interesseEvnement): self
    {
        if (!$this->interesseEvnements->contains($interesseEvnement)) {
            $this->interesseEvnements[] = $interesseEvnement;
            $interesseEvnement->addInteresseEvenement($this);
        }

        return $this;
    }

    public function removeInteresseEvnement(Evenement $interesseEvnement): self
    {
        if ($this->interesseEvnements->contains($interesseEvnement)) {
            $this->interesseEvnements->removeElement($interesseEvnement);
            $interesseEvnement->removeInteresseEvenement($this);
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenExpiredAt(): ?\DateTimeInterface
    {
        return $this->token_expired_at;
    }

    public function setTokenExpiredAt(?\DateTimeInterface $token_expired_at): self
    {
        $this->token_expired_at = $token_expired_at;

        return $this;
    }
    public function resetTokenExpiredAt(): self
    {
        $this->token_expired_at = null;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nom_societe;
    }

    public function setNomSociete(?string $nom_societe): self
    {
        $this->nom_societe = $nom_societe;

        return $this;
    }

    public function getNifSociete(): ?string
    {
        return $this->nif_societe;
    }

    public function setNifSociete(?string $nif_societe): self
    {
        $this->nif_societe = $nif_societe;

        return $this;
    }

    public function getStatSociete(): ?string
    {
        return $this->stat_societe;
    }

    public function setStatSociete(?string $stat_societe): self
    {
        $this->stat_societe = $stat_societe;

        return $this;
    }

    public function getSiegeSociete(): ?string
    {
        return $this->siege_societe;
    }

    public function setSiegeSociete(?string $siege_societe): self
    {
        $this->siege_societe = $siege_societe;

        return $this;
    }
}
