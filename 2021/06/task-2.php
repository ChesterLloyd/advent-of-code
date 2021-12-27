<?php
$lanternFishFile = fopen('input.txt', 'r') or die('Unable to open input file!');
$lanternFish = explode(',', fgets($lanternFishFile));
fclose($lanternFishFile);

$DAYS = 256;

$fishAges = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
];

// Set up initial state
foreach ($lanternFish as $fish) {
    $fishAges[$fish] += 1;
}

// Spawn some lanternfish
for ($day = 0; $day < $DAYS; $day++) {
    $fishAges = [
        8 => $fishAges[0],
        7 => $fishAges[8],
        6 => $fishAges[7] + $fishAges[0],
        5 => $fishAges[6],
        4 => $fishAges[5],
        3 => $fishAges[4],
        2 => $fishAges[3],
        1 => $fishAges[2],
        0 => $fishAges[1],
    ];
}

// Count total fish
$fishTotal = 0;
foreach ($fishAges as $fish) {
    $fishTotal += $fish;
}
echo $fishTotal;
