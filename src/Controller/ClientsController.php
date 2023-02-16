<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\AjoutClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class ClientsController extends AbstractController
{
    #[Route('/clients', name: 'app_form_clients')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    { 
        //création du formulaire clients
        $client = new Clients();
        $form = $this->createForm(AjoutClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            

            dd($client);
            //Les actions à effectuer à la soumission du formulaiure 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
        
        return $this->redirect('\clients');

        }
        
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Clients',
            'form' => $form->createView()            
        ]);
    }
}
