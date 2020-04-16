<?php

namespace App\Repository;

use App\Entity\AppBundleOrdenador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppBundleOrdenador|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppBundleOrdenador|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppBundleOrdenador[]    findAll()
 * @method AppBundleOrdenador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppBundleOrdenadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppBundleOrdenador::class);
    }

    // /**
    //  * @return AppBundleOrdenador[] Returns an array of AppBundleOrdenador objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppBundleOrdenador
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
