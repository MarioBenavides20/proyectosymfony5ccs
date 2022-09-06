<?php

namespace App\Entity\Agricola;

use App\Repository\Agricola\productosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agricola.productos")
 * @ORM\Entity(repositoryClass=productosRepository::class)
 */
class productos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $existencia;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $costo;

    /**
     * @ORM\OneToMany(targetEntity=detCompras::class, mappedBy="producto")
     */
    private $detCompras;

    public function __construct()
    {
        $this->detCompras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
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

    public function getExistencia(): ?int
    {
        return $this->existencia;
    }

    public function setExistencia(?int $existencia): self
    {
        $this->existencia = $existencia;

        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(?float $costo): self
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * @return Collection<int, detCompras>
     */
    public function getDetCompras(): Collection
    {
        return $this->detCompras;
    }

    public function addDetCompra(detCompras $detCompra): self
    {
        if (!$this->detCompras->contains($detCompra)) {
            $this->detCompras[] = $detCompra;
            $detCompra->setProducto($this);
        }

        return $this;
    }

    public function removeDetCompra(detCompras $detCompra): self
    {
        if ($this->detCompras->removeElement($detCompra)) {
            // set the owning side to null (unless already changed)
            if ($detCompra->getProducto() === $this) {
                $detCompra->setProducto(null);
            }
        }

        return $this;
    }
}
