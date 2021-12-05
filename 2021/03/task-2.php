<?php
$diagnostics = file('input.txt', FILE_IGNORE_NEW_LINES);

$oxygenGeneratorRating = bindec(implode('', findMostPopularBits($diagnostics)));
$co2ScrubberRating = bindec(implode('', findMostPopularBits($diagnostics, 0)));

echo $oxygenGeneratorRating * $co2ScrubberRating;

/**
 * Loop through each line in the diagnostics file.
 *
 * For each of these lines, go through each bit position and
 * return the diagnostic lines where there are more matches
 * (or fewer if the important bit is zero).
 *
 * Repeat until there is one result left in the array.
 *
 * @param array $diagnostics
 * @param int $importantBit
 * @param int $bitPosition
 * @return array
 */
function findMostPopularBits(array $diagnostics, int $importantBit = 1, int $bitPosition = 0): array {
    $lineCount = 0;
    $oneValues = [];
    $zeroValues = [];

    // Loop through each diagnostic line
    foreach ($diagnostics as $diagnostic) {
        $lineCount++;
        $numberOfBits = count(str_split($diagnostic)) - 1;

        // Return if we have looked at all bits
        if ($bitPosition > $numberOfBits) {
            return $diagnostics;
        }

        $bitValueAtPosition = substr($diagnostic, $bitPosition, 1);

        // Split the values into 2 arrays for those with 1 or 0 at selected position
        if ($bitValueAtPosition == 1) {
            $oneValues[] = $diagnostic;
        } else {
            $zeroValues[] = $diagnostic;
        }
    }

    // Return if last item in array
    if ($lineCount == 1) {
        return $diagnostics;
    }

    // Update diagnostics array to only contain the most popular bit
    if (count($oneValues) === count($zeroValues)) {
        // If there are equal ones and zeros at this position
        $diagnostics = $importantBit == 1 ? $oneValues : $zeroValues;
    } elseif (count($oneValues) > count($zeroValues)) {
        // If there are more ones at this position
        $diagnostics = $importantBit == 1 ? $oneValues : $zeroValues;
    } else {
        // If there are more zeros at this position
        $diagnostics = $importantBit == 1 ? $zeroValues : $oneValues;
    }

    return findMostPopularBits($diagnostics, $importantBit, ++$bitPosition);
}
