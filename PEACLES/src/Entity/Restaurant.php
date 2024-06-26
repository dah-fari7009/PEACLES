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
     * @ORM\Column(name="min_age", type="integer", options={"default" : 0})
     */
    private $min_age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\Column(name="min_seats", type="integer", options={"default" : 1})
     */
    private $min_seats;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\Column(name="max_seats", type="integer", options={"default" : 40})
     */
    private $max_seats;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_resto")
     * @Groups("group1")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Specialty", inversedBy="restaurants")
     */
    private $specialties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="id_resto", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location", mappedBy="id_resto", cascade={"persist", "remove"})
     */
    private $location;

    public function __construct()
    {
        parent::__construct();
        $this->reservations = new ArrayCollection();
        $this->setRoles(['ROLE_RESTO']);
        $this->specialties = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    /*public function getAvailabilitiesOnDate($date)
    {
        return $this->getReservations()->matching(
            ReservationRepository::createAvailOnDateCriteria()
        );
    }*/

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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setIdResto($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getIdResto() === $this) {
                $product->setIdResto(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        // set the owning side of the relation if necessary
        if ($this !== $location->getIdResto()) {
            $location->setIdResto($this);
        }

        return $this;
    }
}