<?php
require_once 'Log.php';
require_once 'Output.php';
require_once 'Database.php';

class GamePlanner
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();

    }

    public function update($gameId)
    {

    }

    public function requestGame($playerId)
    {

    }

    public function requestGameWith($player1Id, $player2Id)
    {

    }

    public function surrender($playerId, $gameId)
    {

    }

}
