<?php

$entityManager = require_once './bootstrap.php';

use toubeelib\praticien\Entity\Praticien;
use toubeelib\praticien\Entity\Specialite;
use toubeelib\praticien\Entity\Structure;
use toubeelib\praticien\Entity\MotifVisite;
use toubeelib\praticien\Entity\MoyenPaiement;
use Doctrine\Common\Collections\Criteria;



if (PHP_SAPI !== 'cli') {
    echo "<pre style='font-family: monospace; background: #f4f4f4; padding: 20px; line-height: 1.5;'>";
}

echo "=== TD1 : Utilisation de Doctrine ORM ===\n\n";

// ======================
// Exercice 1
// ======================

echo "Exercice 1.1 : afficher la spécialité d'identifiant 1\n";
$specialite = $entityManager->find(Specialite::class, 1);
if ($specialite) {
    echo "ID: " . $specialite->getId() . "\n";
    echo $specialite->getDescription() . "\n";
} else {
    echo "Spécialité non trouvée\n";
}

echo "\n\n";

echo "Exercice 1.2 : afficher le praticien dont l'id est 8ae1400f-d46d-3b50-b356-269f776be532\n";
$praticienId = '8ae1400f-d46d-3b50-b356-269f776be532';
$praticien = $entityManager->find(Praticien::class, $praticienId);

if ($praticien) {
    echo "ID: " . $praticien->getId() . "\n";
    echo "Nom: " . $praticien->getNom() . "\n";
    echo "Prénom: " . $praticien->getPrenom() . "\n";
    echo "Ville: " . $praticien->getVille() . "\n";
    echo "Email: " . $praticien->getEmail() . "\n";
    echo "Téléphone: " . $praticien->getTelephone() . "\n";
} else {
    echo "Praticien non trouvé\n";
}

echo "\n\n";

echo "Exercice 1.3 : afficher sa spécialité et sa structure de rattachement\n";
if ($praticien) {
    echo "Spécialité: " . $praticien->getSpecialite()->getLibelle() . "\n";
    $structure = $praticien->getStructure();
    if ($structure) {
        echo "Structure: " . $structure->getNom() . "\n";
    } else {
        echo "Aucune structure de rattachement\n";
    }
}

echo "\n\n";

echo "Exercice 1.4 : afficher la structure 3444bdd2-8783-3aed-9a5e-4d298d2a2d7c avec la liste de praticiens\n";
$structureId = '3444bdd2-8783-3aed-9a5e-4d298d2a2d7c';
$structure = $entityManager->find(Structure::class, $structureId);
if ($structure) {
    echo "Structure: " . $structure->getNom() . "\n";
    echo "Praticiens:\n";
    $praticiens = $entityManager->getRepository(Praticien::class)->findBy(['structure' => $structure]);
    foreach ($praticiens as $p) {
        echo "  - " . $p->getPrenom() . " " . $p->getNom() . "\n";
    }
}

echo "\n\n";

echo "Exercice 1.5 : afficher la spécialité d'identifiant 1 et les motifs de visite associés\n";
$specialite = $entityManager->find(Specialite::class, 1);
if ($specialite) {
    echo "Spécialité: " . $specialite->getLibelle() . "\n";
    $motifs = $entityManager->getRepository(MotifVisite::class)->findBy(['specialite' => $specialite]);
    foreach ($motifs as $motif) {
        echo "  - " . $motif->getLibelle() . "\n";
    }
}

echo "\n\n";

echo "Exercice 1.6 : praticien 8ae1400f-d46d-3b50-b356-269f776be532 : afficher la liste de ses motifs de visite\n";
if ($praticien) {
    echo "Praticien: " . $praticien->getPrenom() . " " . $praticien->getNom() . "\n";
    foreach ($praticien->getMotifsVisite() as $motif) {
        echo "  - " . $motif->getLibelle() . "\n";
    }
}

echo "\n\n";

echo "Exercice 1.7 : Créer un praticien, spécialité pédiatrie, et le sauvegarder dans la base\n";
$specialitePediatrie = $entityManager->getRepository(Specialite::class)->findOneBy(['libelle' => 'pédiatrie']);
if ($specialitePediatrie) {
    $nouveauPraticien = new Praticien();
    $nouveauPraticien->setNom('Dupont');
    $nouveauPraticien->setPrenom('Jean');
    $nouveauPraticien->setVille('Paris');
    $nouveauPraticien->setEmail('jean.dupont' . rand(0, 1000) . '@example.com');
    $nouveauPraticien->setTelephone('0102030405');
    $nouveauPraticien->setSpecialite($specialitePediatrie);
    
    $entityManager->persist($nouveauPraticien);
    $entityManager->flush();
    echo "Praticien créé avec l'ID : " . $nouveauPraticien->getId() . "\n";
}

echo "\n\n";

