<?php
$path = __DIR__ . "/input/p3.in";
$fh = fopen($path, "r");

$sensor_outputs = [];
// read data
$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$num_mappings = array_map(function ($value) {
    return explode(" ", $value);
}, $lines);

$base_counts = array_map(function ($val) {
    return $val[1];
}, $num_mappings);

echo "Part one: ", array_sum($base_counts), "\n";

// Part Two
$norm_to_base_10 = array_map(function ($val) {
    return base_convert($val[0], $val[1], 10);
}, $num_mappings);

echo "Part two: ", array_sum($norm_to_base_10), "\n";

function base_65_converter($val)
{
    $symbols =
        "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#";
    $base = strlen($symbols);
    $result = "";

    $number = (string) $val;

    if ($number === "0") {
        return $symbols[0];
    }

    while ($number > 0) {
        // get remainder
        $remainder = $number % $base;
        // prepend corresponding symbol
        $result = $symbols[$remainder] . $result;
        // reduce number to quotient
        $number = (int) ($number / $base);
    }

    // return prepared string
    return $result;
}

echo "Part three: ", base_65_converter(array_sum($norm_to_base_10)), "\n";

?>
