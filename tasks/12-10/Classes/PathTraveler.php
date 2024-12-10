<?php

declare(strict_types=1);

class PathTraveler
{
    public function __construct(
        private PathPlace $place
    ) {}

    public function travel() {}

    public function showWhereCanGo(): void
    {
        print_r([
            "north" => $this->canGoNorth(),
            "east" => $this->canGoEast(),
            "south" => $this->canGoSouth(),
            "west" => $this->canGoWest(),
        ]);
    }

    private function canGoNorth(): bool
    {
        $northyNeighbour = $this->place->getNeighbourNorth();
        if (null === $northyNeighbour) {
            return false;
        }

        return $this->place->getValue() + 1 == $northyNeighbour->getValue();
    }
    private function canGoEast(): bool
    {
        $eastyNeighbour = $this->place->getNeighbourEast();
        if (null === $eastyNeighbour) {
            return false;
        }

        return $this->place->getValue() + 1 == $eastyNeighbour->getValue();
    }
    private function canGoSouth(): bool
    {
        $southyNeighbour = $this->place->getNeighbourSouth();
        if (null === $southyNeighbour) {
            return false;
        }

        return $this->place->getValue() + 1 == $southyNeighbour->getValue();
    }
    private function canGoWest(): bool
    {
        $westyNeightbour = $this->place->getNeighbourWest();
        if (null === $westyNeightbour) {
            return false;
        }

        return $this->place->getValue() + 1 == $westyNeightbour->getValue();
    }
}
