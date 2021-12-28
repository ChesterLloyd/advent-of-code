<?php
$crabPositionsFile = fopen('input.txt', 'r') or die('Unable to open input file!');
$crabPositions = explode(',', fgets($crabPositionsFile));
fclose($crabPositionsFile);

$FIRST_POSITION = 0;
$LAST_POSITION = max($crabPositions);

$lowestCost = calculateCost($FIRST_POSITION, $LAST_POSITION) * count($crabPositions);

/**
 * Go through each position between crabs and find the best cost
 */
for ($position = $FIRST_POSITION; $position < $LAST_POSITION; $position++) {
    $cost = 0;
    foreach ($crabPositions as $crabPosition) {
        $cost += calculateCost($position, $crabPosition);
    }
    if ($cost < $lowestCost) {
        $lowestCost = $cost;
    }
}

/**
 * Calculates the new crab positions based on nth term.
 *
 * @param int $previousPosition
 * @param int $newPosition
 * @return float
 */
function calculateCost(int $previousPosition, int $newPosition): float
{
    $n = abs($previousPosition - $newPosition);
    return 0.5 * ($n ** 2) + 0.5 * $n;
}

echo $lowestCost;
