<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="theme_index", methods={"GET"})
     */
    public function index(ThemeRepository $themeRepository): Response
    {
        return $this->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="theme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('theme_index');
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="theme_show", methods={"GET"})
     */
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="theme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Theme $theme): Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('theme_index');
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="theme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Theme $theme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('theme_index');
    }
}