echo "Exercice 1.8 : Modifier ce praticien\n";
if (isset($nouveauPraticien)) {
    $structureCabinet = $entityManager->getRepository(Structure::class)->findOneBy(['nom' => 'Cabinet Bigot']);
    if ($structureCabinet) {
        $nouveauPraticien->setStructure($structureCabinet);
    }
    $nouveauPraticien->setVille('Paris');
    
    // Ajouter des motifs de visite (ceux de sa spécialité)
    $motifs = $entityManager->getRepository(MotifVisite::class)->findBy(['specialite' => $specialitePediatrie], null, 2);
    foreach ($motifs as $m) {
        $nouveauPraticien->addMotifVisite($m);
    }
    
    $entityManager->flush();
    echo "Praticien modifié.\n";
}

echo "\n\n";

echo "Exercice 1.9 : Supprimer ce praticien\n";
if (isset($nouveauPraticien)) {
    $id = $nouveauPraticien->getId();
    $entityManager->remove($nouveauPraticien);
    $entityManager->flush();
    echo "Praticien $id supprimé.\n";
}

echo "\n\n";

// ======================
// Exercice 2
// ======================

echo "Exercice 2.1 : Afficher le praticien dont le mail est Gabrielle.Klein@live.com\n";
$praticien = $entityManager->getRepository(Praticien::class)->findOneBy(['email' => 'Gabrielle.Klein@live.com']);
if ($praticien) {
    echo "Trouvé : " . $praticien->getPrenom() . " " . $praticien->getNom() . "\n";
}

echo "\n\n";

echo "Exercice 2.2 : Afficher le praticien de nom Goncalves à Paris\n";
$praticien = $entityManager->getRepository(Praticien::class)->findOneBy(['nom' => 'Goncalves', 'ville' => 'Paris']);
if ($praticien) {
    echo "Trouvé : " . $praticien->getPrenom() . " " . $praticien->getNom() . "\n";
}

echo "\n\n";

echo "Exercice 2.3 : Afficher la spécialité de libellé 'pédiatrie' ainsi que les praticiens associés\n";
$specialite = $entityManager->getRepository(Specialite::class)->findOneBy(['libelle' => 'pédiatrie']);
if ($specialite) {
    echo "Spécialité : " . $specialite->getLibelle() . "\n";
    $praticiens = $entityManager->getRepository(Praticien::class)->findBy(['specialite' => $specialite]);
    foreach ($praticiens as $p) {
        echo "  - " . $p->getPrenom() . " " . $p->getNom() . "\n";
    }
}

echo "\n\n";

echo "Exercice 2.4 : afficher les spécialités dont la description contient 'santé' (Criteria)\n";
$criteria = Criteria::create()
    ->where(Criteria::expr()->contains('description', 'santé'));
$specialites = $entityManager->getRepository(Specialite::class)->matching($criteria);
foreach ($specialites as $s) {
    echo "  - " . $s->getLibelle() . " : " . $s->getDescription() . "\n";
}

echo "\n\n";

echo "Exercice 2.5 : praticiens d'ophtalmologie à Paris\n";
$specOphtalmo = $entityManager->getRepository(Specialite::class)->findOneBy(['libelle' => 'ophtalmologie']);
if ($specOphtalmo) {
    $praticiens = $entityManager->getRepository(Praticien::class)->findBy(['specialite' => $specOphtalmo, 'ville' => 'Paris']);
    foreach ($praticiens as $p) {
        echo "  - " . $p->getPrenom() . " " . $p->getNom() . "\n";
    }
}

echo "\n\n";

// ======================
// Exercice 3
// ======================

echo "Exercice 3.1 : findByKeyword dans SpecialiteRepository\n";
$res31 = $entityManager->getRepository(Specialite::class)->findByKeyword('générale');
foreach ($res31 as $s) {
    echo "  - " . $s->getLibelle() . "\n";
}

echo "\n\n";

echo "Exercice 3.2 : findBySpecialiteKeyword dans PraticienRepository\n";
$res32 = $entityManager->getRepository(Praticien::class)->findBySpecialiteKeyword('générale');
foreach ($res32 as $p) {
    echo "  - " . $p->getPrenom() . " " . $p->getNom() . " (" . $p->getSpecialite()->getLibelle() . ")\n";
}

echo "\n\n";

echo "Exercice 3.3 : findBySpecialiteAndMoyenPaiement\n";
$res33 = $entityManager->getRepository(Praticien::class)->findBySpecialiteAndMoyenPaiement('médecine générale', 'espèces');
foreach ($res33 as $p) {
    echo "  - " . $p->getPrenom() . " " . $p->getNom() . "\n";
}

echo "\n\n";

echo "=== Fin du TD1 ===\n";

if (PHP_SAPI !== 'cli') {
    echo "</pre>";
}
