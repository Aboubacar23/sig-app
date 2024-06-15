<?php

namespace App\Repository;

use App\Entity\DepenseCamion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepenseCamion>
 *
 * @method DepenseCamion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepenseCamion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepenseCamion[]    findAll()
 * @method DepenseCamion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepenseCamionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepenseCamion::class);
    }

//    /**
//     * @return DepenseCamion[] Returns an array of DepenseCamion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DepenseCamion
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
