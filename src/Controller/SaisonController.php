<?php

namespace App\Controller;

use App\Entity\Saisons;
use App\Form\SaisonFormType;
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

            $this->addFlash('success', "Saison ajouter avec succes");
            return $this->redirectToRoute('app_client_saison', ['id' => $saison->getClientId()->getId()]);
        }
        return $this->render('saison/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Modifier une telle saison
    #[Route('/saison/modifier/{id}', name:'app_saison_edit')]
    public function editSaison(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
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
    public function getSaisonImages(Saisons $saison): Response
    {
        // Récupérez les DossierTech associés à cette saison
        $dossierTeches = $saison->getDossierTeches();
        
        // Récupérez le client associé à cette saison
        $client = $saison->getClientId();
    
        return $this->render('saison/images.html.twig', [
            'saison' => $saison,
            'dossierTeches' => $dossierTeches,
            'client' => $client, // Passer le client au template
        ]);
    }
    
}
