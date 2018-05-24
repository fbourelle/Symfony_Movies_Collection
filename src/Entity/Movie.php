<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie implements \JsonSerializable
{

    //cette fonction sera appelée lorsqu(on va convertir
    public function jsonSerialize()
    {
        // pour tout retourner :
        return get_object_vars($this);

//        return [
//            "id" => $this->getId(),
//            "title" => $this->getTitle(),
//            "year"=> $this->getYear(),
//            "rating"=> $this->getRating(),
//            "plot" => $this->getPlot()
//        ];
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $actors;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $directors;

    /**
     * @ORM\Column(type="text")
     */
    private $plot;

    /**
     * @ORM\Column(type="float", scale=2, precision=1)
     */
    private $rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $runtime;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $trailerId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="movie", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WatchlistItem", mappedBy="movie", orphanRemoval=true)
     */
    private $watchlistitem;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->watchlistitem = new ArrayCollection();
    }

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
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getGenres(): ?string
    {
        return $this->genres;
    }

    public function setGenres(string $genres): self
    {
        $this->genres = $genres;

        return $this;
    }

    public function getActors(): ?string
    {
        return $this->actors;
    }

    public function setActors(string $actors): self
    {
        $this->actors = $actors;

        return $this;
    }

    public function getDirectors(): ?string
    {
        return $this->directors;
    }

    public function setDirectors(string $directors): self
    {
        $this->directors = $directors;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    public function setRuntime(int $runtime): self
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getTrailerId(): ?string
    {
        return $this->trailerId;
    }

    public function setTrailerId(string $trailerId): self
    {
        $this->trailerId = $trailerId;

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
            $review->setMovie($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getMovie() === $this) {
                $review->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WatchlistItem[]
     */
    public function getWatchlistitem(): Collection
    {
        return $this->watchlistitem;
    }

    public function addWatchlistitem(WatchlistItem $watchlistitem): self
    {
        if (!$this->watchlistitem->contains($watchlistitem)) {
            $this->watchlistitem[] = $watchlistitem;
            $watchlistitem->setMovie($this);
        }

        return $this;
    }

    public function removeWatchlistitem(WatchlistItem $watchlistitem): self
    {
        if ($this->watchlistitem->contains($watchlistitem)) {
            $this->watchlistitem->removeElement($watchlistitem);
            // set the owning side to null (unless already changed)
            if ($watchlistitem->getMovie() === $this) {
                $watchlistitem->setMovie(null);
            }
        }

        return $this;
    }
}
