<?php

$grid = getFileContent("files/t1.txt");

$target = "XMAS";

$totalXmas = 0;

foreach ($grid as $x => $line) {
    foreach ($line as $y => $letter) {
        $horizontalXmas =
            (isset($grid[$x][$y]) ? $grid[$x][$y] : '') .
            (isset($grid[$x][$y + 1]) ? $grid[$x][$y + 1] : '') .
            (isset($grid[$x][$y + 2]) ? $grid[$x][$y + 2] : '') .
            (isset($grid[$x][$y + 3]) ? $grid[$x][$y + 3] : '');

        $verticalXmas =
            (isset($grid[$x][$y]) ? $grid[$x][$y] : '') .
            (isset($grid[$x - 1][$y]) ? $grid[$x - 1][$y] : '') .
            (isset($grid[$x - 2][$y]) ? $grid[$x - 2][$y] : '') .
            (isset($grid[$x - 3][$y]) ? $grid[$x - 3][$y] : '');

        $diaRXmas =
            (isset($grid[$x][$y]) ? $grid[$x][$y] : '') .
            (isset($grid[$x + 1][$y + 1]) ? $grid[$x + 1][$y + 1] : '') .
            (isset($grid[$x + 2][$y + 2]) ? $grid[$x + 2][$y + 2] : '') .
            (isset($grid[$x + 3][$y + 3]) ? $grid[$x + 3][$y + 3] : '');

        $diaLXmas =
            (isset($grid[$x][$y]) ? $grid[$x][$y] : '') .
            (isset($grid[$x + 1][$y - 1]) ? $grid[$x + 1][$y - 1] : '') .
            (isset($grid[$x + 2][$y - 2]) ? $grid[$x + 2][$y - 2] : '') .
            (isset($grid[$x + 3][$y - 3]) ? $grid[$x + 3][$y - 3] : '');

        if (strrev($horizontalXmas) === $target || $horizontalXmas === $target) {
            $totalXmas++;
        }
        if (strrev($verticalXmas) === $target || $verticalXmas === $target) {
            $totalXmas++;
        }
        if (strrev($diaRXmas) === $target || $diaRXmas === $target) {
            $totalXmas++;
        }
        if (strrev($diaLXmas) === $target || $diaLXmas === $target) {
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
