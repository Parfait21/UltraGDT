<?php

namespace App\Controller;

use App\Entity\DossierTech;
use App\Form\DossierFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DossierController extends AbstractController
{
    #[Route('/dossier', name: 'app_dossier_list')]
    public function listDossier(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class);
        $dossiers = $repository->findAll();
        return $this->render('dossier/list.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }

    #[Route('/dossier/ajout', name:'app_dossier_ajout')]
    public function addDossier(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $dossier = new DossierTech();
        $form = $this->createForm(DossierFormType::class, $dossier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($dossier);
            $entityManager->flush();

            $this->addFlash('success', "Dossier ajouter avec succes");
            return $this->redirectToRoute('app_dossier_list');
        }
        
        return $this->render('dossier/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
