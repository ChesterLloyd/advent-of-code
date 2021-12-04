<?php
$directions = fopen('input.txt', 'r') or die('Unable to open input file!');

// Directions
const FORWARD = 'forward ';
const UP = 'up ';
const DOWN = 'down ';

$horizontal = 0;
$vertical = 0;

// Go through each direction and find final horizontal position * final depth

while (!feof($directions)) {
    $currentDirection = fgets($directions);

    if (str_starts_with($currentDirection, FORWARD)) {
        // Going forward
        $horizontal += str_replace(FORWARD, '',$currentDirection);
    } elseif (str_starts_with($currentDirection, UP)) {
        // Going up
        $vertical -= str_replace(UP, '',$currentDirection);
    } elseif (str_starts_with($currentDirection, DOWN)) {
        // Going down
        $vertical += str_replace(DOWN, '',$currentDirection);
    }
}

fclose($directions);

echo $horizontal * $vertical;
