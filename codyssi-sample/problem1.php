<?php
// Part 1
$path = __DIR__ . "/input/p1.in";
$fh = fopen($path, "r");

$items = [];
while ($line = fgets($fh)) {
    $items[] = $line;
}
$items_sorted = $items;
rsort($items_sorted);

echo "Part One - Sum:", " ", array_sum($items), "\n";
// print_r($items);
// Part two
$post_coupon = array_slice($items_sorted, 20);
// print_r($post_coupon);
echo "Part Two - Sum:", " ", array_sum($post_coupon), "\n";

// Part Three
$sum = 0;
foreach ($items as $indx => $price) {
    if ($indx % 2 == 0) {
        $sum += $price;
    } else {
        $sum -= $price;
    }
}
echo "Part Three - Sum:", " ", $sum, "\n";
fclose($fh);

?>
