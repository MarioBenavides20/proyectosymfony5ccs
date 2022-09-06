<?php

namespace App\Entity\Libros;

use App\Repository\Libros\editorialesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="libros.editoriales") //Esta es para crear un schema en postgres de manera independiente
 * @ORM\Entity(repositoryClass=editorialesRepository::class)
 */
class editoriales
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity=paises::class, inversedBy="editoriales")
     */
    private $pais;

    /**
     * @ORM\OneToMany(targetEntity=libros::class, mappedBy="editorial")
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
            $libro->setEditorial($this);
        }

        return $this;
    }

    public function removeLibro(libros $libro): self
    {
        if ($this->libros->removeElement($libro)) {
            // set the owning side to null (unless already changed)
            if ($libro->getEditorial() === $this) {
                $libro->setEditorial(null);
            }
        }

        return $this;
    }
}
