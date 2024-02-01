<?php

namespace App\Repository;

use App\Entity\OrderIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderIngredient>
 *
 * @method OrderIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderIngredient[]    findAll()
 * @method OrderIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderIngredient::class);
    }

//    /**
//     * @return OrderIngredient[] Returns an array of OrderIngredient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderIngredient
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
