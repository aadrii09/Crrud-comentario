<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreAutor = null;

    #[ORM\Column(length: 255)]
    private ?string $texto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?int $numPositivas = null;

    #[ORM\Column]
    private ?int $numNegativas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreAutor(): ?string
    {
        return $this->nombreAutor;
    }

    public function setNombreAutor(string $nombreAutor): static
    {
        $this->nombreAutor = $nombreAutor;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): static
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getNumPositivas(): ?int
    {
        return $this->numPositivas;
    }

    public function setNumPositivas(int $numPositivas): static
    {
        $this->numPositivas = $numPositivas;

        return $this;
    }

    public function getNumNegativas(): ?int
    {
        return $this->numNegativas;
    }

    public function setNumNegativas(int $numNegativas): static
    {
        $this->numNegativas = $numNegativas;

        return $this;
    }
}
