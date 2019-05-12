<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\ReservationRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

$classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *      fields={"email"},
 *      message=" You know, you could just sign in instead ..."
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr",type="string")
 * @ORM\DiscriminatorMap({"client" = "Client" , "resto" = "Restaurant" })
 */
abstract class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("group1")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("group1")
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $bio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $profile_pic;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="owner", orphanRemoval=true)
     */
    private $pictures;

    public function __construct()
    {

        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $name): self
    {
        $this->username = $name;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $pwd): self
    {
        $this->password = $pwd;

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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

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

    public function getRoles(): array
    {
        $roles = $this->roles;

        // il est obligatoire d'avoir au moins un rôle si on est authentifié, par convention c'est ROLE_USER
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return [];
    }


    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setOwner($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getOwner() === $this) {
                $picture->setOwner(null);
            }
        }

        return $this;
    }

   /* public function getReservationHistory(): Collection
    {
       return $this->getReservations()->filter(function(Reservation $reservation){
           return $reservation->date <= new DateTime('today')&& $reservation->end < new Time('now');
       }) ;
    }
*/
    public function getReservationHistory(): Collection
    {
       return $this->getReservations()->matching(
           ReservationRepository::createPastReservationCriteria()
       );
    }

    public function getUpcomingReservations(): Collection
    {
        return $this->getReservations()->matching(
            ReservationRepository::createUpcomingReservationCriteria()
        ); 
    }
}
