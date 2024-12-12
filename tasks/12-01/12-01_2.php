<?php

##Wanna see how looping will work

$lines = file("input2.txt");

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

foreach ($left as $leftVal) {
    $appears = 0;
    foreach ($right as $rightVal) {

        $equal = $rightVal  === $leftVal;
        $appears += $equal ? 1 : 0;
    }
    $distances[] = $leftVal * $appears;
}

die(var_dump(array_sum(($distances))));