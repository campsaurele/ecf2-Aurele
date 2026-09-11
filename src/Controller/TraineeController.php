<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class TraineeController extends AbstractController
{
    #[Route('/trainee', name: 'trainee.index')]
    public function index(TraineeRepository $repository): Response
    {
        $trainees = $repository->findAll();

        return $this->render('trainee/index.html.twig', ['trainees' => $trainees]);
    }

    /**
     * Read Trainee Controller.
     */
    #[Route('/trainee/{id}', name: 'trainee.show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('trainee/show.html.twig');
    }

    /**
     * Create Trainee Controller.
     */
    #[Route('/trainee/new', name: 'trainee.new')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $trainee = new Trainee();
        $form = $this->createForm(TraineeType::class, $trainee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $document = $form->get('photo')->getData();
            if ($document) {
                // Get original filename with the document name
                $originalFilename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                // Clean the filename by passing it through a slugger which exist in symfony
                $safeFilename = $slugger->slug($originalFilename);
                // Create the new filename by using the slugified one spaced with a - then a random unique identifier (uniqid). It then end with .documentExtension
                $newFilename = $safeFilename.'-'.uniqid().'.'.$document->guessExtension();

                // Rename & Move the file to the correct location
                $document->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads/images',
                    $newFilename
                );
                // Set file name for the DB at absence.document
                $trainee->setPhoto($newFilename);
            }
            $em->persist($trainee);
            $em->flush();
            $this->addFlash('success', 'Stagiaire correctement ajouté.');

            return $this->redirectToRoute('trainee.index');
        }

        return $this->render('trainee/create.html.twig', ['form' => $form]);
    }

    /**
     * Update Trainee Controller.
     */
    #[Route('/trainee/{id}/edit', name: 'trainee.edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function set(EntityManagerInterface $em, Trainee $trainee, Request $request): Response
    {
        $form = $this->createForm(TraineeType::class, $trainee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Stagiaire modifié avec succès.');

            return $this->redirectToRoute('trainee.index');
        }

        return $this->render('trainee/edit.html.twig', ['form' => $form, 'trainee' => $trainee]);
    }

    /**
     * Delete Trainee Controller.
     */
    #[Route('/trainee/{id}/delete', name: 'trainee.delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, Trainee $trainee): Response
    {
        $em->remove($trainee);
        $em->flush();
        $this->addFlash('success', 'Le stagiaire à bien été supprimé.');

        return $this->redirectToRoute('trainee.index');
    }
}
