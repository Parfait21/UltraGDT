<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\DossierTech;
use App\Entity\Saisons;
use App\Form\DossierFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DossierController extends AbstractController
{
    // Une methode pour afficher dossier technique
    #[Route('/dossier', name: 'app_dossier_list')]
    public function listDossier(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class);
        $dossiers = $repository->findAll();
        return $this->render('dossier/list.html.twig', [
            'dossiers' => $dossiers,
        ]);
    }

    // Methode d'ajout d'un dossier technique
    #[Route('/dossier/ajout', name: 'app_dossier_ajout')]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $dossier = new DossierTech();
        $form = $this->createForm(DossierFormType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $dossier->setFile($newFilename);
            }

            $entityManager->persist($dossier);
            $entityManager->flush();

            $this->addFlash('success', 'Le fichier a été ajouté avec succès.');

            return $this->redirectToRoute('app_saison_images', ['id' => $dossier->getSaisonId()->getId()]);
        }
        
        return $this->render('dossier/add.html.twig',[
                 'form' => $form->createView(),
            ]);
    }

    // Methode permet de modifier une telle DT
    #[Route('/dossier/modifier/{id}', name:'app_dossier_edit')]
    public function editDossier(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class);
        $dossier = $repository->find($id);
        if (!$dossier) {
            $this->createNotFoundException('Fichier non trouvé');
        }
        $form = $this->createForm(DossierFormType::class, $dossier);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($dossier);
            $entityManager->flush();

            $this->addFlash('success', "Fichier a ete modifier avec succes!");
            return $this->redirectToRoute('app_dossier_list');
        }
        return $this->render('dossier/edit.html.twig',[
            'dossier' => $dossier,
            'form' => $form->createView(),
        ]);
    }

    // Une methode de suppression DT
    #[Route('/dossier/supprimer/{id}', name:'app_dossier_del')]
    public function delDossier(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class)->find($id);
        if (!$repository) {
            $this->createNotFoundException('Fichier non trouvé');
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($repository);
        $entityManager->flush();
        $this->addFlash('success', "Fichier a ete supprimer avec succes!");
        return $this->redirectToRoute('app_dossier_list');
    }

    // Details d'une telle Dossier Technique
    #[Route('/dossier/liste', name:'app_list1')]
    public function liste1(): Response
    {
        return $this->render('dossier/liste1.html.twig',[
            
        ]);
    }

    #[Route("/images/pull/{client}/{saison}", name: "app_images_pull")]
    public function imagesPull(Clients $client, Saisons $saison, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class);
        $imagesPull = $repository->findBy([
            'TypeFicher' => 'PULL',
            'saisonId' => $saison
        ]);

        return $this->render('dossier/images_pull.html.twig', [
            'imagesPull' => $imagesPull,
            'saison' => $saison,
        ]);
    }

    #[Route("/images/plan/{client}/{saison}", name: "app_images_plan")]
    public function imagesPlan(Clients $client, Saisons $saison, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(DossierTech::class);
        $imagesPlan = $repository->findBy([
            'TypeFicher' => 'PLAN',
            'saisonId' => $saison
        ]);

        return $this->render('dossier/images_plan.html.twig', [
            'imagesPlan' => $imagesPlan,
            'client' => $client,
            'saison' => $saison
        ]);
    }
}