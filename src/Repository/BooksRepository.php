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
     * Find all producs having a value above the specified one with SQL.
     *
     * @param string $isbn of the book to search for
     * @return array[] Returns an array of arrays (i.e. a raw data set)
     */
    public function findOneByIsbnField2(string $isbn): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM books AS p
            WHERE p.isbn = :isbn
        ';

        $resultSet = $conn->executeQuery($sql, ['isbn' => $isbn]);

        return $resultSet->fetchAllAssociative();
    }
}
