<?php

namespace App\Repository;

use App\Entity\User;
use App\Model\UserCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findCollection(int $limit, int $offset = 0)
    {
        $items = $this->createQueryBuilder('u')
            ->leftJoin('u.address', 'a')
            ->addSelect('a')
            ->leftJoin('u.company', 'c')
            ->addSelect('c')
            ->leftJoin('a.geo', 'g')
            ->addSelect('g')
            ->orderBy('u.id', 'desc')
            ->setFirstResult($offset)
            ->setMaxResults($limit + 1)
            ->getQuery()
            ->getResult();

        $nextOffset = count($items) > $limit ? $offset + $limit : null;

        if ($nextOffset) {
            array_pop($items);
        }

        return new UserCollection($items, $limit, $offset, $nextOffset);
    }
}
