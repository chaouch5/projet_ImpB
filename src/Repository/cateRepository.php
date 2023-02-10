<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $id, array $orderBy = null, $limit = null, $offset = null)
 */
class cateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
/*
    public function findByCategorie($categorie)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id LIKE :id')
            ->setParameter('id', '%'.$categorie.'%')
            ->getQuery();
        $categorie =$query->getResult();
    }*/





}