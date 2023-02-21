<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\AjoutClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


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

    #[Route('/clients/tests', name:'app_test_clients')]
    public function dataTableLoad(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine):JSONResponse{
        
        
        $repository = $entityManager->getRepository(Clients::class);
               
        $columns = array(
            0 => 'nom',
            1 => 'prenom',
            2 => 'telephone',
            3 => 'commandes',          
        );
       
        
        //$limit = $request->query->get('length');
        //$start = $request->query->get('start');

        $order = $columns[$request->query->getInt('order.0.column')];

        //$dir = $request->query->get('order.0.dir');
        //$search = $request->query->get('search.value');

        //version old school de test
        $start = $_GET['start'];
        $dir = $_GET['order'][0]['dir'];
        $limit = $_GET['length'];
        $search = $_GET['search']['value'];
       

        $qb = $repository->createQueryBuilder('t');
        
        if (!empty($search)) {
            $qb->andWhere('t.nom LIKE :search OR t.prenom LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $qb->orderBy('t.' . $order, $dir)
            ->setFirstResult($start)
            ->setMaxResults($limit);

        $tests = $qb->getQuery()->getResult();
        

        $totalData = $repository->count([]);
        $totalFiltered = $qb->select('COUNT(t)')->getQuery()->getResult();

        $data = array();
        
        foreach ($tests as $test) {
            $nestedData = array();
            $nestedData["nom"] = $test->getNom();
            $nestedData["prenom"] = $test->getPrenom();
            $nestedData["telephone"] = $test->getTelephone();
            $nestedData["commandes"] = $test->getCommandes();
            $data[] = $nestedData;

        }

               
        $json_data = array(
            'draw' => $request->query->get('draw'),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        );
        
               
        return $this->JSON($data);
   
}
}

