<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author tompa
 */
class AccueilController extends AbstractController {
    
    private $repository;
    
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response {
        $lastVisite = $this->repository->findLastedVoyages(2);
        return $this->render("pages/accueil.html.twig",[
                    'lastVisites' => $lastVisite
        ]);
    }
}
