<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Categorie;
use App\Repository\cateRepository;
use App\Repository\ProductsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ApiResource(formats={"json"})
 *
 * @ORM\Table(name="Produit")
 * @ORM\Entity(repositoryClass=cateRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"categorie" : "exact"})
 */

/**
 * @ApiResource(formats={"json"})
 *
 * @ORM\Table(name="Produit")
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"id" : "exact"})
 */


class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

/**
     * @var string
     * 
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;



      /**
     * @var string
     * 
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix;


     /**
     * @var string
     * 
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;


    /**
     * @var string
     * 
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="fiche", type="text", nullable=true)
     */
    private $fiche;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="text", nullable=true)
     */
    private $ref;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     * })
     */
    private $categorie;


     



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie( $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
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

    public function getFiche(): ?string
    {
        return $this->fiche;
    }

    public function setFiche(string $fiche): self
    {
        $this->fiche = $fiche;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString()
    {
        return $this->categorie;
    }



    }