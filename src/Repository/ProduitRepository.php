<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\ProduitSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @return Query
    */
    public function findSearchQuery( ProduitSearch $produitSearch): Query
    {
        $query = $this->findAllSearchQuery();
        if ($produitSearch->getMaxPrix()){
            $query = $query
            ->andWhere("p.prix <= :maxPrix")
            ->setParameter('maxPrix', $produitSearch->getMaxPrix());
        }
        if ($produitSearch->getMinPrix()){
            $query = $query
                ->andWhere("p.prix >= :minPrix")
                ->setParameter('minPrix', $produitSearch->getMinPrix());
        }

        if ($produitSearch->getNom()){
            $query = $query
                ->andWhere("p.nom LIKE :nom")
                ->setParameter('nom', '%'.$produitSearch->getNom().'%');
        }

        if ($produitSearch->getTheme()){
            $query = $query
                ->andWhere("p.theme = :theme")
                ->setParameter('theme', $produitSearch->getTheme());
        }
        return $query->getQuery();
    }
     /**
      * @return Produit[] Returns an array of Produit objects
      */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.panier = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    private function findAllSearchQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }


    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
