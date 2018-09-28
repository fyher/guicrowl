<?php

namespace App\Repository;

use App\Entity\TraitementData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TraitementData|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraitementData|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraitementData[]    findAll()
 * @method TraitementData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraitementDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TraitementData::class);
    }

//    /**
//     * @return TraitementData[] Returns an array of TraitementData objects
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
    public function findOneBySomeField($value): ?TraitementData
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
