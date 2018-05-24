<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    /**
     * renvoyer les 50 films les plus récents
     *
     * @Route(
     *     "/api/v1/movies",
     *     methods={"get"},
     *     name="api_get_movies"
     * )
     */
    public function getMovies(Request $request)
    {
//        $minYear = $request->query->get('minYear'); pour avoir un paramètre en plus
            $token = $request->query->get('token');

        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
        $movies = $movieRepo->findBy([], ["dateCreated"=>"DESC"], 50);

        return $this->json($movies, 200, [
            "Access-Control-Allow-Origin" => "*"
        ]);
    }

    /**
     * renvoie un film
     *
     * @Route(
     *     "/api/v1/movies/{id}",
     *     methods={"get"},
     *     name="api_get_movie_detail"
     * )
     */
    public function getMovieDetail($id)
    {
        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
        $movie = $movieRepo->find($id);

        if (empty($movie)) {
            return $this->json([
                "status" => "error",
                "message" => "movie $id do not exists"
            ], 404);
        }

        return $this->json($movie);
    }
}
