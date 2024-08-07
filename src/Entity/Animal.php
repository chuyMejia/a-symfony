<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="animales")
 * @ORM\Entity(repositoryClass="App\Repository\AnimalRepository")
 */
class Animal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^[a-zA-Z]+$/")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^[a-zA-Z]+$/")
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="raza", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^[a-zA-Z]+$/")
     */
    private $raza;

    /**
     * @var string
     *
     * @ORM\Column(name="tamano", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(
     *               pattern="/^[0-9]+$/",
     *               message="only admit number's 0-9 ")
     */
    private $tamano;

    // Getters y setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(string $raza): self
    {
        $this->raza = $raza;
        return $this;
    }

    public function getTamano(): ?string
    {
        return $this->tamano;
    }

    public function setTamano(string $tamano): self
    {
        $this->tamano = $tamano;
        return $this;
    }
}
