<?php

namespace App\Entity;

use App\Repository\CriteriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriteriaRepository::class)]
class Criteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $smoking = null;

    #[ORM\Column]
    private ?bool $animals = null;

    #[ORM\Column]
    private ?bool $womenOnly = null;

    #[ORM\Column]
    private ?bool $manOnly = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSmoking(): ?bool
    {
        return $this->smoking;
    }

    public function setSmoking(bool $smoking): self
    {
        $this->smoking = $smoking;

        return $this;
    }

    public function isAnimals(): ?bool
    {
        return $this->animals;
    }

    public function setAnimals(bool $animals): self
    {
        $this->animals = $animals;

        return $this;
    }

    public function isWomenOnly(): ?bool
    {
        return $this->womenOnly;
    }

    public function setWomenOnly(bool $womenOnly): self
    {
        $this->womenOnly = $womenOnly;

        return $this;
    }

    public function isManOnly(): ?bool
    {
        return $this->manOnly;
    }

    public function setManOnly(bool $manOnly): self
    {
        $this->manOnly = $manOnly;

        return $this;
    }
}
