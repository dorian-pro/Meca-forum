<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\UserAthenticatorAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAthenticatorAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // Crée un nouvel objet User
        $user = new User();
        // Crée un formulaire avec UserType et l'objet User
        $form = $this->createForm(UserType::class, $user);
        // Gère la requête du formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // encodage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    // Récupère le mot de passe soumis et le hashe
                    $form->get('password')->getData()
                )
            )
                // Définit l'adresse de l'utilisateur
                ->setAddress($user->getAddress())
                // Définit les informations de l'utilisateur
                ->setUserInfo($user->getUserInfo())
                // Récupère l'adresse email soumise
                ->setEmail($form->get('email')->getData())
                // Définit les rôles de l'utilisateur
                ->setRoles(['ROLE_USER'])
                // Définit si l'utilisateur est vérifié
                ->setIsVerified(false)
                // Définit si l'utilisateur est actif
                ->setIsActive(true)
                // Définit si l'utilisateur à accepter les conditions générales
                ->setIsAgree(true)
                // Définit la date de création de l'utilisateur
                ->setCreatedAt(new \DateTime('now'));

            // Ajoute l'utilisateur à la base de données
            $entityManager->persist($user);
            // Sauvegarde les modifications dans la base de données
            $entityManager->flush();

            // Authentifie l'utilisateur
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            // Crée la vue du formulaire
            'form' => $form->createView(),
        ]);
    }
}
