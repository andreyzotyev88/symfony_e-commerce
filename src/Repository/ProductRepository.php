<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function countElement($sectionSymlink){
        return $this->createQueryBuilder('p')
            ->addSelect('count(p) as count')
            ->leftJoin('p.category','c')
            ->addSelect('c')
            ->where('c.symlink = :symlink')
            ->setParameter('symlink',$sectionSymlink)
            ->getQuery()
            ->getScalarResult();
    }

    public function findAllProductBySectionSymlinkWithOffset($sectionSymlink,$offset,$limit){
        return $this
            ->createQueryBuilder('p')
            ->leftJoin('p.category','c')
            ->addSelect('c')
            ->where('c.symlink = :symlink')
            ->setParameter('symlink',$sectionSymlink)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
