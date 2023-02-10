<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Joueur
 *
 * @ORM\Table(name="Contact")
 * @ORM\Entity
 */
class Contact
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
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;


    /**
     * @var string
     *
     * @ORM\Column(name="machine", type="string",length=255, nullable=false)
     */
    private $machine;

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

    /**
     * @return string
     */
    public function getMachine(): string
    {
        return $this->machine;
    }

    /**
     * @param string $machine
     */
    public function setMachine(string $machine): void
    {
        $this->machine = $machine;
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





    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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


