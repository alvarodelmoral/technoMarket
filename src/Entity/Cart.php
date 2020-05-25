<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartContent", mappedBy="cart", orphanRemoval=true)
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->content = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CartContent[]
     */
    public function getContent(): Collection
    {
        return $this->content;
    }

    public function addContent(CartContent $content): self
    {
        if (!$this->content->contains($content)) {
            $this->content[] = $content;
            $content->setCart($this);
        }

        return $this;
    }

    public function removeContent(CartContent $content): self
    {
        if ($this->content->contains($content)) {
            $this->content->removeElement($content);
            // set the owning side to null (unless already changed)
            if ($content->getCart() === $this) {
                $content->setCart(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTotal()
    {
        $resultado = 0;

        foreach ($this->content as $content) {
            $resultado += $content->getQuantity() * $content->getProducto()->getPrecio();
        }

        return $resultado;
    }
}