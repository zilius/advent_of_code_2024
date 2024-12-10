<?php

declare(strict_types=1);

require 'Classes/TaskFile.php';
require 'Classes/PathPlace.php';
require 'Classes/PathPlaceRepository.php';
require 'Classes/PathTraveler.php';

// $file = new TaskFile("input_test.txt");
$file = new TaskFile("input_test.txt");

$file->readFileToArray();
$content = $file->getContent();

$places = [];


foreach ($content as $x => $line) {
    foreach ($line as $y => $place) {
        $x = (int)$x;
        $y = (int)$y;
        $value = (int)$place;
        $pathPlace = new PathPlace($x, $y, $value, null, null, null, null);
        $places[] = $pathPlace;
    }
}

$repo = new PathPlaceRepostiory($places);

#Assign neighbours
foreach ($places as $place) {
    $north = $repo->findByXY($place->getX() - 1, $place->getY());
    $east = $repo->findByXY($place->getX(), $place->getY() + 1);
    $south = $repo->findByXY($place->getX() + 1, $place->getY());
    $west = $repo->findByXY($place->getX(), $place->getY() - 1);

    $place->setNeighbourNorth($north);
    $place->setNeighbourEast($east);
    $place->setNeighbourSouth($south);
    $place->setNeighbourWest($west);
}

#Walk
$traveler = new PathTraveler($repo->findByXY(0,4));

$traveler->showWhereCanGo();
die();
