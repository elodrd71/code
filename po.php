<?php

// class abstraite
abstract class FileSystem
{
    protected $name;
    protected $size;

    public function __construct(string $name,int $size = null) {
        $this->name = $name;
        $this->size = $size;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}

// Dossier
class Dossier extends FileSystem
{
    /** @var FileSystem[] */
    private array $enfants = [];

    public function ajouter(FileSystem $enfant): void
    {
        $this->enfants[$enfant->getName()] = $enfant;
    }

    public function getEnfant(string $nom): ?FileSystem
    {
        return $this->enfants[$nom] ?? null;
    }
}

// Fichier
class Fichier extends FileSystem
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


