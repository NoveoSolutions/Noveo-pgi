<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Form\AjoutAdresseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class AdressesController extends AbstractController
{   
    
#[Route('/adresses', name: 'app_form_adresses')]
public function index(Request $request, ManagerRegistry $doctrine): Response
{ 
    $adresse = new Adresses();    
    $form = $this->createForm(AjoutAdresseType::class, $adresse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        //Les actions à effectuer à la soumission du formulaiure 
        $entityManager = $doctrine->getManager();
        $entityManager->persist($adresse);
        $entityManager->flush();
    
    return $this->redirect('/adresses');

    }

    return $this->render('adresses/index.html.twig', [
        'controller_name' => 'AdressesController',
        'title' => 'Adresses',
        'form' => $form->createView()
    ]);
  }

  #[Route('/adresses/{id}/edit', name: 'app_edit_adresses')]
    public function index_edit_modal(Adresses $adresse, Request $request, ManagerRegistry $doctrine): Response
    { 
        
        $form = $this->createForm(AjoutAdresseType::class, $adresse);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $adresse = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();
        
        return $this->redirect('/adresses');

        }
        
        return $this->render('clients/index_edit_modal_form.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Modification client',
            'form' => $form->createView()            
        ]);
    }
}