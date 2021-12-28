<?php
$crabPositionsFile = fopen('input.txt', 'r') or die('Unable to open input file!');
$crabPositions = explode(',', fgets($crabPositionsFile));
fclose($crabPositionsFile);

$FIRST_POSITION = 0;
$LAST_POSITION = max($crabPositions);

$lowestCost = $LAST_POSITION * count($crabPositions);

/**
 * Go through each position between crabs and find the best cost
 */
for ($position = $FIRST_POSITION; $position < $LAST_POSITION; $position++) {
    $cost = 0;
    foreach ($crabPositions as $crabPosition) {
        $cost += abs($position - $crabPosition);
    }
    if ($cost < $lowestCost) {
        $lowestCost = $cost;
    }
}

echo $lowestCost;
