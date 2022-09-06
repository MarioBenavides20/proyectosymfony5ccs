<?php

namespace App\Entity\Agricola;

use App\Repository\Agricola\detComprasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agricola.detcompras")
 * @ORM\Entity(repositoryClass=detComprasRepository::class)
 */
class detCompras
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=cabCompras::class, inversedBy="detCompras")
     */
    private $compra;

    /**
     * @ORM\ManyToOne(targetEntity=productos::class, inversedBy="detCompras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $cant;

    /**
     * @ORM\Column(type="float")
     */
    private $vrunidad;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $subtotal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $iva;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vriva;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompra(): ?cabCompras
    {
        return $this->compra;
    }

    public function setCompra(?cabCompras $compra): self
    {
        $this->compra = $compra;

        return $this;
    }

    public function getProducto(): ?productos
    {
        return $this->producto;
    }

    public function setProducto(?productos $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCant(): ?int
    {
        return $this->cant;
    }

    public function setCant(int $cant): self
    {
        $this->cant = $cant;

        return $this;
    }

    public function getVrunidad(): ?float
    {
        return $this->vrunidad;
    }

    public function setVrunidad(float $vrunidad): self
    {
        $this->vrunidad = $vrunidad;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(?float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getIva(): ?int
    {
        return $this->iva;
    }

    public function setIva(?int $iva): self
    {
        $this->iva = $iva;

        return $this;
    }

    public function getVriva(): ?float
    {
        return $this->vriva;
    }

    public function setVriva(?float $vriva): self
    {
        $this->vriva = $vriva;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
