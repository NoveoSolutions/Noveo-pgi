<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\AjoutClientType;
use Doctrine\ORM\Cache\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;


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

    #[Route('/clients_modal_form', name: 'app_form_modal_clients')]
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

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }
        
        return $this->redirect('/clients_modal');

        }

             
        return $this->render('clients/index_modal_form.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Ajout client',
            'form' => $form->createView()            
        ], new Response(
            null,
            $form->isSubmitted() && !$form->isValid() ? 422 : 200,
        ));
    }

    #[Route('/clients_modal_form/{id}/edit', name: 'app_form_edit_modal_clients')]
    public function index_edit_modal(clients $client, Request $request, ManagerRegistry $doctrine): Response
    { 
        
        $form = $this->createForm(AjoutClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $client = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }
        
        return $this->redirect('/clients_modal');

        }
        
        return $this->render('clients/index_edit_modal_form.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Modification client',
            'form' => $form->createView()            
        ], new Response(
            null,
            $form->isSubmitted() && !$form->isValid() ? 422 : 200,
        ));
    }


    
    #[Route('/clients/datatables', name:'app_test_clients')]
    public function dataTableAction(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine):JSONResponse{
        
        
        $repository = $entityManager->getRepository(Clients::class);
               
        $columns = array(
            0 => 'nom',
            1 => 'prenom',
            2 => 'telephone',
            3 => 'commandes',
        );
       
        
        $order = $columns[$request->query->getInt('order.0.column')];
        
        $start = $request->query->get('start');
        $dir = $_GET['order'][0]['dir'];
        $limit = $request->query->get('length');
        $search = $_GET['search']['value'];
        $order2 = $_GET['order'];


        $qb = $repository->createQueryBuilder('t');
        
        if (!empty($search)) {
            $qb->andWhere('t.nom LIKE :search OR t.prenom LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

      
        $totalFiltered = count($qb->getQuery()->getResult());
        
        $qb->orderBy('t.' . $order, $dir)
            ->setFirstResult($start)
            ->setMaxResults($limit);

        
        $tests = $qb->getQuery()->getResult();
         

        $totalData = $repository->count([]);

               
        $data = array();
        
        foreach ($tests as $test) {
            $nestedData = array();
            $nestedData["id"] = $test->getId();
            $nestedData["nom"] = $test->getNom();
            $nestedData["prenom"] = $test->getPrenom();
            $nestedData["telephone"] = $test->getTelephone();
            $nestedData["commandes"] = $test->getCommandes();
            $nestedData["consulter"] = '<a href="/client/'.$test->getId().'"><i class="bi bi-search"/></a>';
            $nestedData["supprimer"] = '<button  type="button" data-bs-toggle="modal" data-id="'.$test->getId().'" data-bs-target="#deleteModal" class="open-modal_deleteclient btn btn-danger" data-id=><i class="bi bi-trash"></</button>';
            $data[] = $nestedData;

        }

        
        $json_data = array(
            'draw' => $request->query->get('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'order' => $order2,
            'data' => $data,
        );
                      
        return $this->JSON($json_data);
   
}

    #[Route('/client/{id}', name: 'app_client_id')]
    public function indexClient(Clients $client): Response
    { 
        
        return $this->render('clients/index.client.html.twig', [
            'controller_name' => 'ClientsController',
            'title' => 'Client',
            'client' => $client
                
        ]);
    }

  
}

//toolsy
//$dir = $request->query->get('order.0.dir');
//$search = $request->query->get(['search'].['value']);

//$totalFiltered = $qb->select('COUNT(t)')->getQuery()->getResult();       
//$recordsFiltered = $totalFiltered[0][1];

//toolsc
//$order2 = $_GET['order'];