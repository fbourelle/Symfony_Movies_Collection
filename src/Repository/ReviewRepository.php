<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findMovieReviewsWithUser(Movie $movie)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->andWhere('r.movie = :movie')
            ->setParameter('movie', $movie);

        $qb->join('r.Author', 'a')
            ->addSelect('a');
        return $qb->getQuery()->getResult();
    }

}
