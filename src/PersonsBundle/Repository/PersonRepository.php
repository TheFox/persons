<?php

namespace TheFox\PersonsBundle\Repository;

use Symfony\Component\OptionsResolver\OptionsResolver;
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
    /**
     * @var string
     */
    private $alias;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);

        $this->alias = 'p';
    }

    public function findByUser(User $user, array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'limit' => null,
            'order' => [],
        ]);
        $options = $resolver->resolve($options);

        /** @var null|int $limit */
        $limit = $options['limit'];

        /** @var array $order */
        $order = $options['order'];
        $order[] = ['lastName'];
        $order[] = ['firstName'];

        $queryBuilder = $this->createQueryBuilder($this->alias)
            ->andWhere(sprintf('%s.user = :user', $this->alias))
            ->andWhere(sprintf('%s.deletedAt IS NULL', $this->alias))
        ;

        $parameters = [
            'user' => $user,
        ];

        $queryBuilder->setParameters($parameters);

        foreach ($order as $sort) {
            $sort0 = sprintf('%s.%s', $this->alias, $sort[0]);
            if (array_key_exists(1, $sort)) {
                $queryBuilder->addOrderBy($sort0, $sort[1]);
            } else {
                $queryBuilder->addOrderBy($sort0, 'ASC');
            }
        }

        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }
        $query = $queryBuilder->getQuery();
        //$sql=$query->getSQL();
        $result = $query->getResult();
        return $result;
    }
}
