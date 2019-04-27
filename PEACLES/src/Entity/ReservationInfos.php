<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationInfosRepository")
 */
class ReservationInfos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $people;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", mappedBy="infos", cascade={"persist", "remove"})
     */
    private $id_res;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPeople(): ?int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getIdRes(): ?Reservation
    {
        return $this->id_res;
    }

    public function setIdRes(?Reservation $id_res): self
    {
        $this->id_res = $id_res;

        // set (or unset) the owning side of the relation if necessary
        $newInfos = $id_res === null ? null : $this;
        if ($newInfos !== $id_res->getInfos()) {
            $id_res->setInfos($newInfos);
        }

        return $this;
    }
}
