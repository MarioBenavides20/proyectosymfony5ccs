<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\estudiantesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="colegio.estudiantes")
 * @ORM\Entity(repositoryClass=estudiantesRepository::class)
 */
class estudiantes
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
     * @ORM\Column(type="text")
     */
    private $direccion;

    /**
     * @ORM\Column(type="text")
     */
    private $barrio;

    /**
     * @ORM\Column(type="text")
     */
    private $telefono;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

    /**
     * @ORM\OneToMany(targetEntity=notas::class, mappedBy="estudiante")
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

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getBarrio(): ?string
    {
        return $this->barrio;
    }

    public function setBarrio(string $barrio): self
    {
        $this->barrio = $barrio;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

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
            $nota->setEstudiante($this);
        }

        return $this;
    }

    public function removeNota(notas $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getEstudiante() === $this) {
                $nota->setEstudiante(null);
            }
        }

        return $this;
    }
}
