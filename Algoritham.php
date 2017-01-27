<?php

class Algorithm
{
 
    function __construct($player1Id, $player2Id)
    {
    }

    public function whoWon($player1Id, $player2Id,$itemsArray)
    {
        $cross = $this->cross;
        $zero = $this->zero;

        $winningConditions = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [1, 4, 7],
            [0, 3, 6],
            [0, 4, 8],
            [2, 4, 6],
            [2, 5, 8]];

        $algosCount = count($winningConditions);
        $won = true;

        for ($k = 0; $k < 2; $k++) {
            $testingItem = ($k == 0 ? $cross : $zero);

            for ($i = 0; $i < $algosCount; $i++, $won = true) {
                for ($j = 0; $j < 3; $j++) {
                    if ($itemsArray[$winningConditions[$i][$j]] === "null") {
                        $won = false;
                        break;
                    }

                    $won = ($won and ($testingItem === $itemsArray[$winningConditions[$i][$j]]));
                }

                if ($won)
                    return $testingItem;
            }
        }

        $allMovesAreDone = true;
       
        for ($k = 0; $k < 9; $k++) {
            if ($itemsArray[$k] === "null") {
                $allMovesAreDone = false;
                break;
            }
        }

        if ($allMovesAreDone) {
            return "draw";
        } else {
            return "null";
        }
    }
}

