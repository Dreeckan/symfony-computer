<?php

namespace App\Controller;

use App\Entity\Component;
use App\Form\ComponentType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/component")
 */
class ComponentController extends AbstractController
{
    /**
     * @Route("/", name="component_index")
     */
    public function index(): Response
    {
        return $this->render('component/index.html.twig', [
            'controller_name' => 'ComponentController',
        ]);
    }

    /**
     * @Route("/new", name="component_new")
     */
    public function new(Request $request, EntityManager $entityManager): Response
    {
        $component = new Component();

        $form = $this->createForm(ComponentType::class, $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($component);
            $entityManager->flush();

            return $this->redirectToRoute('component_index');
        }

        return $this->render('component/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
