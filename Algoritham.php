<?php
require_once 'Database.php';

class Algoritham
{
    private $winningConditions;
    private $algosCount;

    public function __constructor()
    {
        $this->$winningConditions = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [1, 4, 7],
            [0, 3, 6],
            [0, 4, 8],
            [2, 4, 6],
            [2, 5, 8]];

        $this->algosCount = count($this->winningConditions);
    }

    public function decideFor($gameId)
    {

        $players = $this->getPlayersFor($gameId);
        $cross   = $players[0];
        $zero    = $players[1];

        $won = true;
        for ($k = 0; $k < 2; $k++) {
            $testingItem = ($k == 0 ? $cross : $zero);
            for ($i = 0; $i < $this->algosCount; $i++, $won = true) {
                for ($j = 0; $j < 3; $j++) {
                    if ($itemsArray[$winningConditions[$i][$j]] === "null") {
                        $won = false;
                        break;
                    }
                    $won = ($won and ($testingItem === $itemsArray[$winningConditions[$i][$j]]));
                }
                if ($won) {
                    return $testingItem;
                }
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

    private function getPlayersFor($gameId)
    {
        $players;
    }
}
