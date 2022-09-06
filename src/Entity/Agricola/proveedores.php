<?php

namespace App\Entity\Agricola;

use App\Repository\Agricola\proveedoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agricola.proveedores")
 * @ORM\Entity(repositoryClass=proveedoresRepository::class)
 */
class proveedores
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
    private $nit;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $direccion;

    /**
     * @ORM\OneToMany(targetEntity=cabCompras::class, mappedBy="proveedor")
     */
    private $cabCompras;

    public function __construct()
    {
        $this->cabCompras = new ArrayCollection();
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

    public function getNit(): ?string
    {
        return $this->nit;
    }

    public function setNit(?string $nit): self
    {
        $this->nit = $nit;

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

    /**
     * @return Collection<int, cabCompras>
     */
    public function getCabCompras(): Collection
    {
        return $this->cabCompras;
    }

    public function addCabCompra(cabCompras $cabCompra): self
    {
        if (!$this->cabCompras->contains($cabCompra)) {
            $this->cabCompras[] = $cabCompra;
            $cabCompra->setProveedor($this);
        }

        return $this;
    }

    public function removeCabCompra(cabCompras $cabCompra): self
    {
        if ($this->cabCompras->removeElement($cabCompra)) {
            // set the owning side to null (unless already changed)
            if ($cabCompra->getProveedor() === $this) {
                $cabCompra->setProveedor(null);
            }
        }

        return $this;
    }
}
