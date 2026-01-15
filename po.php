<?php

// ==============================
// 1. Classe abstraite commune
// ==============================
abstract class NoeudSystemeFichier
{
    protected string $nom;
    protected ?int $taille;
    protected ?DateTime $dateModification;
    protected ?string $auteur;

    public function __construct(
        string $nom,
        ?int $taille = null,
        ?DateTime $dateModification = null,
        ?string $auteur = null
    ) {
        $this->nom = $nom;
        $this->taille = $taille;
        $this->dateModification = $dateModification;
        $this->auteur = $auteur;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function ajouter(NoeudSystemeFichier $enfant): void
    {
        // Par défaut, un noeud ne peut pas avoir d'enfants.
        throw new \LogicException('Impossible d\'ajouter un enfant à ce type de noeud');
    }

    abstract public function afficher(string $prefix = '', bool $estDernier = true): void;
}

// ==============================
// 2. Dossier (Composite)
// ==============================
class Dossier extends NoeudSystemeFichier
{
    /** @var NoeudSystemeFichier[] */
    private array $enfants = [];

    public function ajouter(NoeudSystemeFichier $enfant): void
    {
        $this->enfants[$enfant->getNom()] = $enfant;
    }

    public function getEnfant(string $nom): ?NoeudSystemeFichier
    {
        return $this->enfants[$nom] ?? null;
    }

    public function afficher(string $prefix = '', bool $estDernier = true): void
    {
        // Affiche le nom du dossier avec les branches.
        echo $prefix;
        echo $estDernier ? '└─ ' : '├─ ';
        echo $this->nom . PHP_EOL;

        // Nouveau préfixe pour les enfants.
        $nouveauPrefix = $prefix . ($estDernier ? '   ' : '│  ');

        $total = count($this->enfants);
        $i = 0;

        foreach ($this->enfants as $enfant) {
            $i++;
            $enfantEstDernier = ($i === $total);
            $enfant->afficher($nouveauPrefix, $enfantEstDernier);
        }
    }
}

// ==============================
// 3. Fichier (Feuille)
// ==============================
class Fichier extends NoeudSystemeFichier
{
    public function afficher(string $prefix = '', bool $estDernier = true): void
    {
        echo $prefix;
        echo $estDernier ? '└─ ' : '├─ ';
        echo $this->nom . PHP_EOL;
    }
}

// ==============================
// 4. Constructeur de l'arbre
// ==============================
class ConstructeurSystemeFichier
{
    public function construire(array $chemins): Dossier
    {
        // Racine logique de l'arbre.
        $racine = new Dossier('/');

        foreach ($chemins as $chemin) {
            $this->ajouterChemin($racine, $chemin);
        }

        return $racine;
    }

    private function ajouterChemin(Dossier $racine, string $chemin): void
    {
        // "/home/josh/app/index.js" -> ['home','josh','app','index.js']
        $segments = array_values(array_filter(explode('/', $chemin)));

        $courant = $racine;
        $dernierIndex = count($segments) - 1;

        foreach ($segments as $index => $segment) {
            $estDernier = ($index === $dernierIndex);

            if ($estDernier) {
                // On considère le dernier segment comme un fichier.
                $fichier = new Fichier($segment);
                $courant->ajouter($fichier);
            } else {
                $enfant = $courant->getEnfant($segment);

                if (!$enfant instanceof Dossier) {
                    $enfant = new Dossier($segment);
                    $courant->ajouter($enfant);
                }

                $courant = $enfant;
            }
        }
    }
}

// ==============================
// 5. Exemple d'utilisation
// ==============================

$chemins = [
    "/home/josh/project/app/src/index.js",
    "/home/peter/.bashrc",
    "/home/josh/project/app/images/logo1.png",
    "/home/josh/project/app/images/logo2.png",
    "/home/peter/.profile",
    "/home/peter/test",
    "/var/log",
    "/usr/lib/node14",
    "/home/josh/project/app/test.jpg",
    "/home/josh/project/app/images/logo3.png",
    "/opt/apache2",
    "/etc/hosts",
];

$constructeur = new ConstructeurSystemeFichier();
$racine = $constructeur->construire($chemins);

// Affichage de l'arbre (on ne montre pas la racine "/" pour se rapprocher de ton exemple).
// Si tu veux afficher /, remplace la ligne suivante par : $racine->afficher();
foreach (['etc', 'home', 'opt', 'usr', 'var'] as $nomRacine) {
    $noeud = $racine->getEnfant($nomRacine);
    if ($noeud !== null) {
        // On suppose que chaque élément de premier niveau est indépendant.
        $noeud->afficher('', false);
    }
}
