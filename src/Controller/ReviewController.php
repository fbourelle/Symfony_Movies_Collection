<?php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ReviewController extends Controller
{
    /**
     * @Route("/review/{id}/delete", name="delete_review")
     */
    public function index($id,
                          Request $request,
                          EntityManagerInterface $em)
    {
        $reviewRepo = $this->getDoctrine()->getRepository(Review::class);
        $review = $reviewRepo->find($id);
        $id_movie = $review->getMovie()->getId();

        $em->remove($review);
        $em->flush();
        $this->addFlash("success", "Your review has been removed !");
        return $this->redirectToRoute('movie_detail', ["id" => $id_movie]);
    }
}
