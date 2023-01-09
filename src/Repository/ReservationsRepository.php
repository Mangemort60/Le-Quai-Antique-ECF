<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function save(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Reservations[] Returns an array of Reservations objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($value): ?Reservations
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


// Compte le nombre de couverts à une date donnée pour le service du midi
    public function countNbrCouvertDateMidi(string $date, string $heure ): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('SUM(r.nbrCouvert)')
            ->where('r.date = :date')
            ->andWhere('r.heure < :heure')
            ->setParameter('date', $date)
            ->setParameter('heure', $heure);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

// Compte le nombre de couverts à une date donnée pour le service du soir
    public function countNbrCouvertDateSoir(string $date, string $heure): int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('SUM(r.nbrCouvert)')
            ->where('r.date = :date')
            ->andWhere('r.heure > :heure')
            ->setParameter('date', $date)
            ->setParameter('heure', $heure);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }


}
