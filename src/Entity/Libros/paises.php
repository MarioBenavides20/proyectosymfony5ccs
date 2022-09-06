<?php

namespace App\Entity\Libros;

use App\Repository\Libros\paisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="libros.paises") //Esta es para crear un schema en postgres de manera independiente
 * @ORM\Entity(repositoryClass=paisesRepository::class)
 */
class paises
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
    private $pais;

    /**
     * @ORM\OneToMany(targetEntity=autores::class, mappedBy="pais")
     */
    private $autores;

    /**
     * @ORM\OneToMany(targetEntity=editoriales::class, mappedBy="pais")
     */
    private $editoriales;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
        $this->editoriales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(?string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return Collection<int, autores>
     */
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutore(autores $autore): self
    {
        if (!$this->autores->contains($autore)) {
            $this->autores[] = $autore;
            $autore->setPais($this);
        }

        return $this;
    }

    public function removeAutore(autores $autore): self
    {
        if ($this->autores->removeElement($autore)) {
            // set the owning side to null (unless already changed)
            if ($autore->getPais() === $this) {
                $autore->setPais(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, editoriales>
     */
    public function getEditoriales(): Collection
    {
        return $this->editoriales;
    }

    public function addEditoriale(editoriales $editoriale): self
    {
        if (!$this->editoriales->contains($editoriale)) {
            $this->editoriales[] = $editoriale;
            $editoriale->setPais($this);
        }

        return $this;
    }

    public function removeEditoriale(editoriales $editoriale): self
    {
        if ($this->editoriales->removeElement($editoriale)) {
            // set the owning side to null (unless already changed)
            if ($editoriale->getPais() === $this) {
                $editoriale->setPais(null);
            }
        }

        return $this;
    }
}
