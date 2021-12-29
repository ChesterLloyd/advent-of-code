<?php
$heightMapFile = fopen('input.txt', 'r') or die('Unable to open input file!');

$heightMap = [];

/*
 * Build the heightmap
 */
while (!feof($heightMapFile)) {
    $heightMap[] = str_split(str_replace(PHP_EOL, '', fgets($heightMapFile)));
}
fclose($heightMapFile);

$lowPoints = [];

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
        $lowPoints[] = $positionHeight + 1;
    }
}

echo array_sum($lowPoints);
