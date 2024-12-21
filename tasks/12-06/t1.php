<?php

const GUARD = '^';
const BOX = '#';

enum DIRECTION: string
{
    case UP = 'U';
    case RIGHT = 'R';
    case DOWN = 'D';
    case LEFT = 'L';
}

$map = getFileContent("files/t1.txt");

$traveled = [];

[$startX, $startY] = findGuard(0, 0, $map);

travel($startX, $startY, $map, $traveled, Direction::UP);

$total = 0;

foreach ($traveled as $travel) {
    $total += count($travel);
}

die(var_dump($total));

function travel($x, $y, $map, &$traveled, $direction, $lastX = null, $lastY = null)
{
    // die(var_dump($direction->value));
    $dir = $direction->value;
    // die(var_dump($dir));
    // print_r("\tArrived at: x: $x y: $y, direction: $dir \t from x: $lastX, y: $lastY \n");

    if (!isset($map[$x]) || !isset($map[$y])) {
        return $traveled;
    }
    if ($map[$x][$y] !== BOX) {
        isset($traveled[$x][$y]) ? $traveled[$x][$y]++ : $traveled[$x][$y] = 1;

        $lastX = $x;
        $lastY = $y;
    } else {
        $direction = changeDirection($direction);
        $x = $lastX;
        $y = $lastY;
    }
    switch ($direction) {
        case DIRECTION::UP:
            return travel(--$x, $y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::RIGHT:
            return travel($x, ++$y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::DOWN:
            return travel(++$x, $y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::LEFT:
            return travel($x, --$y, $map, $traveled, $direction, $lastX, $lastY);
            break;
    }
}

function changeDirection(DIRECTION $direction): DIRECTION
{
    if ($direction === DIRECTION::UP) {
        return DIRECTION::RIGHT;
    }
    if ($direction === DIRECTION::RIGHT) {
        return DIRECTION::DOWN;
    }
    if ($direction === DIRECTION::DOWN) {
        return DIRECTION::LEFT;
    }
    if ($direction === DIRECTION::LEFT) {
        return DIRECTION::UP;
    }
}

function getFileContent($path): array
{
    $lines = file($path);
    $map = [];

    foreach ($lines as $x => $lineContent) {

        $lineContent = trim($lineContent, "\n");
        $ygriks = str_split($lineContent);
        foreach ($ygriks as $y => $value) {
            $map[$x][$y] = $value;
        }
    }

    return $map;
}

function findGuard($x, $y, $map): array
{

    $maxY = count($map[0]) - 1;
    // $ob = $map[$x][$y];
    // var_dump("x:$x y:{$y} object - |$ob|}" . PHP_EOL);

    if (!isset($map[$x]) || !isset($map[$y])) {
        throw new Exception("Not found || nugrybavo  x: $x y: $y");
    }

    if ($map[$x][$y] === GUARD) {
        return [$x, $y];
    }

    if ($maxY === $y) {
        $x += 1;
        return findGuard($x++, 0, $map);
    } else {
        $y += 1;
        return findGuard($x, $y++, $map);
    }
}
