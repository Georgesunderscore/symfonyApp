<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    // add formAddEmploye
    #[Route('/employe/add', name: 'add_employe')]
    #[Route('/employe/{id}/edit', name: 'edit_employe')]
    public function add(ManagerRegistry $doctrine , Employe $employe= null, Request $request): Response
    {   
        if($employe == null){
            $employe = new Employe();
        }

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $employe = $form->getData();
            $entityManager = $doctrine->getManager();
            // prepare for insert and update here no problem 
            $entityManager->persist($employe);
            // insert into execute 
            $entityManager->flush();

            return $this->redirectToRoute('app_employe');

        }
        return $this->render('employe/add.html.twig', [
            'formAddEmploye' => $form->createView()]);

    }

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(ManagerRegistry $doctrine , Employe $employe= null, Request $request): Response
    {   
        $entityManager = $doctrine->getManager();
        // prepare  
        $entityManager->remove($employe);
        // execute 
        $entityManager->flush();
        
        return $this->redirectToRoute('app_employe');
        
    
    }

    
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response
    {   
        
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
            
        ]);

    }

    
}
