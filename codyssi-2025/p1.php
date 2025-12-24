<?php
$path = __DIR__ . "/input/p1.in";
$fh = fopen($path, "r");

$items = [];
while ($line = fgets($fh)) {
    $items[] = $line;
}

// split input
$initial_offset = array_first($items);
$numbers = array_slice($items, 1, count($items) - 2);
$operators = array_last($items);

// print_r($initial_offset);
// print_r($numbers);
// print_r($operators);

$op_map = ["+" => 1, "-" => -1];

// Part One
$final_offset = $initial_offset;
foreach ($numbers as $key => $value) {
    $op = $operators[$key];
    // echo $op . "\n";

    $sign = $op_map[$op];

    $signed_num = $sign * $value;

    $final_offset += $signed_num;
}

echo "Part One: " . $final_offset . "\n";

// Part Two
$operators = strrev(array_last($items));

$final_offset = $initial_offset;
foreach ($numbers as $key => $value) {
    $op = $operators[$key];
    // echo $op . "\n";

    $sign = $op_map[$op];

    $signed_num = $sign * $value;

    $final_offset += $signed_num;
}

echo "Part Two: " . $final_offset . "\n";

//  Part Three
//

function num_from_places($dig_one, $dig_two)
{
    return $dig_one * 10 + $dig_two;
}

$initial_offset = num_from_places($items[0], $items[1]);
$numbers = array_chunk(array_slice($items, 2, count($items) - 3), 2);

$final_offset = $initial_offset;
foreach ($numbers as $key => $value) {
    $op = $operators[$key];
    // echo $op . "\n";

    $sign = $op_map[$op];

    $digit_first = $value[0];
    $digit_second = $value[1];

    $num = num_from_places($digit_first, $digit_second);

    $signed_num = $sign * $num;

    $final_offset += $signed_num;
}

echo "Part Three: " . $final_offset . "\n";

?>
