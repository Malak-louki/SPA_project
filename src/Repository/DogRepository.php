<?php

namespace App\Repository;

use App\Entity\Announcement;
use App\Entity\Dog;
use App\Form\Filter\AnnouncementFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dog>
 *
 * @method Dog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dog[]    findAll()
 * @method Dog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dog::class);
    }

    public function save(Dog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Dog[] Returns an array of Dog objects
     */
    public function groupByDogs(): array
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.id', 'a')
            ->groupBy('a.id')
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterDogs(AnnouncementFilter $filter, Announcement $annonce): array
    {
        $qb = $this->createQueryBuilder('dog');
        $qb->innerJoin('dog.races', 'race')
            ->where('dog.announcement = :announcement')
            ->setParameter('announcement', $annonce);
        if (!is_null($filter->getRace())) {
            $qb->andWhere('race = :race')
                ->setParameter('race', $filter->getRace());
        }
        if ($filter->getIsAdopted()) {
            $qb->andWhere('dog.isAdopted = :isAdopted')
                ->setParameter('isAdopted', true);
        }

        if ($filter->getIsLof()) {
            $qb
                ->andWhere('dog.isLof = :isLof')
                ->setParameter('isLof', $filter->getIsLof());
        }

        return $qb->getQuery()
            ->getResult();
    }
}
