<?php

namespace App\Entity\Libros;

use App\Repository\Libros\librosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="libros.libros") //Esta es para crear un schema en postgres de manera independiente
 * @ORM\Entity(repositoryClass=librosRepository::class)
 */
class libros
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
     * @ORM\ManyToOne(targetEntity=editoriales::class, inversedBy="libros")
     */
    private $editorial;

    /**
     * @ORM\ManyToOne(targetEntity=autores::class, inversedBy="libros")
     */
    private $autor;

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

    public function getEditorial(): ?editoriales
    {
        return $this->editorial;
    }

    public function setEditorial(?editoriales $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }

    public function getAutor(): ?autores
    {
        return $this->autor;
    }

    public function setAutor(?autores $autor): self
    {
        $this->autor = $autor;

        return $this;
    }
}
