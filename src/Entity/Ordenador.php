<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdenadorRepository")
 */
class Ordenador
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $procesador;

    /**
     * @ORM\Column(type="integer")
     */
    private $memoria;

    /**
     * @ORM\Column(type="integer")
     */
    private $precio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getProcesador(): ?string
    {
        return $this->procesador;
    }

    public function setProcesador(string $procesador): self
    {
        $this->procesador = $procesador;

        return $this;
    }

    public function getMemoria(): ?int
    {
        return $this->memoria;
    }

    public function setMemoria(int $memoria): self
    {
        $this->memoria = $memoria;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
