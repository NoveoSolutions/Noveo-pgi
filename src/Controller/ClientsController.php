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

    protected $entityManager;
	protected $translator;
	protected $repository;

	// Set up all necessary variable
	protected function initialise()
	{		
		$this->repository = $this->entityManager->getRepository('PlaygroundCookiejarBundle:Town');		
	}

    #[Route('/clients', name: 'app_form_clients')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    { 
        //création du formulaire clients
        $client = new Clients();
        $form = $this->createForm(AjoutClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //Les actions à effectuer à la soumission du formulaiure 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
        
        return $this->redirect('/clients');

        }
        
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Clients',
            'form' => $form->createView()            
        ]);
    }

    #[Route('/clients_modal', name: 'app_form_modal_clients')]
    public function index_modal(Request $request, ManagerRegistry $doctrine): Response
    { 
        //création du formulaire clients
        $client = new Clients();
        $form = $this->createForm(AjoutClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //Les actions à effectuer à la soumission du formulaiure 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
        
        return $this->redirect('/clients_modal');

        }
        
        return $this->render('clients/index_modal.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Ajout client',
            'form' => $form->createView()            
        ]);
    }

    #[Route('/clients_modal_edit', name: 'app_form_modal_client_edit')]
    public function index_modal_edit(Clients $client, Request $request, ManagerRegistry $doctrine): Response
    { 
        //création du formulaire clients
        $client = new Clients();
        $form = $this->createForm(AjoutClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //Les actions à effectuer à la soumission du formulaiure 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
        
        return $this->redirect('/clients_modal_edit');

        }
        
        return $this->render('clients/index_modal.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Ajout client',
            'form' => $form->createView()            
        ]);
    }


}
