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
    public function create(EntityManagerInterface $em, Request $request)
    {
        $absence = new Absences();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
    public function set(EntityManagerInterface $em, Absences $absence, Request $request): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Absence modifié avec succès.');

            return $this->redirectToRoute('absence.index');
        }

        return $this->render('absence/edit.html.twig', ['form' => $form, 'absence' => $absence]);
    }

    #[Route('/absence/{id}/delete', name: 'absence.delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, Absences $absence): Response
    {
        $em->remove($absence);
        $em->flush();
        $this->addFlash('success', 'L\'absencee à bien été supprimée.');

        return $this->redirectToRoute('absence.index');
    }
}
