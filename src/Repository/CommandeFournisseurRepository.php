<?php

namespace App\Repository;

use App\Entity\CommandeFournisseur;
use App\Entity\FiltreCommandeFournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeFournisseur>
 *
 * @method CommandeFournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeFournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeFournisseur[]    findAll()
 * @method CommandeFournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeFournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeFournisseur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CommandeFournisseur $entity, bool $flush = true): void
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
    public function remove(CommandeFournisseur $entity, bool $flush = true): void
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
    public function findAllFournisseur(FiltreCommandeFournisseur $recherche)
    {
        $query = $this->createQueryBuilder('a');

            if($recherche->getFournisseur()){
                $query = $query->andWhere('a.fournisseur = :val')
                                ->setParameter('val', $recherche->getFournisseur());
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
    //  * @return CommandeFournisseur[] Returns an array of CommandeFournisseur objects
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
    public function findOneBySomeField($value): ?CommandeFournisseur
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
