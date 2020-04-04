<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Security\Voter\ClientVoter;
use App\Security\Voter\ProfileVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/monprofil", name="client_showme")
     */
    public function showmonprofil(): Response
    {
        $client = $this->getUser();

        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/edit/monprofil", name="client_edit")
     */
    public function edit(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $client = $this->getUser();
        $this->denyAccessUnlessGranted(ProfileVoter::PROFIL_EDIT,$client);

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($client, $client->getMdp());
            $client->setMdp($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }
}
