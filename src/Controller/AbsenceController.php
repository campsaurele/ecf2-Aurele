<?php

namespace App\Controller;

use App\Entity\Absences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/absence')]
final class AbsenceController extends AbstractController
{
    #[Route('/', name: 'absence')]
    public function index(): Response
    {
        return $this->render('absence/index.html.twig');
    }

    #[Route('/{id}', name: 'trainee.show')]
    public function show(): Response
    {
        return $this->render('trainee/show.html.twig');
    }

    #[Route('/new', name: 'trainee.new')]
    public function create(EntityManagerInterface $em, Absences $absence): Response
    {
        return $this->render('trainee/create.html.twig');
    }

    #[Route('/{id}/edit', name: 'trainee.edit')]
    public function set(EntityManagerInterface $em, Absences $absence): Response
    {
        return $this->render('trainee/edit.html.twig');
    }

    #[Route('/{id}/delete', name: 'trainee.delete')]
    public function delete(EntityManagerInterface $em, Absences $absence): Response
    {
        $em->remove($absence);
        $em->flush();
        $this->addFlash('success', 'La recette à bien été supprimée.');

        return $this->redirectToRoute('recipe.index');
    }
}
