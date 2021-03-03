<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\ComputerType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/computer")
 */
class ComputerController extends AbstractController
{
    /**
     * @Route("/", name="computer_index")
     */
    public function index(): Response
    {
        return $this->render('computer/index.html.twig', [
            'controller_name' => 'ComputerController',
        ]);
    }

    /**
     * @Route("/new", name="computer_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $computer = new Computer();
        $computer->setName('default');

        // On crée le formulaire (objet de traitement)
        // Premier paramètre : le formulaire type (FQCN)
        // Deuxième paramètre : l'objet à manipuler (à synchroniser avec le formulaire)
        // Troisième paramètre : des options du formulaire
        $form = $this->createForm(ComputerType::class, $computer, [
            'method' => 'POST',
            'action' => $this->generateUrl('computer_new'),
        ]);

        // On dit explicitement au formulaire de traiter ce que contient la requête (objet Request)
        $form->handleRequest($request);

        // On regarde si le formulaire a été soumis ET est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On met à jour la propriété updatedAt
            $computer->setUpdatedAt(new DateTime());

            // On enregistre
            $em->persist($computer);
            $em->flush();

            return $this->redirectToRoute('computer_index');
        }

        return $this->render('computer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
