<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\Request1Type;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HTTPRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/request")
 */
class CRUDRequestController extends AbstractController
{
    /**
     * @Route("/", name="crud_request_index", methods={"GET"})
     */
    public function index(RequestRepository $requestRepository): Response
    {
        return $this->render('crud_request/index.html.twig', [
            'requests' => $requestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="crud_request_new", methods={"GET", "POST"})
     */
    public function new(HTTPRequest $request, EntityManagerInterface $entityManager): Response
    {
        $request = new Request();
        $form = $this->createForm(Request1Type::class, $request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($request);
            $entityManager->flush();

            return $this->redirectToRoute('crud_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_request/new.html.twig', [
            'request' => $request,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="crud_request_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        return $this->render('crud_request/show.html.twig', [
            'request' => $request,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="crud_request_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, HTTPRequest $HTMLrequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Request1Type::class, $request);
        $form->handleRequest($HTMLrequest);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('crud_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_request/edit.html.twig', [
            'request' => $request,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="crud_request_delete", methods={"POST"})
     */
    public function delete(Request $request, HTTPRequest $HTMLrequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$request->getId(), $HTMLrequest->request->get('_token'))) {
            $entityManager->remove($request);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crud_request_index', [], Response::HTTP_SEE_OTHER);
    }
}