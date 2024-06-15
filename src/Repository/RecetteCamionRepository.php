<?php

namespace App\Repository;

use App\Entity\RecetteCamion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecetteCamion>
 *
 * @method RecetteCamion|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecetteCamion|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecetteCamion[]    findAll()
 * @method RecetteCamion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteCamionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecetteCamion::class);
    }

//    /**
//     * @return RecetteCamion[] Returns an array of RecetteCamion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecetteCamion
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
