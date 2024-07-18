<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry; // Cambiado a ManagerRegistry

class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) // Cambiado a ManagerRegistry
    {
        parent::__construct($registry, Animal::class);
    }

    public function getAnimalsOrderId($order){

                // QUERY BUILDER CON SYMFONY
                $qb = $this->createQueryBuilder('a')
               // ->andWhere('a.tipo = :tipo')
               // ->setParameter('tipo', 'gato')
                ->orderBy('a.id','ASC')
                ->getQuery();
            //consulta para query que
            $resultset = $qb->getResult();

            $coleccion = array(
                'name'=>'coleccion de animales',
                'animales'=>$resultset
            );

            return $coleccion;
    }
}
