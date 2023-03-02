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
    
    $response = new Response(null, $form->isSubmitted() ? 422 : 200);

    return $this->render('adresses/index.html.twig', [
        'controller_name' => 'AdressesController',
        'title' => 'Adresses',
        'form' => $form->createView()
    ], $response);
  }

  #[Route('/adresses_modal_form', name: 'app_form_modal_adresses')]
  public function index_modal(Request $request, ManagerRegistry $doctrine): Response
  { 

      //création du formulaire adresses
      $adresse = new Adresses();
      $form = $this->createForm(AjoutAdresseType::class, $adresse);
      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {

          $entityManager = $doctrine->getManager();
          $entityManager->persist($adresse);
          $entityManager->flush();
        
          //Les actions à effectuer à la soumission du formulaiure 
          

          if ($request->isXmlHttpRequest()) {
            return new Response(null, 204);
        }
        
      return $this->redirect('/');

      }
      return $this->render('adresses/index_modal_form.html.twig', [
        'controller_name' => 'AdressesController',
        'title' => 'Ajout adresse',
        'form' => $form->createView()            
    ], new Response(
            null,
            $form->isSubmitted() && !$form->isValid() ? 422 : 200,
        ));
  }  
}