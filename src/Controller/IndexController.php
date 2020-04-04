<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ProduitSearch;
use App\Form\ContactType;
use App\Form\ProduitSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProduitRepository;

class IndexController extends AbstractController
{
    private $productrepository;
    public function __construct(ProduitRepository $productrepository){
        $this->productrepository = $productrepository;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, PaginatorInterface $paginator, \Swift_Mailer $mailer ): Response
    {
        $search = new ProduitSearch();
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class,$contact);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()){
            $this->addFlash('sucess', "votre email a bien été envoyé");
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom("beatlesbob74120@gmail.com")
                ->setTo('beatlesbob74120@gmail.com')
                ->setSubject($formContact->get('sujet')->getData())
                ->setBody(
                    $this->renderView(
                    // templates/hello/email.txt.twig
                        'emails/contact.html.twig',
                        [
                            'nom' => $formContact->get('nom')->getData(),
                            'prenom' => $formContact->get('prenom')->getData(),
                            'message' => $formContact->get('message')->getData(),
                            'telephone' => $formContact->get('telephone')->getData(),
                            'mail' => $formContact->get('mail')->getData(),
                        ]
                    ),          'text/plain'

                );

            $mailer->send($message);
        }

        $form = $this->createForm(ProduitSearchType::class, $search);
        $form -> handleRequest($request);

            $produit = $paginator->paginate(
                $this->productrepository->findSearchQuery($search),
                $request->query->getInt('page', 1),
                12
            );
        return $this->render('index/index.html.twig', [
            "products" => $produit,
            "form" => $form->createView(),
            "formContact" => $formContact->createView(),
        ]);
    }
}
