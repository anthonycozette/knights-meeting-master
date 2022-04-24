<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/create/event")
 */
class CreateEventController extends AbstractController
{
    private $slugger;
    private $security;

    public function __construct(SluggerInterface $slugger, Security $security)
    {
        // $this->slugger = $slugger;
        $this->security = $security;
    }
    
    /**
     * @Route("/", name="create_event_index", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER", message="Accès réservé")
     */
    public function index(EvenementRepository $evenementRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $evenement->setCreatedAt(new \DateTime('now'));
        $evenement->setUser($this->security->getUser());
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', "Votre evenement a bien été créer.");

            return $this->redirectToRoute('create_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('create_event/index.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
        // return $this->render('create_event/index.html.twig', [
        //     'evenements' => $evenementRepository->findAll(),
        // ]);
    }

    /**
     * @Route("/new", name="create_event_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER", message="Accès réservé")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $evenement->setCreatedAt(new \DateTime('now'));
        $evenement->setUser($this->security->getUser());
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', "Votre evenement a bien été créer.");

            return $this->redirectToRoute('create_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('create_event/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="create_event_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('create_event/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="create_event_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER", message="Accès réservé")
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', "Votre evenement a bien étais modifier.");

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('create_event/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="create_event_delete", methods={"POST"})
     * @IsGranted("ROLE_USER", message="Accès réservé")
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();

            $this->addFlash('success', "Votre evenement a bien été supprimé.");
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }
}
