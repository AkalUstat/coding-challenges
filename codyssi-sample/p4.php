<?php
$path = __DIR__ . "/input/p4.in";
$fh = fopen($path, "r");

$places_set = [];
// read data
$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    [$place1, $rest] = explode(" <", $line);
    [$rest2, $place2] = explode("> ", $rest);

    $place1 = trim($place1);
    $place2 = trim($place2);

    if (!isset($places_set[$place1])) {
        $places_set[$place1] = true;
    }
    if (!isset($places_set[$place2])) {
        $places_set[$place2] = true;
    }
}

// Part one
echo "Part One: ", count($places_set), PHP_EOL;

// Part two (BFS)

// read and store mappings
$mappings = [];
foreach ($lines as $line) {
    [$place1, $rest] = explode(" <", $line);
    [$rest2, $place2] = explode("> ", $rest);

    $place1 = trim($place1);
    $place2 = trim($place2);

    if (!isset($mappings[$place1])) {
        $mappings[$place1] = [$place2];
    } else {
        $mappings[$place1][] = $place2;
    }

    // reciprocal adding
    if (!isset($mappings[$place2])) {
        $mappings[$place2] = [$place1];
    } else {
        $mappings[$place2][] = $place1;
    }
}
// print_r($mappings);

function bfs($start, $mappings, $max_dist)
{
    $current_level = [$start];

    $visited = [$start => true];

    $steps = 0;

    while ($steps < $max_dist) {
        $next_level = [];

        $next_level = [];

        foreach ($current_level as $place) {
            //    echo "At $place, can go to: ";

            if (isset($mappings[$place])) {
                foreach ($mappings[$place] as $connection) {
                    if (!isset($visited[$connection])) {
                        //          echo "$connection ";
                        $visited[$connection] = true;
                        $next_level[] = $connection;
                    }
                }
            }
            //  echo "\n";
        }

        $current_level = $next_level;
        $steps++;
    }

    return count($visited);
}

echo "Part Two: ", bfs("STT", $mappings, 3), PHP_EOL;

// Part Three

function dijkstra($mappings, $start)
{
    $distances = [];
    $queue = new SplPriorityQueue();

    // initialize distances to infinity
    foreach ($mappings as $node => $neighbor) {
        $distances[$node] = INF;
    }

    // add start node,  which has dist 0
    $distances[$start] = 0;
    // insert start to queue
    $queue->insert($start, 0);

    while (!$queue->isEmpty()) {
        // get queue element
        $element = $queue->extract();
        // get best current estimate
        $currentDist = $distances[$element];

        // if it is infinity, skip this iteration (not reachable at this current point)
        if ($currentDist === INF) {
            continue;
        }

        // if exists in the mapping
        if (isset($mappings[$element])) {
            foreach ($mappings[$element] as $neighbor) {
                // weight doesn't really matter
                $weight = 1;

                // add 1 to the distance
                $alt_path = $distances[$element] + $weight;

                // if it is better than the current estimate
                if ($alt_path < $distances[$neighbor]) {
                    // update ad add to the queue
                    $distances[$neighbor] = $alt_path;
                    // negative priority to put really in the back
                    $queue->insert($neighbor, -$alt_path);
                }
            }
        }
    }

    // get the sum of the distances
    return array_sum($distances);
}
echo "Part Three: ", dijkstra($mappings, "STT"), PHP_EOL;
