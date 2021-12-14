<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;

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
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
         // Get data from HTTP request
         $form->handleRequest($request);
        
         // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager 
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Program Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to program list
          return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }

    /**
    * Getting all category
    * 
    * @Route("/show/{id}", name="show")
    
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
        $actors = $program->getActors();

        $seasons = $program->getSeasons();

        if (!$seasons) {
            throw $this->createNotFoundException(
                'No season with id : '.$id.' found in season\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'seasons' => $seasons, 'program' => $program, 'actors' => $actors
        ]);
    }
    /**
    * Getting all showSeason
    * 
    * @Route("/{program_Id}/season/{season_Id}", name="season_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_Id": "id"}})
     *@ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_Id": "id"}})

     */
    public function showSeason(program $program, season $season): Response
    {
        $episodes = $season->getEpisodes();


        return $this->render('program/season_show.html.twig', [
            'program' => $program, 'season' => $season, 'episodes' => $episodes
        ]);
    }
    /** 
    *@Route("/{program_Id}/season/{season_Id}/episode/{episode_Id}", name="episodes_show")
    *@ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_Id": "id"}})
    *@ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_Id": "id"}})
    *@ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_Id": "id"}})

    */
    public function showEpisode(Program $program, Season $season, Episode $episode)
{

    return $this->render('program/episodes_show.html.twig', [
        'program' => $program, 'season' => $season, 'episode' => $episode
    ]);

}






}