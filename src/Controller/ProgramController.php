<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
      * Correspond à la route /program/index et au name "_index"
      * @Route("/index", name="index")
      */
    public function index(): Response
    {
        
        return $this->render('program/index.html.twig', [
            'website' => 'Bienvenue!',
        ]);
    }

    
/**
     * @Route("/{page}", requirements={"page"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(int $page = 4): Response
    {
        return $this->render('program/show.html.twig', ['page' => $page]);
    }







}