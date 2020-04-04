<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", inversedBy="panier", cascade={"persist", "remove"})
     */
    private $client_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit")
     */
    private $produit_id;



    public function __construct()
    {
        $this->produit_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduitId(): Collection
    {
        return $this->produit_id;
    }

    public function addProduitId(Produit $produitId): self
    {
        if (!$this->produit_id->contains($produitId)) {
            $this->produit_id[] = $produitId;
        }
        return $this;
    }

    public function removeProduitId(Produit $produitId): self
    {
        if ($this->produit_id->contains($produitId)) {
            $this->produit_id->removeElement($produitId);
        }
        return $this;
    }


}
