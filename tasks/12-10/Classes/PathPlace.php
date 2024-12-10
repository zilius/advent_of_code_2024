<?php

declare(strict_types=1);

class PathPlace
{
    public function __construct(
        private int $x,
        private int $y,
        private int $value,
        private ?PathPlace $neighbourNorth,
        private ?PathPlace $neighbourEast,
        private ?PathPlace $neighbourSouth,
        private ?PathPlace $neighbourWest
    ) {}
    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): PathPlace
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): PathPlace
    {
        $this->y = $y;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getNeighbourNorth(): ?PathPlace
    {
        return $this->neighbourNorth;
    }
    public function setNeighbourNorth(?PathPlace $neighbour): PathPlace
    {
        $this->neighbourNorth = $neighbour;
        return $this;
    }

    public function getNeighbourEast(): ?PathPlace
    {
        return $this->neighbourEast;
    }
    public function setNeighbourEast(?PathPlace $neighbour): PathPlace
    {
        $this->neighbourEast = $neighbour;
        return $this;
    }

    public function getNeighbourSouth(): ?PathPlace
    {
        return $this->neighbourSouth;
    }
    public function setNeighbourSouth(?PathPlace $neighbour): PathPlace
    {
        $this->neighbourSouth = $neighbour;
        return $this;
    }

    public function getNeighbourWest(): ?PathPlace
    {
        return $this->neighbourWest;
    }
    public function setNeighbourWest(?PathPlace $neighbour): PathPlace
    {
        $this->neighbourWest = $neighbour;
        return $this;
    }
}
