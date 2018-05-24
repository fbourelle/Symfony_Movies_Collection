<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\User;
use App\Entity\WatchlistItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WatchlistItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method WatchlistItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method WatchlistItem[]    findAll()
 * @method WatchlistItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WatchlistItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WatchlistItem::class);
    }

    public function removeMovieInWatchListItem(Movie $movie, User $user)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->andWhere('r.movie = :movie' AND 'r.user = :user')
            ->setParameter('movie', $movie)
            ->setParameter('user', $user);

        return $qb->getQuery()->getSingleResult();
    }

}
