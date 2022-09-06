<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\materiasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="colegio.materias")
 * @ORM\Entity(repositoryClass=materiasRepository::class)
 */
class materias
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity=docentes::class, inversedBy="materias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $docente;

    /**
     * @ORM\OneToMany(targetEntity=notas::class, mappedBy="materia")
     */
    private $notas;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDocente(): ?docentes
    {
        return $this->docente;
    }

    public function setDocente(?docentes $docente): self
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * @return Collection<int, notas>
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(notas $nota): self
    {
        if (!$this->notas->contains($nota)) {
            $this->notas[] = $nota;
            $nota->setMateria($this);
        }

        return $this;
    }

    public function removeNota(notas $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getMateria() === $this) {
                $nota->setMateria(null);
            }
        }

        return $this;
    }
}
