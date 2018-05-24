<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"username"}, message="This username already exist !")
 * @UniqueEntity(fields={"email"}, message="You already have an account !")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    public function getSalt()
    {
        return null; //on a plus besoin de cette méthode
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        //Rien à faire :( inutile mais forcée par le UserInterface
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a username !")
     * @Assert\Length(
     *     max="30",
     *     maxMessage="Your username is too long dude ! 30 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $username;

    /**
     * @Assert\Email(message="Your email is not valid !")
     * @Assert\NotBlank(message="Please provide a email !")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Your email is too long dude ! 255 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Please provide a password !")
     * @Assert\Regex("/(?=.*[a-z])(?=.*[0-9]).{6,}/i")
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="Author", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WatchlistItem", mappedBy="User", orphanRemoval=true)
     */
    private $watchlistitems;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->watchlistitems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setAuthor($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getAuthor() === $this) {
                $review->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WatchlistItem[]
     */
    public function getWatchlistitems(): Collection
    {
        return $this->watchlistitems;
    }

    public function addWatchlistitem(WatchlistItem $watchlistitem): self
    {
        if (!$this->watchlistitems->contains($watchlistitem)) {
            $this->watchlistitems[] = $watchlistitem;
            $watchlistitem->setUser($this);
        }

        return $this;
    }

    public function removeWatchlistitem(WatchlistItem $watchlistitem): self
    {
        if ($this->watchlistitems->contains($watchlistitem)) {
            $this->watchlistitems->removeElement($watchlistitem);
            // set the owning side to null (unless already changed)
            if ($watchlistitem->getUser() === $this) {
                $watchlistitem->setUser(null);
            }
        }

        return $this;
    }
}
