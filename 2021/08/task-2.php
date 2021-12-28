<?php
$entriesFile = fopen('input.txt', 'r') or die('Unable to open input file!');

$outputTotal = 0;

/**
 * Go through each entry and add to the total
 */
while (!feof($entriesFile)) {
    $currentEntry = explode(' | ', fgets($entriesFile));
    $input = explode(' ', $currentEntry[0]);
    $output = explode(' ', $currentEntry[1]);

    // Remove new line character from last output value
    $output[count($output) - 1] = str_replace(PHP_EOL, '', $output[count($output) - 1]);

    $numbers = [
        0 => [],
        1 => [],
        2 => [],
        3 => [],
        4 => [],
        5 => [],
        6 => [],
        7 => [],
        8 => [],
        9 => [],
    ];

    $unknown = [];

    /*
     * Find the easy numbers (1, 4, 7 and 8) in the input
     */
    foreach ($input as $inputNumber) {
        if (strlen($inputNumber) == 2) {
            $numbers[1] = str_split($inputNumber);
        } elseif (strlen($inputNumber) == 3) {
            $numbers[7] = str_split($inputNumber);
        } elseif (strlen($inputNumber) == 4) {
            $numbers[4] = str_split($inputNumber);
        } elseif (strlen($inputNumber) == 7) {
            $numbers[8] = str_split($inputNumber);
        } else {
            $unknown[] = str_split($inputNumber);
        }
    }

    /*
     * Find the remaining numbers
     */
    foreach ($unknown as $unknownInput) {
        if (count($unknownInput) == 5 && inputContainsSegments($unknownInput, $numbers[1])) {
            // 3 -> 5 segments and contains a 1
            $numbers[3] = $unknownInput;
        } elseif (count($unknownInput) == 6 && inputContainsSegments($unknownInput, array_diff($numbers[8], $numbers[7]))) {
            // 6 -> 6 segments and contains 7 - 8
            $numbers[6] = $unknownInput;
        } elseif (count($unknownInput) == 5 && count(array_diff(array_diff($unknownInput, $numbers[7]), $numbers[4])) == 1) {
            // 5 -> 5 segments and (5?) - 7 leaves part of 4
            $numbers[5] = $unknownInput;
        } elseif (count($unknownInput) == 5) {
            // 2 -> 5 segments and does not match above
            $numbers[2] = $unknownInput;
        }
    }

    /*
     * Make a zero and nine from the above
     */
    if (!$numbers[0]) {
        $segmentsDAndG = array_diff($numbers[3], $numbers[7]);
        $segmentG = array_diff($segmentsDAndG, $numbers[4]);
        $segmentD = array_diff($segmentsDAndG, $segmentG);
        $numbers[0] = array_diff($numbers[8], $segmentD);
    }

    if (!$numbers[9]) {
        $segmentE = array_diff($numbers[2], $numbers[3]);
        $numbers[9] = array_diff($numbers[8], $segmentE);
    }

    /*
     * Find the output numbers
     */
    $outputNumberString = '';
    foreach ($output as $outputNumber) {
        $outputNumber = str_split($outputNumber);

        foreach ($numbers as $number => $segments) {
            if ((count($outputNumber) == count($segments)) && count(array_diff($outputNumber, $segments)) == 0) {
                $outputNumberString .= $number;
            }
        }
    }
    $outputTotal += (int)$outputNumberString;
}


/**
 * Take an input and array of segments and return whether
 * the inout contains all the segments.
 *
 * @param $input
 * @param $segments
 * @return bool
 */
function inputContainsSegments($input, $segments): bool
{
    foreach ($segments as $segment) {
        if (!in_array($segment, $input)) {
            return false;
        }
    }
    return true;
}

fclose($entriesFile);

echo $outputTotal;
