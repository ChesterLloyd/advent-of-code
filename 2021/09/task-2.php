<?php
$heightMapFile = fopen('input.txt', 'r') or die('Unable to open input file!');

$MAX_HEIGHT = 9;

$basins = [];
$heightMap = [];
$lowPoints = [];
$visitedPoints = [];

/*
 * Build the heightmap
 */
while (!feof($heightMapFile)) {
    $heightMap[] = str_split(str_replace(PHP_EOL, '', fgets($heightMapFile)));
}
fclose($heightMapFile);

/*
 * Go through each position and check its neighbours
 */
foreach ($heightMap as $rowKey => $row) {
    foreach ($row as $positionKey => $positionHeight) {
        if ($positionKey > 0 && $row[$positionKey - 1] <= $positionHeight) {
            // Check left
            continue;
        }
        if (($positionKey < count($row) - 1) && $row[$positionKey + 1] <= $positionHeight) {
            // Check right
            continue;
        }
        if (($rowKey > 0) && $heightMap[$rowKey - 1][$positionKey] <= $positionHeight) {
            // Check up
            continue;
        }
        if (($rowKey < count($heightMap) - 1) && $heightMap[$rowKey + 1][$positionKey] <= $positionHeight) {
            // Check down
            continue;
        }
        $lowPoints[] = [$positionKey, $rowKey];
    }
}

/**
 * Given a set of coordinates, find the surrounding basin.
 * Move around 1 square at a time 9 (from an initial low point)
 * and find whether it's a 9. If not, add to the visited list
 * and add 1 to our size.
 *
 * @param int $x
 * @param int $y
 * @return int
 */
function findBasin(int $x, int $y): int
{
    global $MAX_HEIGHT, $heightMap, $visitedPoints;
    $currentPosition = [$x, $y];
    $basinSize = 1;

    if (in_array($currentPosition, $visitedPoints)) {
        return 0;
    }
    $visitedPoints[] = $currentPosition;

    if ($x > 0 && $heightMap[$y][$x - 1] < $MAX_HEIGHT) {
        // Check left
        $basinSize+= findBasin($x - 1, $y);
    }
    if (($x < count($heightMap[$y]) - 1) && $heightMap[$y][$x + 1] < $MAX_HEIGHT) {
        // Check right
        $basinSize += findBasin($x + 1, $y);
    }
    if (($y > 0) && $heightMap[$y - 1][$x] < $MAX_HEIGHT) {
        // Check up
        $basinSize += findBasin($x, $y - 1);
    }
    if (($y < count($heightMap) - 1) && $heightMap[$y + 1][$x] < $MAX_HEIGHT) {
        // Check down
        $basinSize += findBasin($x, $y + 1);
    }
    return $basinSize;
}

/*
 * Fins the largest basins
 */
foreach ($lowPoints as $lowPoint) {
    $basins[] = findBasin($lowPoint[0], $lowPoint[1]);
}
rsort($basins);

echo $basins[0] * $basins[1] * $basins[2];
