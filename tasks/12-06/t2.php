<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit', '16240M'); // Adjust as needed

const GUARD = '^';
const BOX = '#';

enum DIRECTION: string
{
    case UP = 'U';
    case RIGHT = 'R';
    case DOWN = 'D';
    case LEFT = 'L';
}

$start = microtime(true);

$time_elapsed_secs = microtime(true) - $start;

// $map = getFileContent("files/t2.example.txt");
$map = getFileContent("files/t2.txt");

$task1Travelled = [];

[$startX, $startY] = findGuard(0, 0, $map);


print_r("STARTING TO TRAVEL" . PHP_EOL);

travel($startX, $startY, $map, $task1Travelled, Direction::UP);
$time_elapsed_secs = microtime(true) - $start;

print_r("Arrived, TIME TAKEN - $time_elapsed_secs" . PHP_EOL);

$total = 0;

foreach ($task1Travelled as $travel) {
    $total += count($travel);
}

// printMap($map, $traveled);

$baisu = 0;
$obstacles = [];

// die(print_r($task1Travelled));


foreach ($task1Travelled as $x => $travel) {
    foreach ($travel as $y => $ygriks) {
        $tmp_trav = [];
        $tmp_map = $map;
        if ($tmp_map[$x][$y] !== BOX && $tmp_map[$x][$y] !== GUARD) {
            $tmp_map[$x][$y] = '#';

            // die();
            $loop = travelButFindLoop($startX, $startY, $tmp_map, $tmp_trav, DIRECTION::UP);

            if ($loop === 'LOOP') {
                $obstacles[$x][$y] = 'OBSTACLE';
            }
        }
    }
}

$time_elapsed_secs = microtime(true) - $start;

print_r("DONE \t TIME ELAPSED SECONDS - : $time_elapsed_secs" . PHP_EOL);

$possibleObstacles = 0;

foreach ($obstacles as $obstacle) {
    $possibleObstacles += count($obstacle);
}

print_r("TOTAL OBSTACLES TO LOOP = $possibleObstacles" . PHP_EOL);


function travelButFindLoop($x, $y, $map, &$traveled, $direction, $lastX = null, $lastY = null, $sanityCheck = 50)
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

        // print_r("SETTING_TRAVELLED DISTANCE x: $x y: $y \n Current count :" . $traveled[$x][$y] . PHP_EOL);
        //#check lastx lasty also for improvement

        // $prevCount = isset($traveled[$lastX][$lastY]) ? $traveled[$lastX][$lastY] : 0;
        // if (($traveled[$x][$y] > $sanityCheck) && ($prevCount > $sanityCheck - 20)) {

        if (($traveled[$x][$y] > $sanityCheck)) {
            return "LOOP";
        }
    } else {
        $direction = changeDirection($direction);
        $x = $lastX;
        $y = $lastY;
    }
    switch ($direction) {
        case DIRECTION::UP:
            return travelButFindLoop(--$x, $y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::RIGHT:
            return travelButFindLoop($x, ++$y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::DOWN:
            return travelButFindLoop(++$x, $y, $map, $traveled, $direction, $lastX, $lastY);
            break;
        case DIRECTION::LEFT:
            return travelButFindLoop($x, --$y, $map, $traveled, $direction, $lastX, $lastY);
            break;
    }
}


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

function printMap($map, $travelled = null)
{
    $line = "";
    foreach ($map as $x => $values) {
        foreach ($values as $y => $ygriks) {
            if (($travelled !== null) && isset($travelled[$x][$y])) {
                $line = $line . ' ' . '+';
            } else {
                $line = $line . ' ' . $map[$x][$y];
            }
        }
        $line = $line . PHP_EOL;
    }

    print_r($line);
}
