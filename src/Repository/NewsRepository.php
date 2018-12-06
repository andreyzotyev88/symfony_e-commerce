<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }


    public function findAllForCurPage($max_results,$number_page)
    {
        $totalOffset = ($number_page-1)*$max_results;
        return $this->createQueryBuilder('n')
            ->andWhere('n.active = :val')
            ->setParameter('val', '1')
            ->orderBy('n.date_create', 'ASC')
            ->setFirstResult($totalOffset)
            ->setMaxResults($max_results)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countElement(){
        return $this->createQueryBuilder('n')
            ->select('count(n)')
            ->andWhere('n.active = :val')
            ->setParameter('val','1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getBySymlink($symlink){
        return $this->createQueryBuilder('n')
            ->andWhere('n.symlink = :sym')
            ->setParameter('sym',$symlink)
            ->getQuery()
            ->getSingleResult();
    }
    /*
    public function findOneByvalSomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
