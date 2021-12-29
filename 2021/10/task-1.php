<?php
$codeFile = fopen('input.txt', 'r') or die('Unable to open input file!');

$BRACKETS = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>'
];
$POINTS = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$code = [];
$score = 0;

/*
 * Build the code array
 */
while (!feof($codeFile)) {
    $code[] = str_split(str_replace(PHP_EOL, '', fgets($codeFile)));
}
fclose($codeFile);

/**
 * Given a line of code, check to see if closing brackets match
 * up wih the opening ones.
 *
 * @param array $line
 * @param int $position
 * @param array $expecting
 * @return int
 */
function checkBrackets(array $line, int $position = 0, array $expecting = []): int
{
    global $BRACKETS, $POINTS;

    if ($position == count($line)) {
        return 0;
    }
    $currentCharacter = $line[$position];

    if (in_array($currentCharacter, array_keys($BRACKETS))) {
        // If it is an opening bracket, look for it to close
        $expecting[] = $BRACKETS[$currentCharacter];
        $currentScore = checkBrackets($line, $position + 1, $expecting);
    } else {
        // This should be a closing bracket
        if ($currentCharacter == $expecting[count($expecting) - 1]) {
            array_pop($expecting);
            $currentScore = checkBrackets($line, $position + 1, $expecting);
        } else {
            // Syntax error!
            $currentScore = $POINTS[$currentCharacter];
        }
    }
    return $currentScore;
}

/*
 * Go through each line and detect syntax errors
 */
foreach ($code as $line) {
    $score += checkBrackets($line);
}

echo $score;
