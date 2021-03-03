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
     * @Route("/{id}/edit", name="component_edit")
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param Component|null         $component
     *
     * @return Response
     */
    public function form(Request $request, EntityManagerInterface $entityManager, Component $component = null): Response
    {
        if (empty($component)) {
            $component = new Component();
        }

        $form = $this->createForm(ComponentType::class, $component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $component->setUpdatedAt(new DateTime());
            $entityManager->persist($component);
            $entityManager->flush();

            return $this->redirectToRoute('component_index');
        }

        return $this->render('component/form.html.twig', [
            'form'      => $form->createView(),
            'component' => $component,
        ]);
    }

    /**
     * @Route("/{id}/remove", name="component_remove")
     */
    public function remove(Component $component, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($component);
        $entityManager->flush();

        return $this->redirectToRoute('component_index');
    }
}
