<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;
/**
* @Route("/category", name="category_")
*/
class CategoryController extends AbstractController
{
    /**
    * Correspond à la route /category/ et au name "category_index"
    * @Route("/", name="index")
    */
   public function index(): Response
   {
       $categoryNames = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();

        return $this->render(
        'category/index.html.twig',
         ['categoryNames' => $categoryNames]
        );
   }
    /**
    * Getting a program by id
    * 
    * @Route("/{categoryName}", name="show")
    *@return Response
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);

        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $category], ['id' => 'DESC'], 3);
        
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in category\'s table.'
            );
        }
        return $this->render('category/show.html.twig', [
            'category' => $category, 'programs' => $programs

        ]);
    }
}









