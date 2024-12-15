<?php


$content = getFileContent("files/t1_task.txt");

$muls = [];


foreach ($content as $s) {

    foreach ($s as $index => $val) {
        $m = isset($s[$index]) ? $s[$index] : null; #m
        $u = isset($s[$index + 1]) ? $s[$index + 1]  : null; #u
        $l = isset($s[$index + 2]) ? $s[$index + 2] : null; #l
        $b1 = isset($s[$index + 3]) ? $s[$index + 3] : null; #(
        $d1 = isset($s[$index + 4]) ? $s[$index + 4] : null; #1
        $d2 = isset($s[$index + 5]) ? $s[$index + 5] : null; #1
        $d3 = isset($s[$index + 6]) ? $s[$index + 6] : null; #1
        $c = isset($s[$index + 7]) ? $s[$index + 7] : null; #,
        $d4 = isset($s[$index + 8]) ? $s[$index + 8] : null; #1
        $d5 = isset($s[$index + 9]) ? $s[$index + 9] : null; #1
        $d6 = isset($s[$index + 10]) ? $s[$index + 10] : null; #1
        $b2 = isset($s[$index + 11]) ? $s[$index + 11] : null; #)

        // print_r(implode([$m, $u, $l, $b1, $d1, $d2, $d3, $c, $d4, $d5, $d6, $b2]) . " - ");

        #PUKE
        if ($m === 'm' && $u === 'u' && $l === 'l' && $b1 === '(') {
            #(x,x)
            if (ctype_digit($d1) && $d2 === ',' && ctype_digit($d3) && $c === ')') {
                $muls[] = "{$d1} * {$d3}";
            }
            #(xx,x)
            else if (ctype_digit($d1) && ctype_digit($d2) && $d3 === ',' && ctype_digit($c) && $d4 === ')') {
                $muls[] = "{$d1}{$d2} * {$c}";
            }
            #(xxx,x)
            else if (ctype_digit($d1) && ctype_digit($d2) && ctype_digit($d3)  && $c === ',' && ctype_digit($d4) && $d5 === ')') {
                $muls[] = "{$d1}{$d2}{$d3} * {$d4}";
            }
            #(xxx,xx)
            else if (ctype_digit($d1) && ctype_digit($d2) && ctype_digit($d3)  && $c === ',' && ctype_digit($d4) && ctype_digit($d5) && $d6 === ')') {
                $muls[] = "{$d1}{$d2}{$d3} * {$d4}{$d5}";
            }
            #(xxx,xxx)
            else if (ctype_digit($d1) && ctype_digit($d2) && ctype_digit($d3)  && $c === ',' && ctype_digit($d4) && ctype_digit($d5) && ctype_digit($d6) && $b2 === ')') {
                $muls[] = "{$d1}{$d2}{$d3} * {$d4}{$d5}{$d6}";
            }
            #(xx,xxx)
            else if (ctype_digit($d1) && ctype_digit($d2) && $d3 === ',' && ctype_digit($c) && ctype_digit($d4) && ctype_digit($d5) && $d6 === ')') {
                $muls[] = "{$d1}{$d2} * {$c}{$d4}{$d5}";
            }
            #(x,xxx)
            else if (ctype_digit($d1) && $d2 === ',' && ctype_digit($d3) && ctype_digit($c) && ctype_digit($d4) && $d5 === ')') {
                $muls[] = "{$d1} * {$d3}{$c}{$d4}";
            }
            #(xx,xx)
            else if (ctype_digit($d1) && ctype_digit($d2) && $d3 === ',' && ctype_digit($c) && ctype_digit($d4) && $d5 === ')') {
                $muls[] = "{$d1}{$d2} * {$c}{$d4}";
            }
            #(x,xx)
            else if (ctype_digit($d1) && $d2 === ',' && ctype_digit($d3) && ctype_digit($c) && $d4 === ')') {
                $muls[] = "{$d1} * {$d3}{$c}";
            } else {
                // print_r(implode([$m, $u, $l, $b1, $d1, $d2, $d3, $c, $d4, $d5, $d6, $b2]) . PHP_EOL);
            }
        }
        // print_r(PHP_EOL);

    }
}


$total = 0;

foreach ($muls as $mul) {

    $line = trim($mul);
    // var_dump($line);
    $line = explode(" * ", $line);
    $total += (int)$line[0] * (int)$line[1];
}

die(var_dump($total));


function suit($ch)
{
    return $ch === ")" || $ch === ',' || ctype_digit($ch);
}

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
