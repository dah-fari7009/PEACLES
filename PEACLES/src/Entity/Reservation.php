<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("group1")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reservations")
     */
    private $id_client;
    /**
     * @ORM\Column(type="date")
     * @Groups("group1")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     * @Groups("group1")
     */
    private $start;

    /**
     * @ORM\Column(type="time")
     * @Groups("group1")
     */
    private $end;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="reservations")
     */
    private $id_resto;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReservationInfos", inversedBy="id_res", cascade={"persist", "remove"})
     */
    private $infos;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getIdClient(): ?Client
    {
        return $this->id_client;
    }

    public function setIdClient(?Client $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getInfos(): ?ReservationInfos
    {
        return $this->infos;
    }

    public function setInfos(?ReservationInfos $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    
}
