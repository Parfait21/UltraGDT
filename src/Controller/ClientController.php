<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use App\Repository\ClientsRepository;
use App\Repository\SaisonsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client/alls/{page?1}/{nbre?10}', name:'app_client_alls')]
    public function allsFichier($page, $nbre, ClientsRepository $clientsRepository): Response
    {
        // Utilisez la méthode count du Repository
        $nbClient = $clientsRepository->count([]);

        // Calculez le nombre total de pages
        $totalPages = ceil($nbClient / $nbre);
        
        // Récupérez les fichiers paginés
        $clients = $clientsRepository->findBy([], [], $nbre, ($page - 1) * $nbre);

        return $this->render('client/list.html.twig', [
            'isPaginated' => true,
            'client' => $clients,
            'page' => $page,
            'totalPages' => $totalPages,
            'nbre' => $nbre
        ]);
    }

    // Une methode qui permet d'ajouter un client
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
            return $this->redirectToRoute('app_client_alls');
        }
       
        return $this->render('client/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    // Une methode pour modifier un client
    #[Route('/client/modifier/{id}', name:'app_client_edit')]
    public function editClient(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de modifier cette client.');            
            return $this->redirectToRoute('app_client_alls');
        }
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
            return $this->redirectToRoute('app_client_alls');
        }
        
        return $this->render('client/edit.html.twig',[
            'client' => $clients,
            'form' => $form->createView(),
        ]);
    }

    // Une methode qui permet de supprimer un client
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
        return $this->redirectToRoute('app_client_alls');
    }

     // Une methode qui liste ou affiche la saison d'une telle client $id
     #[Route('/client/saison/{id}/{page?1}/{nbre?10}', name:'app_client_saison')]
    public function saisonClient(ManagerRegistry $doctrine, int $id, $page, $nbre, SaisonsRepository $saisonsRepository): Response
    {
        $repository = $doctrine->getRepository(Clients::class);
        $client = $repository->find($id);
        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        // Récupérez les saisons paginées pour le client
        $saisonsPaginated = $saisonsRepository->findPaginatedByClientId($id, $page, $nbre);

        // Calculez le nombre total de pages
        $totalPages = ceil($saisonsPaginated->count() / $nbre);

        return $this->render('client/saison.html.twig', [
            'client' => $client,
            'saisons' => $saisonsPaginated,
            'isPaginated' => true,
            'page' => $page,
            'totalPages' => $totalPages,
            'nbre' => $nbre,
        ]);
    }

}
