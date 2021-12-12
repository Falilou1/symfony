<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/actor/{id}", name="actor_show")
     */
    public function show(Actor $actor): Response
    {
       // $actors = $program->getActors();
         $programs = $actor->getPrograms();

        return $this->render("actor/show.html.twig", [
             'programs' => $programs, 'actor' => $actor
        ]);
    }
    /**
     * @Route("/actor", name="actor_index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();

        return $this->render('actor/index.html.twig', [
            'actors' => $actors
        ]);
    }






}
