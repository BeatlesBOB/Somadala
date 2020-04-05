<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Theme;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Security\Voter\ClientVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="panier_index", methods={"GET"})
     */
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }

    /**
     *
     * @Route("/validate", name="panier_validate")
     */
    public function validate(\Swift_Mailer $mailer ): Response
    {
        $user = $this->getUser();
        $panier = $user->getPanier();
        /**
         * @var Produit $produit
         */
        $produit = $panier->getProduitId();


        $message = (new \Swift_Message('Hello Email'))
            ->setFrom("beatlesbob74120@gmail.com")
            ->setTo('beatlesbob74120@gmail.com')
            ->setSubject("Commande")
            ->setBody(
                $this->renderView(
                // templates/hello/email.txt.twig
                    'emails/commande.html.twig',
                    [
                        'nom' => $user->getNom(),
                        'prenom' => $user->getPrenom(),
                        'message' => $produit,
                        'telephone' => $user->getTelephone(),
                        'mail' => $user->getMail(),
                        'produit' => $produit
                    ]
                ),          'text/plain'

            );

        $mailer->send($message);
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
            'produit'=> $produit
        ]);

    }

    /**
     * @Route("/MonPanier", name="panier_showMonPanier")
     */
    public function showMonPanier(ProduitRepository $produitRepository): Response
    {
        $user = $this->getUser();
        $panier = $user->getPanier();
        /**
         * @var Produit $produit
         */
        $produit = $panier->getProduitId();


        $this->denyAccessUnlessGranted(ClientVoter::PANIER_SHOW,$panier);
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
            'produit'=> $produit
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="panier_show", methods={"GET"})
     */
    public function show(Panier $panier): Response
    {
        $produit =$panier->getProduitId();
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
            'produit'=> $produit
        ]);
    }


    /**
     * @Route("/addproduit/{id}", name="panier_addproduit")
     */
    public function ajouteaupanier(Request $request, Produit $produit): Response
    {
        /**
         * @var Client $user
         */
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $user->getPanier();
        $panier->addProduitId($produit);
        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/suppproduit/{id}", name="panier_suprproduit")
     */
    public function supprimeaupanier(Request $request, Produit $produit): Response
    {
        /**
         * @var Client $user
         */
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $user->getPanier();
        $panier->removeProduitId($produit);
        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }



}
