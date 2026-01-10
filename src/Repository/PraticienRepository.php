<?php

namespace toubeelib\praticien\Repository;

use toubeelib\praticien\Entity\Praticien;

use Doctrine\ORM\EntityRepository;

class PraticienRepository extends EntityRepository
{
    public function findBySpecialiteKeyword(string $keyword): array
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM toubeelib\praticien\Entity\Praticien p 
                           JOIN p.specialite s 
                           WHERE s.libelle LIKE :keyword OR s.description LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getResult();
    }

    /**
     * Liste des praticiens d’une spécialité et acceptant un moyen de paiement donné
     */
    public function findBySpecialiteAndMoyenPaiement(string $specialiteLibelle, string $moyenLibelle): array
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM toubeelib\praticien\Entity\Praticien p 
                           JOIN p.specialite s 
                           JOIN p.moyensPaiement m 
                           WHERE s.libelle = :specialite AND m.libelle = :moyen')
            ->setParameter('specialite', $specialiteLibelle)
            ->setParameter('moyen', $moyenLibelle)
            ->getResult();
    }
}
