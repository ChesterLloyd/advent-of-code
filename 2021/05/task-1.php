<?php
$coordinatesFile = fopen('input.txt', 'r') or die('Unable to open input file!');

// Go through each line and find total dangerous points
$coordinates = [];
$lineCoordinates = [];

/**
 * Add all coordinates to an array
 */
while (!feof($coordinatesFile)) {
    $currentCoordinates = explode(' ', fgets($coordinatesFile));

    // Remove new lines from coordinate
    $currentCoordinates[count($currentCoordinates) - 1] = str_replace(PHP_EOL, '', $currentCoordinates[count($currentCoordinates) - 1]);

    // Remove '->' in array as this is how the data is formatted
    $currentCoordinates = array_diff($currentCoordinates, ['->']);

    // Get coordinate numbers
    $x1 = explode(',',$currentCoordinates[0])[0];
    $y1 = explode(',',$currentCoordinates[0])[1];
    $x2 = explode(',',$currentCoordinates[2])[0];
    $y2 = explode(',',$currentCoordinates[2])[1];

    if ($x1 === $x2) {
        // This is a vertical line
        while ($y1 != $y2) {
            $lineCoordinates["$x1,$y1"] = array_key_exists("$x1,$y1", $lineCoordinates) ? ++$lineCoordinates["$x1,$y1"]: 1;
            $y1 = $y1 > $y2 ? --$y1 : ++$y1;
        }
        $lineCoordinates["$x1,$y1"] = array_key_exists("$x1,$y1", $lineCoordinates) ? ++$lineCoordinates["$x1,$y1"] : 1;

    } else if ($y1 === $y2) {
        // This is a horizontal line
        while ($x1 != $x2) {
            $lineCoordinates["$x1,$y1"] = array_key_exists("$x1,$y1", $lineCoordinates) ? ++$lineCoordinates["$x1,$y1"] : 1;
            $x1 = $x1 > $x2 ? --$x1 : ++$x1;
        }
        $lineCoordinates["$x1,$y1"] = array_key_exists("$x1,$y1", $lineCoordinates) ? ++$lineCoordinates["$x1,$y1"] : 1;
    }
}

// Find coordinates with 2 or more intersections
$lineCoordinates = array_filter($lineCoordinates, function($value) {
    return $value >= 2;
});

echo count($lineCoordinates);

fclose($coordinatesFile);
