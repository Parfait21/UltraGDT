<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client_list')]
    public function listClient(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $clients = $repository->findAll();
        return $this->render('client/list.html.twig',[
            'client' => $clients,
        ]);
    }

    #[Route('/client/ajout', name:'app_client_ajout')]
    public function addClient(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $clients = new Clients();
        $form = $this->createForm(ClientFormType::class, $clients);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($clients);
            $entityManager->flush();

            $this->addFlash('success', "Client a ete ajouter avec succes !");
            return $this->redirectToRoute('app_client_list');
        }
       
        return $this->render('client/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/client/modifier/{id}', name:'app_client_edit')]
    public function editClient(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $clients = $repository->find($id);
        if (!$clients) {
            $this->createNotFoundException('Client non trouvé');
        }
        $form = $this->createForm(ClientFormType::class, $clients);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($clients);
            $entityManager->flush();

            $this->addFlash('success', "Client a ete modifier avec succes!");
            return $this->redirectToRoute('app_client_list');
        }
        
        return $this->render('client/edit.html.twig',[
            'client' => $clients,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/saison/client/{id}', name:'app_client_saison')]
    public function saisonClient(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $clients = $repository->find($id);
        if (!$clients) {
            $this->createNotFoundException('Client non trouvé');
        }
        $saisons = $clients->getSaisons();
        return $this->render('client/saison.html.twig',[
           'client' => $clients,
           'saisons' => $saisons,
        ]);
    }

    #[Route('/client/supprimer/{id}', name:'app_client_supprimer')]
    public function deleteClient(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $clients = $repository->find($id);
        if (!$clients) {
            $this->createNotFoundException('Client non trouvé');
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($clients);
        $entityManager->flush();

        $this->addFlash('success', "Client a ete supprimer avec succes!");
        return $this->redirectToRoute('app_client_list');
    }
}
