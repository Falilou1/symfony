<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
      * Show all rows from Program's entity
      *
      * @Route("/", name="index")
      * @return Response A response instance
      */
    public function index(): Response
    {
        
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        return $this->render(
            'program/index.html.twig',
             ['programs' => $programs]
            );
    }

    
    /**
    * Getting all category
    * 
    * @Route("/show/{id}", name="show")
    *@return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        
        $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findAll();

        if (!$seasons) {
            throw $this->createNotFoundException(
                'No season with id : '.$id.' found in season\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'seasons' => $seasons, 'program' => $program
        ]);
    }
    /**
    * Getting all showSeason
    * 
    * @Route("/{programId}/season/{seasonId}", name="season_show")
    *@return Response
     */
    public function showSeason(program $programId,  $seasonId): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $programId]);


        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy(['id' => $seasonId]);
        
        $episodes = $season->getEpisodes();

        return $this->render('program/season_show.html.twig', [
            'program' => $program, 'season' => $season, 'episodes' => $episodes
        ]);
    }
 
}