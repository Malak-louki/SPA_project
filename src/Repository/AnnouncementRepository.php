<?php

namespace App\Repository;

use App\Entity\Announcement;
use App\Form\Filter\AnnouncementFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Announcement>
 *
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }

    public function save(Announcement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Announcement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // public function findOneBy()
    // {
    //     $this->getEntityManager()->;
    // }

    public function groupByAnnouncement(AnnouncementFilter $filter): array
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.dogs', 'd')
            ->groupBy('a.id')
        ;

        if ($filter->getIsLof()) {
            $qb
                ->andWhere('d.isLof = :isLof')
                ->setParameter('isLof', $filter->getIsLof());
        }

        if (!$filter->getIsAdopted()) {
            $qb
                ->andWhere(
                    $qb->expr()->orX('d.isAdopted = false', 'd.id IS NULL') // Ajouter des parenthèses autour de la condition en SQL : WHERE (d1_.is_adopted = 0 OR d1_.id IS NULL)
                    // ->andWhere('d.isAdopted = false')
                    // ->orWhere('d.id IS NULL')
                )
            ;
        }

        if ($filter->getRace()) {
            $qb
                ->leftJoin('d.races', 'r')
                ->andWhere('r = :race')
                ->setParameter('race', $filter->getRace())
            ;
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Announcement[] Returns an array of Announcement objects
    //     */
    public function findForHome(): array
    {
        return $this->createQueryBuilder('a')
            // ->leftJoin('a.dogs', 'd') si besoin d'un left join
            ->orderBy('a.updatedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Announcement
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}