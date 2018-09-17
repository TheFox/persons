<?php

namespace TheFox\PersonsBundle\Repository;

use TheFox\PersonsBundle\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use TheFox\UserBundle\Entity\User;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findByUser(User $user, ?int $limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.deletedAt IS NULL')
            ->setParameter('user', $user)
            ->orderBy('p.lastName')
            ->addOrderBy('p.firstName')
        ;
        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
