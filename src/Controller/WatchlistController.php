<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Entity\WatchlistItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WatchlistController extends Controller
{
    /**
     * @Route("/watchlist/{id_movie}", name="watchlist")
     */
    public function addMovieInWatchListItem($id_movie,
                                            Request $request,
                                            EntityManagerInterface $em)
    {
        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
        $movie = $movieRepo->find($id_movie);

        $author = $this->getUser();

        $watchlistitem = new WatchlistItem();

        $watchlistitem->setMovie($movie);
        $watchlistitem->setUser($author);
        $watchlistitem->setDateCreated(new \DateTime());
        $em->persist($watchlistitem);
        $em->flush();

        //Stocke un message et envoie un message
        $this->addFlash("success", "Your film has been added !");
        return $this->redirectToRoute('movie_detail', ["id" => $id_movie]);
    }

    /**
     * @Route("/watchlist/delete/{id_movie}", name="watchlistdelete")
     */
    public function removeMovieInWatchListItem($id_movie,
                                            Request $request,
                                            EntityManagerInterface $em)
    {

        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
        $movie = $movieRepo->find($id_movie);

        $user = $this->getUser();

        $watchlistitemRepo = $this->getDoctrine()->getRepository(WatchlistItem::class);
        $watchlistitem = $watchlistitemRepo->findOneBy(["movie"=>$movie, "User"=>$user]);

        $em->remove($watchlistitem);
        $em->flush();

        //Stocke un message et envoie un message
        $this->addFlash("success", "Your film has been removed !");
        return $this->redirectToRoute('movie_detail', ["id" => $id_movie]);
    }

    /**
     * @Route("/watchlist/view/", name="watchlistview")
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
