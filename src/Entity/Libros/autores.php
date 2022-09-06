<?php

namespace App\Entity\Libros;

use App\Repository\Libros\autoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="libros.autores") //Esta es para crear un schema en postgres de manera independiente
 * @ORM\Entity(repositoryClass=autoresRepository::class)
 */
class autores
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
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $apellido;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @ORM\ManyToOne(targetEntity=paises::class, inversedBy="autores")
     */
    private $pais;

    /**
     * @ORM\OneToMany(targetEntity=libros::class, mappedBy="autor")
     */
    private $libros;

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getPais(): ?paises
    {
        return $this->pais;
    }

    public function setPais(?paises $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return Collection<int, libros>
     */
    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(libros $libro): self
    {
        if (!$this->libros->contains($libro)) {
            $this->libros[] = $libro;
            $libro->setAutor($this);
        }

        return $this;
    }

    public function removeLibro(libros $libro): self
    {
        if ($this->libros->removeElement($libro)) {
            // set the owning side to null (unless already changed)
            if ($libro->getAutor() === $this) {
                $libro->setAutor(null);
            }
        }

        return $this;
    }
}
