<?php

namespace App\Repository;

use App\Entity\PlacesMax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlacesMax>
 *
 * @method PlacesMax|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlacesMax|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlacesMax[]    findAll()
 * @method PlacesMax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlacesMaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlacesMax::class);
    }

    public function save(PlacesMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlacesMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlacesMax[] Returns an array of PlacesMax objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function getPlaceMaxValue(): int
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.nbrPlacesMax')
            ->andWhere('p.id = :val')
            ->setParameter('val', '1');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
