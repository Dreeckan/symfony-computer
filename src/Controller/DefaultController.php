<?php

namespace App\Controller;

use App\Repository\ComponentRepository;
use App\Repository\ComputerRepository;
use App\Repository\DeviceRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     *
     * @param ComputerRepository  $computerRepository
     * @param ComponentRepository $componentRepository
     * @param DeviceRepository    $deviceRepository
     *
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(ComputerRepository $computerRepository, ComponentRepository $componentRepository, DeviceRepository $deviceRepository): Response
    {
        $computers = $computerRepository->findAll();

        $completeComputers = [];
        $completePrice = 0;

        foreach ($computers as $computer) {
            if ($computer->isComplete()) {
                $completeComputers[] = $computer;
                $completePrice += $computer->getPrice();
            }
        }

        $countComplete = count($completeComputers);
        $averagePrice = 0;
        if ($countComplete > 0) {
            $averagePrice = $completePrice / $countComplete;
        }

        return $this->render('default/index.html.twig', [
            'countComplete'         => $countComplete,
            'averagePrice'          => $averagePrice,
            'averageComponentPrice' => $componentRepository->averagePrice(),
            'averageDevicePrice'    => $deviceRepository->averagePrice(),
        ]);
    }
}
