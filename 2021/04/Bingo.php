<?php

class Bingo
{
    private array $cards = [];
    private array $solvedCards = [];

    function __construct() {
        $bingo = fopen('input.txt', 'r') or die('Unable to open input file!');
        $numbers = explode(',', fgets($bingo));
        $this->cards = $this->setupCards($bingo);
        fclose($bingo);

        foreach ($numbers as $number) {
            $this->cards = $this->callNumber($number, $this->cards);
        }
    }


    /**
     * Look at the input file and generate the appropriate number
     * of bingo cards. This is an array withing the cards array.
     *
     * @param $bingo
     * @return array
     */
    private function setupCards($bingo): array
    {
        $cards = [];
        $card = [];

        // Loop through each bingo line
        while (!feof($bingo)) {
            // Break at spaces to get numbers as their own items
            $bingoLine = explode(' ', fgets($bingo));

            // Remove new lines from numbers
            $bingoLine[count($bingoLine) - 1] = str_replace(PHP_EOL, '', $bingoLine[count($bingoLine) - 1]);

            // Remove spaces in array as some numbers can be '  8'
            $bingoLine = array_diff($bingoLine, ['']);

            // This is a space between cards, save this card and make a new one
            if (count($bingoLine) === 0) {
                if (count($card) > 0) {
                    $cards[] = $card;
                }
                $card = [];
            } else {
                // Add this line of numbers to the bingo card (resetting keys)
                $card[] = array_values($bingoLine);
            }
        }

        // This is the last card, save it
        $cards[] = $card;

        return $cards;
    }


    /**
     * Replace all occurrences of the called number in the cards with
     * a '*'.
     *
     * We will also check if there is a complete row or column.
     *
     * @param $number
     * @param $cards
     * @return array
     */
    private function callNumber($number, $cards): array
    {
        foreach ($cards as $cardIndex => &$card) {
            foreach ($card as &$cardLine) {
                foreach ($cardLine as &$cardNumber) {
                    // Number matches the one called, replace it
                    if ($cardNumber == $number) {
                        $cardNumber = '*';
                    }
                }
            }

            foreach ($card as &$cardLine) {
                // If all values ar the same, a '*', then the card has a complete row
                if (count(array_flip($cardLine)) === 1 && end($cardLine) === '*') {
                    $this->calculateScore($number, $card, $cardIndex);
                }
            }

            // Now check vertically for a bingo
            for ($col = 0; $col < count($card[0]); $col++) {
                $cardCol = [];

                for ($col2 = 0; $col2 < count($card[0]); $col2++) {
                    $cardCol[] = $card[$col2][$col];
                }

                // If all values ar the same, a '*', then the card has a complete row
                if (count(array_flip($cardCol)) === 1 && end($cardCol) === '*') {
                    $this->calculateScore($number, $card, $cardIndex);
                }
            }
        }

        return $cards;
    }


    /**
     * Calculate final score by finding total of unmarked numbers
     * and multiplying by the number completing the line o column.
     *
     * End the program here.
     *
     * @param $number
     * @param $card
     * @param $cardIndex
     * @return void
     */
    private function calculateScore($number, $card, $cardIndex)
    {
        // Remove card from array as it's done
        if (!in_array($cardIndex, $this->solvedCards)) {
            $this->solvedCards[] = $cardIndex;
        }

        // Last card, we want this score
        if (count($this->solvedCards) == count($this->cards)) {
            // Find sum of all unmarked numbers
            $total = 0;

            foreach ($card as $cardLine) {
                foreach ($cardLine as $cardLineNumber) {
                    $total += $cardLineNumber == '*' ? 0 : $cardLineNumber;
                }
            }

            // Return final score
            echo $total * $number;
            die ();
        }
    }
}
