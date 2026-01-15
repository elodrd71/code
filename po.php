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
    private array $child = [];

    public function __construct(string $name, int $size)
    {
        parent::__construct($name, $size);
        $this->type = $type;
    }

    public function add (FileSystem $element): void
    {
        $this->child[] = $element;
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


