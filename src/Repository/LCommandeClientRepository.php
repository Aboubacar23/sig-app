<?php

namespace App\Repository;

use App\Entity\LCommandeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LCommandeClient>
 *
 * @method LCommandeClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method LCommandeClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method LCommandeClient[]    findAll()
 * @method LCommandeClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LCommandeClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LCommandeClient::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(LCommandeClient $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(LCommandeClient $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return LCommandeClient[] Returns an array of LCommandeClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LCommandeClient
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
