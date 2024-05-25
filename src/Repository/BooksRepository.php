<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Books>
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    /**
    * @return Books Returns an object of Books
    */
    public function findOneByIsbnField($isbn): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.isbn = :isbn')
            ->setParameter('isbn', $isbn)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Find all producs having a value above the specified one with SQL.
     * 
     * @return [][] Returns an array of arrays (i.e. a raw data set)
     */
    public function findOneByIsbnField2($isbn): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM books AS p
            WHERE p.isbn = :isbn
        ';

        $resultSet = $conn->executeQuery($sql, ['isbn' => $isbn]);

        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Books[] Returns an array of Books objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Books
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
