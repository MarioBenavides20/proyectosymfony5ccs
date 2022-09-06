<?php

namespace App\Entity\Agricola;

use App\Repository\Agricola\nocompraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agricola.nocompra")
 * @ORM\Entity(repositoryClass=nocompraRepository::class)
 */
class nocompra
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $no_actual;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoActual(): ?string
    {
        return $this->no_actual;
    }

    public function setNoActual(?string $no_actual): self
    {
        $this->no_actual = $no_actual;

        return $this;
    }
}
