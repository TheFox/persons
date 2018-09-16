<?php

namespace TheFox\PersonsBundle\Repository;

use TheFox\PersonsBundle\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use TheFox\PersonsBundle\Entity\Person;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsByPerson(Person $person, ?int $limit = null): array
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->andWhere('e.person = :person')
            ->andWhere('e.deletedAt IS NULL')
            ->setParameter('person', $person)
            ->orderBy('e.id', 'DESC')
        ;
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }

        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
