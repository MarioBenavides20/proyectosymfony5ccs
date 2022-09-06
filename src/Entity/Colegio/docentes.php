<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\docentesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="colegio.docentes")
 * @ORM\Entity(repositoryClass=docentesRepository::class)
 */
class docentes
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
    private $identificacion;

    /**
     * @ORM\Column(type="text")
     */
    private $nombres;

    /**
     * @ORM\Column(type="text")
     */
    private $apellidos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $barrio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity=materias::class, mappedBy="docente")
     */
    private $materias;

    public function __construct()
    {
        $this->materias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): self
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getBarrio(): ?string
    {
        return $this->barrio;
    }

    public function setBarrio(?string $barrio): self
    {
        $this->barrio = $barrio;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * @return Collection<int, materias>
     */
    public function getMaterias(): Collection
    {
        return $this->materias;
    }

    public function addMateria(materias $materia): self
    {
        if (!$this->materias->contains($materia)) {
            $this->materias[] = $materia;
            $materia->setDocente($this);
        }

        return $this;
    }

    public function removeMateria(materias $materia): self
    {
        if ($this->materias->removeElement($materia)) {
            // set the owning side to null (unless already changed)
            if ($materia->getDocente() === $this) {
                $materia->setDocente(null);
            }
        }

        return $this;
    }
}
