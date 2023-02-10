<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 *
 * @ORM\Table(name="Feedback")
 * @ORM\Entity
 */
class Feedback
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
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;



    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;



    /**
     * @var string
     *
     * @ORM\Column(name="feedback", type="text", nullable=false)
     */
    private $feedback;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $Date;


    public function __construct()
    {
        $this->Date = new \DateTime('now');
    }




    public function getId(): ?int
    {
        return $this->id;
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




    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }





    public function getFeedback()
    {
        return $this->feedback;
    }

    public function setFeedback(string $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }



}


