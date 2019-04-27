<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client extends User
{
    /**
     * @ORM\Column(type="date")
     */
    private $bday;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="id_client")
     */
    private $reservations;

    public function __construct()
    {
        parent::__construct();
        $this->reservations = new ArrayCollection();
        $this->setRoles(['ROLE_CLIENT']);
    }
    
    public function getBday(): ?\DateTimeInterface
    {
        return $this->bday;
    }

    public function setBday(\DateTimeInterface $bday): self
    {
        $this->bday = $bday;

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
            $reservation->setClient($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getClient() === $this) {
                $reservation->setClient(null);
            }
        }

        return $this;
    }

}
