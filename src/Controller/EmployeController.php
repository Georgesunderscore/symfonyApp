<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // $employes =$doctrine->getRepository(Employe::class)->findAll();

        // filtrer findBy(['nom' => 'kayal'] , ["nom" =>"ASC"]);
        // $employes =$doctrine->getRepository(Employe::class)-> findBy(['nom' => 'KAYAL'] , ["nom" =>"ASC"]);

        $employes =$doctrine->getRepository(Employe::class)->findBy([] , ["nom" =>"ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
            
        ]);
    }
}
