<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use App\Security\Voter\ProfileVoter;
use App\Security\Voter\QuestionVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questions")
 */
class QuestionsController extends AbstractController
{
    /**
     *
     * @Route("/", name="questions_index", methods={"GET"})
     */
    public function index(QuestionsRepository $questionsRepository): Response
    {
        return $this->render('questions/index.html.twig', [
            'questions' => $questionsRepository->findAll(),
        ]);
    }

    /**
     *
     * @Route("/new", name="questions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user= $this->getUser();
        $this->denyAccessUnlessGranted(ProfileVoter::QUESTION_NEW,$user);

        $question = new Questions();
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $question->setClient($this->getUser());
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('questions_index');
        }

        return $this->render('questions/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="questions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Questions $question): Response
    {

        $this->denyAccessUnlessGranted(QuestionVoter::QUESTION_EDIT,$question);

        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('questions_index');
        }

        return $this->render('questions/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="questions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Questions $question): Response
    {
        $this->denyAccessUnlessGranted(QuestionVoter::QUESTION_EDIT,$question);

        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('questions_index');
    }
}
