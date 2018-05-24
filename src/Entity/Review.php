<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a title !")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Your title is too long dude ! 255 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    /**
     * @Assert\NotBlank(message="Please provide a review !")
     * @Assert\Length(
     *     max="4000",
     *     maxMessage="Your title is too long dude ! 255 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = strip_tags($title);

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
}
