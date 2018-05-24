<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchlistItemRepository")
 */
class WatchlistItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="watchlistitems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="watchlistitem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

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
}
