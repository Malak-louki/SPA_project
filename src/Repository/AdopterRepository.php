<?php

namespace App\Repository;

use App\Entity\Adopter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adopter>
 *
 * @method Adopter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adopter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adopter[]    findAll()
 * @method Adopter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdopterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adopter::class);
    }

    public function save(Adopter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adopter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}