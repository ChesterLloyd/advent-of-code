<?php
$sonarReadings = fopen('input.txt', 'r') or die('Unable to open input file!');
$previousReading = null;
$increasedReadings = 0;

// Go through each input and find those that have increased

while (!feof($sonarReadings)) {
    $currentReading = fgets($sonarReadings);

    if ($previousReading && $currentReading > $previousReading) {
        $increasedReadings++;
    }

    $previousReading = $currentReading;
}

fclose($sonarReadings);

echo $increasedReadings;
