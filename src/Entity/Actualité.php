<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Joueur
 *
 * @ORM\Table(name="Actualité")
 * @ORM\Entity
 */
class Actualité
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
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;


     /**
     * @var string
     * 
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;


    /**
     * @var string
     * 
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    public function getText()
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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


    }
