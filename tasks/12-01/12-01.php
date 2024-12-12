<?php

$lines = file("input.txt");

$numberOfLines = count($lines);

$left = [];
$right = [];

foreach ($lines as $lineContent) {
    $lineContent = trim($lineContent, "   ");
    $array = explode("   ", $lineContent);
    $left[] = (int)trim($array[0]);
    $right[] = (int)trim($array[1]);
}

asort($left);
asort($right);

$left = array_values($left);
$right = array_values($right);

$distances = [];


foreach($left as $index => $minval) {
    $distances[] = abs($minval - $right[$index]);
}

// die(var_dump($left, $right, $distances));


die(var_dump(array_sum($distances)));