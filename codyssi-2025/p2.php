<?php

$path = __DIR__ . "/input/p2.in";
$fh = fopen($path, "r");

$items = [];
while ($line = fgets($fh)) {
    $items[] = $line;
}

$numbers = array_slice($items, 4, count($items));
// print_r($numbers);
//
sort($numbers);
// print_r($numbers);

function find_median($sorted_array)
{
    $num_items = count($sorted_array);

    // this rounds down; in the even case, this will mean that this will
    // be the index of the left-hand number
    $middle = floor(($num_items - 1) / 2);

    // given an even number of items, use the avg
    if ($num_items % 2 == 0) {
        $left = $sorted_array[$middle];
        $right = $sorted_array[$middle + 1];
        return ($left + $right) / 2;
    } else {
        return $sorted_array[$middle];
    }
}

function a($num)
{
    global $items;
    return $num + array_last(explode(" ", $items[0]));
}
function b($num)
{
    global $items;
    return $num * array_last(explode(" ", $items[1]));
}
function c($num)
{
    global $items;
    return $num ** array_last(explode(" ", $items[2]));
}

$median = find_median($numbers);
echo "Part One: " . a(b(c($median))) . "\n";

// Part Two
$evens = array_filter($numbers, function ($val) {
    return $val % 2 == 0;
});

$evens_sum = array_sum($evens);
echo "Part Two: " . a(b(c($evens_sum))) . "\n";

// Part Three
$limit = 15000000000000;

// calculate the maximum possible quality from the limit; simplifies computation
// if a(b(c(y))) < l, where a(b(c(y))) = 55y^3 + 495
// then it can be said that y < cbrt((l - 495)/55)

$add = array_last(explode(" ", $items[0]));
$mult = array_last(explode(" ", $items[1]));
$exp = array_last(explode(" ", $items[2]));

$y_upper_limit = pow(($limit - $add) / $mult, 1 / $exp);

// binary search through the sorted list
$low_indx = 0;
$high_indx = count($numbers) - 1;

while ($low_indx < $high_indx) {
    $midpoint = floor(($low_indx + $high_indx) / 2);
    $y = $numbers[$midpoint];

    if ($y < $y_upper_limit) {
        $low_indx = $midpoint + 1;
    } else {
        $high_indx = $midpoint;
    }
}

$final_indx = $low_indx - 1;
if ($final_indx < 0) {
    echo "Upper bound not found";
} else {
    echo "Part Three: " . $numbers[$final_indx] . "\n";
}
?>
