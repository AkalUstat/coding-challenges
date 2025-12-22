<?php
$path = __DIR__ . "/input/p2.in";
$fh = fopen($path, "r");

$sensor_outputs = [];
// read data
$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$sensor_outputs = array_map(function ($value) {
    return filter_var(trim($value), FILTER_VALIDATE_BOOLEAN);
}, $lines);

// Part one
// filter non true values
$filtered = array_filter($sensor_outputs, function ($val) {
    return $val == 1;
});
$sum = array_reduce(
    array_keys($filtered),
    function ($carry, $curr) {
        return $carry + $curr + 1;
    },
    0,
);

echo "Part One: ", $sum, "\n";

// Get pairs
$chunks = array_chunk($sensor_outputs, 2);
$sum = 0;
foreach ($chunks as $key => $pair) {
    $element1 = $pair[0];
    $element2 = $pair[1];

    if ($key % 2 == 0) {
        $sum += $element1 && $element2;
    } else {
        $sum += $element1 || $element2;
    }
}

echo "Part Two: ", $sum, "\n";

// Part three
$num_sensors = count($filtered);
$sensors = $sensor_outputs;
$sum = $num_sensors;
while (count($sensors) != 1) {
    $temp = [];
    $chunks = array_chunk($sensors, 2);

    foreach ($chunks as $key => $pair) {
        $element1 = $pair[0];
        // if odd, just pass the element to the array
        if (!isset($pair[1])) {
            $temp[] = $element1;
            continue;
        }

        $element2 = $pair[1];

        $and = $element1 && $element2;
        $or = $element1 || $element2;
        if ($key % 2 == 0) {
            $sum += $and;
            $temp[] = $and;
        } else {
            $sum += $or;
            $temp[] = $or;
        }
    }

    $sensors = $temp;
}

echo "Part Three: ", $sum, "\n";

?>
