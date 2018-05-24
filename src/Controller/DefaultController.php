<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/{page}",
     *     name="home",
     *     defaults={"page":"1"},
     *     requirements={"page":"\d+"}
     *     )
     */
    public function home($page = 1)
    {
        $movieRepo = $this->getDoctrine()->getRepository(Movie::class);
//        //
//        $movies = $movieRepo->findBy(
//            [], //clauses where
//            ["rating" => "DESC", "year" => "DESC"], //order by
//            50, //limit
//            0); //offset

        $movies = $movieRepo->finAllIds($page);

//        echo count($movies);
        dump($movies);
//        die();

        return $this->render("default/home.html.twig", [
            "movies" => $movies,
            "page" => $page,
            "nextPage" => $page+1,
            "prevPage" => $page-1,
            "totalResults" => count($movies),
            "lastPage" => ceil(count($movies) / 50)
        ]);
    }

    /**
     * @Route("/legal-stuff", name="legal_stuff")
     */
    public function legalStuff()
    {
        return $this->render("default/legal.html.twig");
    }

    /**
     * @Route("/about-us", name="about_us")
     */
    public function aboutUs()
    {
        return $this->render("default/about.html.twig");
    }
}
