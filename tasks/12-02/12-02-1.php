<?php

declare(strict_types=0);

enum Direction
{
    case Incremental;
    case Decrease;
    case None;
    case TooBig;
}

function getFileContent($path): array
{
    $lines = file($path);

    $result = [];

    foreach ($lines as $lineContent) {
        $lineContent = trim($lineContent, "  ");
        $array = explode(" ", $lineContent);
        $result[] = $array;
    }

    return $result;
}


function checkIfOk(array $array): bool
{
    $result = true;
    $direction = null;

    foreach ($array as $index => $value) {
        $value = (int)$value;

        if (!isset($array[$index + 1])) {
            return $result;
        } else {
            $next = $array[$index + 1];

            $currentDirrection = checkDirection($value, $next);

            if ($currentDirrection === Direction::TooBig || $currentDirrection === Direction::None) {
                return false;
            }

            if (($direction !== null) && ($currentDirrection !== $direction)) {
                return false;
            }

            $direction = $currentDirrection;
        }
    }
}

function checkDirection(int $a, int $b, Direction $prev = null): Direction
{
    if ($prev === null)

        if (abs($a - $b) > 3) {
            return Direction::TooBig;
        } else if ($a - $b < 0) {
            return Direction::Incremental;
        } else if ($a - $b > 0) {
            return Direction::Decrease;
        } else {
            return Direction::None;
        }
}


$content = getFileContent("examples/task1.txt");

$goodLines = 0;

foreach ($content as $line) {
    if (checkIfOk($line)) {
        $goodLines++;
    }
}

var_dump($goodLines);
