<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', name: 'register')]
    public function register(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository,
    ): Response {
        $user = $userRepository->findOneBy([
            'login' => 'formateur',
        ]);

        if ($user) {
            $this->addFlash('warning', 'La compte formateur est déjà existant.');

            return $this->redirectToRoute('login');
        }

        $user = new User();

        $user->setLogin('formateur');

        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'afpatatra')
        );
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Utilisateur correctement ajouté.');

        return $this->redirectToRoute('login');
    }
}
