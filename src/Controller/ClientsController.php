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
    public function index(Request $request): Response
    { 
        $client = new Clients();
        // ...

        $form = $this->createForm(AjoutClientType::class, $client);

        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Clients',
            'form' => $form->createView()
        ]);
    }

    #[Route('/addclients', name: 'app_add_clients')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $client = new Clients();
        $client->setNom('Keyboard');
        $client->setprenom('Thierry');
        $client->setTelephone(6452502184);

        // tell Doctrine you want to (eventually) save the Client (no queries yet)
        $entityManager->persist($client);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new client with id '.$client->getId());
    }

    // public function new(Request $request): Response
    // {
    //     $client = new Clients();
    //     // ...

    //     $form = $this->createForm(AjoutClientType::class, $client);

    //     return $this->render('clients/index.html.twig', [
    //         'form' => $form,
    //     ]);
    // }
}
