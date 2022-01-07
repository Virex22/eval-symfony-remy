<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\RequestType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestController extends AbstractController
{
    /**
     * @Route("/demande/nouvelle", name="new_ask")
     */
    public function index(HttpFoundationRequest $requestHTML, ManagerRegistry $doctrine): Response
    {
        $request = new Request();
        $form = $this->createForm(RequestType::class, $request);
        $form->handleRequest($requestHTML);

        if ( $form->isSubmitted() && $form->isValid() ){
            $request->setCreatedAt(new DateTime());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($request);
            $entityManager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('request/index.html.twig', [
            'controller_name' => 'RequestController',
            'form' => $form->createView(),
        ]);
    }
}