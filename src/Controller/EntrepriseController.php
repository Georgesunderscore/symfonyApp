<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // $entreprises =$doctrine->getRepository(Entreprise::class)->findAll();
        $entreprises =$doctrine->getRepository(Entreprise::class)->findBy([] , ["dateCreation" =>"desc"]);
        // $employes =$doctrine->getRepository(Employe::class)->findBy([] , ["nom" =>"ASC"]);
        
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
            
        ]);
    }

    #[Route('/entreprise/add', name: 'add_entreprise')]
    public function add(ManagerRegistry $doctrine , Entreprise $entreprise= null, Request $request): Response
    {   
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entreprise = $form->getData();
            $entityManager = $doctrine->getManager();
            // prepare for insert and update here no problem 
            $entityManager->persist($entreprise);
            // insert into execute 
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprise');

        }
        return $this->render('entreprise/add.html.twig', [
            'formAddEntreprise' => $form->createView()]);

    }
    // la route name cest utiliser dans les liens pour le path property 
    // <a href="{{ path('show_entreprise') }}"> {{ entreprise }} </a>

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {   
        
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
            
        ]);

    }

}
