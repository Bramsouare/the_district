<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Plat::class)]
    private Collection $panierBd;

    public function __construct()
    {
        $this->panierBd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPanierBd(): Collection
    {
        return $this->panierBd;
    }

    public function addPanierBd(Plat $panierBd): static
    {
        if (!$this->panierBd->contains($panierBd)) {
            $this->panierBd->add($panierBd);
        }

        return $this;
    }

    public function removePanierBd(Plat $panierBd): static
    {
        $this->panierBd->removeElement($panierBd);

        return $this;
    }
}
