<?php
$lanternFishFile = fopen('input.txt', 'r') or die('Unable to open input file!');
$lanternFish = explode(',', fgets($lanternFishFile));
fclose($lanternFishFile);

$MAX_AGE = 8;
$RESET_AGE = 6;
$DAYS = 80;

for ($day = 0; $day < $DAYS; $day++) {
    foreach ($lanternFish as &$age) {
        --$age;
        if ($age == -1) {
            $age = $RESET_AGE;
            $lanternFish[] = $MAX_AGE + 1;
        }
    }
}

echo count($lanternFish);
