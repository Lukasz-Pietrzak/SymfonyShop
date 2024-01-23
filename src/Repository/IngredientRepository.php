<?php

declare (strict_types = 1);

namespace App\Repository;

use App\Entity\Ingredients;
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
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Ingredients::class);
    }

    public function save(Ingredients $ingredients): void 
    {
        $em = $this->getEntityManager();

        $em->persist($ingredients);
        $em->flush();
    }

    public function remove(Ingredients $ingredients): void 
    {
        $em = $this->getEntityManager();

        $em->remove($ingredients);
        $em->flush();
    }
}
