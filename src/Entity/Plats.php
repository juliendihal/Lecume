<?php

namespace App\Entity;

use App\Repository\PlatsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlatsRepository::class)
 */
class Plats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champ 'nom' est vide")
     * @Assert\Length(min="3", max="50" , minMessage="Le titre doit contenir plus de 3 caractères." , maxMessage="Le titre doit contenir plus de 50 caractères.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix;


    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="plats")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=SubType::class, inversedBy="plats")
     */
    private $subtype;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSubtype()
    {
        return $this->subtype;
    }

    public function setSubtype( $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }


}
