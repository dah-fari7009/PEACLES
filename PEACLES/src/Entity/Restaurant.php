<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pwd;

    /**
     * @ORM\Column(type="bigint")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_seats;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_seats;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profile_pic;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_range;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="reservations")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(string $pwd): self
    {
        $this->pwd = $pwd;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->min_age;
    }

    public function setMinAge(?int $min_age): self
    {
        $this->min_age = $min_age;

        return $this;
    }

    public function getMinSeats(): ?int
    {
        return $this->min_seats;
    }

    public function setMinSeats(?int $min_seats): self
    {
        $this->min_seats = $min_seats;

        return $this;
    }

    public function getMaxSeats(): ?int
    {
        return $this->max_seats;
    }

    public function setMaxSeats(int $max_seats): self
    {
        $this->max_seats = $max_seats;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    public function setProfilePic(?string $profile_pic): self
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    public function getPriceRange(): ?int
    {
        return $this->price_range;
    }

    public function setPriceRange(int $price_range): self
    {
        $this->price_range = $price_range;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setReservations($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getReservations() === $this) {
                $reservation->setReservations(null);
            }
        }

        return $this;
    }
}