<?php

$grid = getFileContent("files/t2.txt");

$target = "MAS";

$totalXmas = 0;

foreach ($grid as $x => $line) {
    foreach ($line as $y => $letter) {

        $masR =
            (isset($grid[$x][$y]) ? $grid[$x][$y] : '') .
            (isset($grid[$x + 1][$y + 1]) ? $grid[$x + 1][$y + 1] : '') .
            (isset($grid[$x + 2][$y + 2]) ? $grid[$x + 2][$y + 2] : '');

        $masL =
            (isset($grid[$x][$y + 2]) ? $grid[$x][$y  + 2] : '') .
            (isset($grid[$x + 1][$y + 1]) ? $grid[$x + 1][$y + 1] : '') .
            (isset($grid[$x + 2][$y]) ? $grid[$x + 2][$y] : '');

        if (
            (strrev($masR) === $target || $masR === $target) &&
            (strrev($masL) === $target || $masL === $target)
        ) {
            $totalXmas++;
        }
    }
}

die(var_dump($totalXmas));



function getFileContent($path): array
{
    $lines = file($path);

    $result = [];

    foreach ($lines as $lineContent) {
        $symbols = str_split($lineContent);
        $result[] = $symbols;
    }

    return $result;
}
