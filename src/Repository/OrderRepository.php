<?php

declare (strict_types = 1);

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order): void 
    {
        $em = $this->getEntityManager();

        $em->persist($order);
        $em->flush();
    }

    public function remove(Order $order): void 
    {
        $em = $this->getEntityManager();

        $em->remove($order);
        $em->flush();
    }
}
