<?php
$directions = fopen('input.txt', 'r') or die('Unable to open input file!');

// Directions
const FORWARD = 'forward ';
const UP = 'up ';
const DOWN = 'down ';

$horizontal = 0;
$vertical = 0;
$aim = 0;

// Go through each direction and find final horizontal position * final depth with aim

while (!feof($directions)) {
    $currentDirection = fgets($directions);

    if (str_starts_with($currentDirection, FORWARD)) {
        // Going forward
        $distance = str_replace(FORWARD, '', $currentDirection);
        $horizontal += $distance;
        $vertical += $aim * $distance;
    } elseif (str_starts_with($currentDirection, UP)) {
        // Going up
        $aim -= str_replace(UP, '',$currentDirection);
    } elseif (str_starts_with($currentDirection, DOWN)) {
        // Going down
        $aim += str_replace(DOWN, '', $currentDirection);
    }
}

fclose($directions);

echo $horizontal * $vertical;
