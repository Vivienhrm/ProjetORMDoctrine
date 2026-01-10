<?php

namespace toubeelib\praticien\Repository;

use Doctrine\ORM\EntityRepository;

class SpecialiteRepository extends EntityRepository
{
    /**
     * Liste des spécialités contenant un mot clé dans le libellé ou la description
     */
    public function findByKeyword(string $keyword): array
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('s.libelle', ':keyword'),
            $qb->expr()->like('s.description', ':keyword')
        ))
        ->setParameter('keyword', '%' . $keyword . '%');

        return $qb->getQuery()->getResult();
    }
}
