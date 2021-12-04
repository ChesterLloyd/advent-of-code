<?php
$sonarReadings = fopen('input.txt', 'r') or die('Unable to open input file!');
$hasRunOnce = false;
$previousReading = null;
$previousReadingWindow = [];
$increasedReadings = 0;

// Go through each input and find those that have increased in sets of 3

while (!feof($sonarReadings)) {
    $currentReading = fgets($sonarReadings);
    $previousReadingWindow[] = $currentReading;

    // Make sure there are 3 readings in the sliding window
    if (count($previousReadingWindow) < 3) {
        continue;
    } elseif (count($previousReadingWindow) === 3) {
        $currentReadingTotal = $previousReadingWindow[0] + $previousReadingWindow[1] + $previousReadingWindow[2];

        // Has run before so compare
        if ($previousReading && $currentReadingTotal > $previousReading) {
            $increasedReadings++;
        }

        $previousReading = $currentReadingTotal;

        // Remove first item - shift the window
        array_shift($previousReadingWindow);
    }
}

fclose($sonarReadings);

echo $increasedReadings;
