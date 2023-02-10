<?php

namespace App\Entity;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;



/**
 * @ApiResource(formats={"json"})
 *
 * @ORM\Table(name="Categorie")
 * @ORM\Entity
 * @ApiFilter(SearchFilter::class, properties={"nomC" : "exact"})
 */
class Categorie
{
    /**
     * @var int
     *@ORM\OneToMany(targetEntity="Produit")
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


     /**
     * @var string
     *
     * @ORM\Column(name="nomC", type="string", length=254, nullable=false)
     */
    private $nomC;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $NomC): self
    {
        $this->nomC = $NomC;

        return $this;
    }
    public function __toString(): string
    {
        return $this->id;
    }

    }

