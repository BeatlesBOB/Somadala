<?php


namespace App\Entity;


class ProduitSearch
{


    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var Theme|null
     */
    private $theme;

    /**
     * @var int|null
     */
    private $minPrix;

    /**
     * @var int|null
     */
    private $maxPrix;

    /**
     * @return int|null
     */
    public function getMaxPrix(): ?int
    {
        return $this->maxPrix;
    }

    /**
     * @param int|null $maxPrix
     */
    public function setMaxPrix(?int $maxPrix): void
    {
        $this->maxPrix = $maxPrix;
    }

    /**
     * @return int|null
     */
    public function getMinPrix(): ?int
    {
        return $this->minPrix;
    }

    /**
     * @param int|null $maxPrix
     */
    public function setMinPrix(?int $minPrix): void
    {
        $this->minPrix = $minPrix;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }


    /**
     * @return Theme|null
     */
    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    /**
     * @param Theme|null $theme
     */
    public function setTheme(?Theme $theme): void
    {
        $this->theme = $theme;
    }


}