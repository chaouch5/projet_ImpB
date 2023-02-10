<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function orderByName()
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery('select p from App\Entity\Contact p order by p.date ASC');
        return $query->getResult();

    }


    public function search($Date)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.Date LIKE :date ')
            ->setParameter('date', '%' . $Date . '%')
            ->getQuery()
            ->execute();
    }
}