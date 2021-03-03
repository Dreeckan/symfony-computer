<?php

namespace App\Controller;

use App\Entity\Device;
use App\Form\DeviceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        return $this->render('device/index.html.twig', [
            'controller_name' => 'DeviceController',
        ]);
    }

    /**
     * @Route("/new", name="device_new")
     */
    public function new(): Response
    {
        $device = new Device();
        $form = $this->createForm(DeviceType::class, $device);

        return $this->render('device/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
