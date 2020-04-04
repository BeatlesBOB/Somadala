<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request,UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $client = new Client();
        $panier = new Panier();

        $form = $this->createForm(RegistrationType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $hash = $encoder->encodePassword($client, $client->getMdp());
            $client->setMdp($hash);
            $client->setRoles("ROLE_USER");
            $panier->setClientId($client);
            $entityManager->persist($panier);
            $entityManager->persist($client);
            $entityManager->flush();


            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('Somadala@gmail.com')
                ->setTo($client->getMail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        ['name' => $client->getNom()]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            return $this->redirectToRoute('security_login');

        }
        return $this->render('security/registration.html.twig',[
            'form' => $form -> createView()

        ]);

    }


    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig',[
            'error'=> $error,
        ]);

    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
