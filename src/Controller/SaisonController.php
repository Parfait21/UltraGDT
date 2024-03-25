<?php

namespace App\Controller;

use App\Entity\Saisons;
use App\Form\SaisonFormType;
use App\Repository\SaisonsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SaisonController extends AbstractController
{
    // Une methode pour afficher la liste des saisons
    #[Route('/saison', name: 'app_saison_list')]
    public function listSaison(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Saisons::class);
        $saison = $repository->findAll();
        return $this->render('saison/list.html.twig', [
            'saison' => $saison,
        ]);
    }
    
    // Une mtehode d'ajout d'une saison
    #[Route('/saison/ajout', name:'app_saison_ajout')]
    public function addSaison(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $saison = new Saisons();
        $form = $this->createForm(SaisonFormType::class, $saison);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($saison);
            $entityManager->flush();

            $this->addFlash('success', "Saison ajoutée avec succès");
            return $this->redirectToRoute('app_client_saison', ['id' => $saison->getClientId()->getId()]);
        }

        // Récupérer le client associé à la saison pour le passer à la vue Twig
        $client = $saison->getClientId();

        return $this->render('saison/ajout.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }


    // Modifier une telle saison
    #[Route('/saison/modifier/{id}', name:'app_saison_edit')]
    public function editSaison(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $entityManager = $doctrine->getManager();
            $saison = $entityManager->getRepository(Saisons::class)->find($id);
            $this->addFlash('error', 'Vous n\'avez pas la permission de modifier cette saison.');
            return $this->redirectToRoute('app_client_saison', ['id' => $saison->getClientId()->getId()]);
        }
        $entityManager = $doctrine->getManager();
        $saison = $entityManager->getRepository(Saisons::class)->find($id);
        $form = $this->createForm(SaisonFormType::class, $saison);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->flush();

            $this->addFlash('success', "Saison modifier avec succes");
            return $this->redirectToRoute('app_client_saison', ['id' => $saison->getClientId()->getId()]);

        }
        return $this->render('saison/edit.html.twig', [
            'saison' => $saison,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/saison/images/{id}', name: 'app_saison_images')]
    public function getSaisonImages(Saisons $saison, Request $request, SaisonsRepository $saisonsRepository): Response
    {
        // Récupérer l'ID du client
        $client = $saison->getClientId();

        $dossierTeches = $saison->getDossierTeches();

        // Récupérer les IDs des saisons sélectionnées depuis la requête
        $selectedSaisons = $request->query->get('saisons');
        $selectedSaisons = explode(',', $selectedSaisons);

        // Récupérer les informations de toutes les saisons sélectionnées
        $saisons = [];
        foreach ($selectedSaisons as $saisonId) {
            $saison = $saisonsRepository->find($saisonId);
            if ($saison) {
                $saisons[] = $saison;
            }
        }

        return $this->render('saison/images.html.twig', [
            'saisons' => $saisons,
            'dossierTeches' => $dossierTeches,
            'client' => $client,
        ]);
    }

}
