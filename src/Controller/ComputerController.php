<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\ComputerType;
use App\Repository\ComputerRepository;
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
    public function index(ComputerRepository $repository): Response
    {
        $computers = $repository->findBy([], [
            'updated_at' => 'DESC',
        ]);
        return $this->render('computer/index.html.twig', [
            'computers' => $computers,
        ]);
    }

    /**
     * @Route("/new", name="computer_new")
     * @Route("/{id}/edit", name="computer_edit")
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param Computer|null          $computer
     *
     * @return Response
     */
    public function form(Request $request, EntityManagerInterface $em, Computer $computer = null): Response
    {
        if (empty($computer)) {
            $computer = new Computer();
        }

        // On crée le formulaire (objet de traitement)
        // Premier paramètre : le formulaire type (FQCN)
        // Deuxième paramètre : l'objet à manipuler (à synchroniser avec le formulaire)
        // Troisième paramètre : des options du formulaire
        $form = $this->createForm(ComputerType::class, $computer);

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

        return $this->render('computer/form.html.twig', [
            'form'     => $form->createView(),
            'computer' => $computer,
        ]);
    }

    /**
     * @Route("/{id}/remove", name="computer_remove")
     */
    public function remove(Computer $computer, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($computer);
        $entityManager->flush();

        return $this->redirectToRoute('computer_index');
    }
}
