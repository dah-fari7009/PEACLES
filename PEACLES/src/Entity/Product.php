<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("bts")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("bts")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("bts")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups("bts")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_resto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIdResto(): ?Restaurant
    {
        return $this->id_resto;
    }

    public function setIdResto(?Restaurant $id_resto): self
    {
        $this->id_resto = $id_resto;

        return $this;
    }
}
