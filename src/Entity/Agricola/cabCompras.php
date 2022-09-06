<?php

namespace App\Entity\Agricola;

use App\Repository\Agricola\cabComprasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agricola.cabcompras")
 * @ORM\Entity(repositoryClass=cabComprasRepository::class)
 */
class cabCompras
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=proveedores::class, inversedBy="cabCompras")
     */
    private $proveedor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=detCompras::class, mappedBy="compra")
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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getProveedor(): ?proveedores
    {
        return $this->proveedor;
    }

    public function setProveedor(?proveedores $proveedor): self
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(?int $estado): self
    {
        $this->estado = $estado;

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
            $detCompra->setCompra($this);
        }

        return $this;
    }

    public function removeDetCompra(detCompras $detCompra): self
    {
        if ($this->detCompras->removeElement($detCompra)) {
            // set the owning side to null (unless already changed)
            if ($detCompra->getCompra() === $this) {
                $detCompra->setCompra(null);
            }
        }

        return $this;
    }
}
