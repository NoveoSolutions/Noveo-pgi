<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RootController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        return $this->render('root/index.html.twig', [
            'controller_name' => 'RootController',
	        'title' => 'Index',
        ]);
    }

	#[Route('/clients', name: 'app_menu1.submenu1')]
	public function menu1Submenu1(): Response
	{
		return $this->render('clients/index.html.twig', [
			'controller_name' => 'ClientsController',
			'title' => 'Gestion - Clients',
			'content' => '<a class="btn btn-info" href="/addclients">Enregistrer</a>'
		]);
	}

	
	#[Route('/menu1_submenu1_new', name: 'app_menu1.submenu1.new')]
	public function menu1Submenu1New(): Response
	{
		return $this->render('root/index.html.twig', [
			'controller_name' => 'RootController',
			'title' => 'Menu 1 - Submenu 1 - New',
		]);
	}
	
	#[Route('/adresses', name: 'app_menu1.submenu2')]
	public function menu1Submenu2(): Response
	{
		return $this->render('adresses/index.html.twig', [
			'controller_name' => 'AdressesController',
			'title' => 'Gestion - Adresses',
		]);
	}

}
