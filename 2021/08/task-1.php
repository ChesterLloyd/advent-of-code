<?php
$entriesFile = fopen('input.txt', 'r') or die('Unable to open input file!');

$NUMBERS = [
    0 => [],
    1 => ['c', 'f'],
    2 => ['a', 'c', 'd', 'e', 'g'],
    3 => ['a', 'c', 'd', 'f', 'g'],
    4 => ['b', 'c', 'd', 'f'],
    5 => ['a', 'b', 'd', 'f', 'g'],
    6 => ['a', 'b', 'd', 'e', 'f', 'g'],
    7 => ['a', 'c', 'f'],
    8 => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
    9 => ['a', 'b', 'c', 'd', 'f', 'g'],
];

$occurrences1478 = 0;

/**
 * Go through each entry and find number of 1, 4, 7 and 8 in the output
 */
while (!feof($entriesFile)) {
    $currentEntry = explode(' | ', fgets($entriesFile));
    $input = explode(' ', $currentEntry[0]);
    $output = explode(' ', $currentEntry[1]);

    // Remove new line character from last output value
    $output[count($output) - 1] = str_replace(PHP_EOL, '', $output[count($output) - 1]);

    $occurrences1478 += count(
        array_filter($output, function ($value) use ($NUMBERS) {
            return in_array(strlen($value), [
                count($NUMBERS[1]), count($NUMBERS[4]), count($NUMBERS[7]), count($NUMBERS[8]),
            ]);
        })
    );
}

fclose($entriesFile);

echo $occurrences1478;
