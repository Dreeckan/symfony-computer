<?php

namespace App\Repository;

use App\Entity\Component;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Component|null find($id, $lockMode = null, $lockVersion = null)
 * @method Component|null findOneBy(array $criteria, array $orderBy = null)
 * @method Component[]    findAll()
 * @method Component[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Component::class);
    }

    public function findForIndex()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.updated_at', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function averagePrice(): int
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(c.price)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
