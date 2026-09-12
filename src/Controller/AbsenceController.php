<?php

namespace App\Controller;

use App\Entity\Absences;
use App\Form\AbsenceType;
use App\Repository\AbsencesRepository;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AbsenceController extends AbstractController
{
    #[Route('/absence', name: 'absence.index')]
    public function index(TraineeRepository $traineeRepository, AbsencesRepository $absencesRepository): Response
    {
        $trainee = $traineeRepository->findAll();
        $absences = $absencesRepository->findAll();

        return $this->render('absence/index.html.twig', ['absences' => $absences, 'trainee' => $trainee]);
    }

    #[Route('/absence/new', name: 'absence.new')]
    public function create(EntityManagerInterface $em, Request $request, SluggerInterface $slugger,
    ) {
        $absence = new Absences();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $document = $form->get('document')->getData();
            if ($document) {
                // Get original filename with the document name
                $originalFilename = strtolower($absence->getReason()->getName().' '.$absence->getTrainee()->getName().' '.$absence->getDateTime()->format('d-m-Y'));
                // Clean the filename by passing it through a slugger which exist in symfony
                $safeFilename = $slugger->slug($originalFilename);
                // Create the new filename by using the slugified one spaced with a - then a random unique identifier (uniqid). It then end with .documentExtension
                $newFilename = $safeFilename.'-'.uniqid().'.'.$document->guessExtension();

                // Rename & Move the file to the correct location
                $document->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads/documents',
                    $newFilename
                );
                // Set file name for the DB at absence.document
                $absence->setDocument($newFilename);
            }
            $em->persist($absence);
            $em->flush();
            $this->addFlash('success', 'Absence correctement ajouté.');

            return $this->redirectToRoute('absence.index');
        }

        return $this->render('absence/create.html.twig', ['form' => $form]);
    }

    #[Route('/absence/{id}', name: 'absence.show')]
    public function show(): Response
    {
        return $this->render('absence/show.html.twig');
    }

    #[Route('/absence/{id}/edit', name: 'absence.edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function set(EntityManagerInterface $em, Absences $absence, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $document = $form->get('document')->getData();
            if ($document) {
                // get Old document name
                $oldDocument = $absence->getDocument();

                // If it exist
                if ($oldDocument) {
                    // Store his path
                    $oldDocumentPath = $this->getParameter('kernel.project_dir')
                        .'/public/uploads/documents/'
                        .$oldDocument;
                    // Use it to DELETE it
                    if (file_exists($oldDocumentPath)) {
                        unlink($oldDocumentPath);
                    }
                }

                // Get original filename with the document name
                $originalFilename = strtolower($absence->getReason()->getName().' '.$absence->getTrainee()->getName().' '.$absence->getDateTime()->format('d-m-Y'));
                // Clean the filename by passing it through a slugger which exist in symfony
                $safeFilename = $slugger->slug($originalFilename);
                // Create the new filename by using the slugified one spaced with a - then a random unique identifier (uniqid). It then end with .documentExtension
                $newFilename = $safeFilename.'-'.uniqid().'.'.$document->guessExtension();

                // Rename & Move the file to the correct location
                $document->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads/documents',
                    $newFilename
                );
                // Set file name for the DB at absence.document
                $absence->setDocument($newFilename);
            }

            $em->flush();
            $this->addFlash('success', 'Absence modifié avec succès.');

            return $this->redirectToRoute('absence.index');
        }

        return $this->render('absence/edit.html.twig', ['form' => $form, 'absence' => $absence]);
    }

    #[Route('/absence/{id}/delete', name: 'absence.delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, Absences $absence): Response
    {
        // get Old document name
        $oldDocument = $absence->getDocument();

        // If it exist
        if ($oldDocument) {
            // Store his path
            $oldDocumentPath = $this->getParameter('kernel.project_dir')
                .'/public/uploads/documents/'
                .$oldDocument;
            // Use it to DELETE it
            if (file_exists($oldDocumentPath)) {
                unlink($oldDocumentPath);
            }
        }
        $em->remove($absence);
        $em->flush();
        $this->addFlash('success', 'L\'absencee à bien été supprimée.');

        return $this->redirectToRoute('absence.index');
    }
}
