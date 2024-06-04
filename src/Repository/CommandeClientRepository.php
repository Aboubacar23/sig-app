<?php

namespace App\Repository;

use App\Entity\FiltreCommandeClient;
use App\Entity\CommandeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeClient>
 *
 * @method CommandeClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeClient[]    findAll()
 * @method CommandeClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeClient::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CommandeClient $entity, bool $flush = true): void
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
    public function remove(CommandeClient $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Recherche des commandes en fonction du formulaire
     * @return void 
    */
    public function findAllClient(FiltreCommandeClient $recherche)
    {
        $query = $this->createQueryBuilder('a');

            if($recherche->getClient()){
                $query = $query->andWhere('a.client = :val')
                                ->setParameter('val', $recherche->getClient());
            }

            if($recherche->getPeriodeMin()){
                $query = $query->andWhere('a.date_commande >= :minperiode')
                                ->setParameter('minperiode', $recherche->getPeriodeMin());
            } 

            if($recherche->getPeriodeMax()){
                $query = $query->andWhere('a.date_commande <= :maxperiode')
                                ->setParameter('maxperiode', $recherche->getPeriodeMax());
            }
            
            return $query->getQuery()->getResult();
    }


    // /**
    //  * @return CommandeClient[] Returns an array of CommandeClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandeClient
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
