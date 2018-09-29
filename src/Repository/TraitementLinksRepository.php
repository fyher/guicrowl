<?php

namespace App\Repository;

use App\Entity\TraitementLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TraitementLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraitementLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraitementLinks[]    findAll()
 * @method TraitementLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraitementLinksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TraitementLinks::class);
    }

//    /**
//     * @return TraitementLinks[] Returns an array of TraitementLinks objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TraitementLinks
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
