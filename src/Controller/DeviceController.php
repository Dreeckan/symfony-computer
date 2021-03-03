<?php

namespace App\Controller;

use App\Entity\Device;
use App\Form\DeviceType;
use App\Repository\DeviceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/device")
 */
class DeviceController extends AbstractController
{
    /**
     * @Route("/", name="device_index")
     */
    public function index(DeviceRepository $repository): Response
    {
        $devices = $repository->findBy([], [
            'updated_at' => 'DESC',
        ]);

        return $this->render('device/index.html.twig', [
            'devices' => $devices,
        ]);
    }

    /**
     * @Route("/new", name="device_new")
     * @Route("/{id}/edit", name="device_edit")
     *
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param Device|null            $device
     *
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Device $device = null): Response
    {
        if (empty($device)) {
            $device = new Device();
        }
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $device->setUpdatedAt(new DateTime());

            $entityManager->persist($device);
            $entityManager->flush();

            return $this->redirectToRoute('device_index');
        }

        return $this->render('device/form.html.twig', [
            'form'   => $form->createView(),
            'device' => $device,
        ]);
    }

    /**
     * @Route("/{id}/remove", name="device_remove")
     */
    public function remove(Device $device, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($device);
        $entityManager->flush();

        return $this->redirectToRoute('device_index');
    }
}
