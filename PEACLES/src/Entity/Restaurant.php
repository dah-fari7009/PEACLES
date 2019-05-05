<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant extends User
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("group1")
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_seats;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_seats;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price_range;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_resto")
     * @Groups("group1")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Specialty", inversedBy="restaurants")
     */
    private $specialties;

    public function __construct()
    {
        parent::__construct();
        $this->reservations = new ArrayCollection();
        $this->setRoles(['ROLE_RESTO']);
        $this->specialties = new ArrayCollection();
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
            $reservation->setIdResto($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getIdResto() === $this) {
                $reservation->setIdResto(null);
            }
        }

        return $this;
    }

    public function getAvailabilities()
    {
        return $this->getReservations()->matching(
            ReservationRepository::createAvailabilityCriteria()
        ); 
    }

    /**
     * @return Collection|Specialty[]
     */
    public function getSpecialties(): Collection
    {
        return $this->specialties;
    }

    public function addSpecialty(Specialty $specialty): self
    {
        if (!$this->specialties->contains($specialty)) {
            $this->specialties[] = $specialty;
        }

        return $this;
    }

    public function removeSpecialty(Specialty $specialty): self
    {
        if ($this->specialties->contains($specialty)) {
            $this->specialties->removeElement($specialty);
        }

        return $this;
    }
}