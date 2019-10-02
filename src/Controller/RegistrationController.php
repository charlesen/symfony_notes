<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
// use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        // 1) Construction du formulaire
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) Capture du submit (Requete POST uniquement)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encodage du mot de passe en clair
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            //on active par défaut
            $user->setIsActive(true);
            $user->setRoles(array('ROLE_SUPER_ADMIN'));

            // Sauvegarde de l'utilisateur
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->addFlash('success', 'Votre compte à bien été enregistré.');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        // Affichage en GET classique
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
