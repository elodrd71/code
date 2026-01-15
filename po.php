<?php

// class abstraite
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
}

// Dossier
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
}

// Fichier
class Fichier extends NoeudSystemeFichier
{
    public function afficher(string $prefix = '', bool $estDernier = true): void
    {
        echo $prefix;
        echo $estDernier ? '└─ ' : '├─ ';
        echo $this->nom . PHP_EOL;
    }
}


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


