<?php

namespace App\Controller;

use App\Entity\Component;
use App\Form\ComponentType;
use App\Repository\ComponentRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(ComponentRepository $repository): Response
    {
        $components = $repository->findForIndex();

        return $this->render('component/index.html.twig', [
            'components' => $components,
        ]);
    }

    /**
     * @Route("/new", name="component_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $component = new Component();

        $form = $this->createForm(ComponentType::class, $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $component->setUpdatedAt(new DateTime());
            $entityManager->persist($component);
            $entityManager->flush();

            return $this->redirectToRoute('component_index');
        }

        return $this->render('component/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
