<?php
$diagnostics = fopen('input.txt', 'r') or die('Unable to open input file!');
$numberOfBits = count(str_split(fgets($diagnostics))) - 1;
$diagnosticTotals = array_fill(0, $numberOfBits, 0);
$epsilon = '';

// Go through each diagnostic and find most common bits

while (!feof($diagnostics)) {
    $currentDiagnostic = fgets($diagnostics);

    foreach (str_split($currentDiagnostic) as $bitPosition => $bitValue) {
        if ($bitPosition === $numberOfBits) {
            // THis is a space, ignore
            continue;
        }

        // Update total - add 1 for a 1, remove 1 for a 0
        $diagnosticTotals[$bitPosition] += ($bitValue == 0) ? -1 : 1;
    }
}

fclose($diagnostics);

// Convert totals to binary
foreach ($diagnosticTotals as $diagnosticPosition => $diagnosticBit) {
    // Gamma - positive values are a binary 1
    $binaryValue = $diagnosticBit > 0 ? 1 : 0;
    $diagnosticTotals[$diagnosticPosition] = $binaryValue;
    // Epsilon - positive values are a binary 0
    $epsilon .= $binaryValue == 1 ? 0 : 1;
}

// Convert to decimal
$gamma = bindec(implode('', $diagnosticTotals));
$epsilon = bindec($epsilon);

echo $gamma * $epsilon;
