<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adresses;
use App\Form\AjoutAdresseType;

class AdressesController extends AbstractController
{   
#[Route('/adresses', name: 'app_form_adresses')]
public function index(Request $request): Response
{ 
    $adresse = new Adresses();
    // ...

    $form = $this->createForm(AjoutAdresseType::class, $adresse);

    return $this->render('adresses/index.html.twig', [
        'controller_name' => 'AdressesController',
        'title' => 'Adresses',
        'form' => $form->createView()
    ]);
}}