<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Entity\User;
use App\Entity\WatchlistItem;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{

    /**
     * @Route("/movie/{id}", name="movie_detail")
     */
    public function detail($id,
                           Request $request,
                            EntityManagerInterface $em)
    {
        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
        $movie = $movieRepo->find($id);


        $reviewRepo = $this->getDoctrine()->getRepository(Review::class);
        $reviews = $reviewRepo->findMovieReviewsWithUser($movie);



        //crée une nouvelle review vide
        $review = new Review();
        //crée le formulaire en lui associant notre review vide
        $reviewForm = $this->createForm(ReviewType::class, $review);

        //Prend les données envoyées et les injecte dans $review
        $reviewForm->handleRequest($request);


        $author = $this->getUser();
        $review->setAuthor($author);

        $watchlistitemRepo = $this->getDoctrine()->getRepository(WatchlistItem::class);
        $watchlistitem = $watchlistitemRepo->findOneBy(["movie"=>$movie, "User"=>$author]);

        $is_watchlistitem = false;

        if ($watchlistitem) {
            $is_watchlistitem = true;
        }

        //Renseigne programmatiqement la date de création
        $review->setDateCreated(new \DateTime());
        //et l'associe au film
        $review->setMovie($movie);

        //si le formulaire est soumis && si il est valide
        if ($reviewForm->isSubmitted() && $reviewForm->isValid() && $this->getUser()) {
            //on sauvegarde l'entité en BDD
            $em->persist($review);
            $em->flush();
//            $em->persist($author);
//            $em->flush();
            //Stocke un message et envoie un message
            $this->addFlash("success", "Your review has been published !");
            return $this->redirectToRoute('movie_detail', ["id" => $id]);
        }

        return $this->render('movie/detail.html.twig', [
            "movie" => $movie,
            "reviewForm" => $reviewForm->createView(),
            "is_watchlistitem" => $is_watchlistitem
        ]);
    }

    /**
     * @Route("/watchlist/view/{id}", name="watchlistview")
     */
    public function viewMovieInWatchListItem(
        Request $request,
        EntityManagerInterface $em)
    {

        $user = $this->getUser();

        $watchlistitemRepo = $this->getDoctrine()->getRepository(WatchlistItem::class);
        $watchlistitems = $watchlistitemRepo->findBy(["User" => $user]);

        return $this->render('watchlist/index.html.twig', [
            "watchlistitems" => $watchlistitems,
        ]);
    }

}
