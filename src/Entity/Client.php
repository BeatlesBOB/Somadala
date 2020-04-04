<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @UniqueEntity(
 *     fields={"mail"},
 *     message="L'utilisateur existe déja"
 * )
 */
class Client implements UserInterface
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères")
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Panier", mappedBy="client_id", cascade={"persist", "remove"})
     */
    private $panier;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    private $rolesToSting;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questions", mappedBy="client")
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

        // set (or unset) the owning side of the relation if necessary
        $newClient_id = null === $panier ? null : $this;
        if ($panier->getClientId() !== $newClient_id) {
            $panier->setClientId($newClient_id);
        }

        return $this;
    }



    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getRoles()
    {
        return array($this->roles);
    }

    public function getRolesToString()
    {
        return $this->roles;
    }


    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->mdp;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->nom;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRolesToString(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Questions[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setClient($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getClient() === $this) {
                $question->setClient(null);
            }
        }

        return $this;
    }




}
