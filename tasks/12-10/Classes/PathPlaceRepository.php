<?php

declare(strict_types=1);

class PathPlaceRepostiory
{
    public function __construct(private array $pathPlaces) {}

    public function findByXY(int $x, int $y): ?PathPlace
    {

        $pathPlace = array_filter(
            $this->pathPlaces,
            fn(PathPlace $pathPlace): bool => $pathPlace->getX() === $x
                && $pathPlace->getY() === $y
        );

        #In php need filter since original values will be preserved otherwise
        $pathPlace = array_values($pathPlace);
        return isset($pathPlace[0]) ? $pathPlace[0] : null;
    }
}
