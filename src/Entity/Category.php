<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Config\TwigExtra\StringConfig;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    //#[ORM\GeneratedValue] c pour lauto incrementation we don't use it in this case
    #[ORM\Column(length: 100)]
    private ?String $Ref = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    public function getRef(): ?int
    {
        return $this->Ref;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
