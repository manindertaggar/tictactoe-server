<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Log.php';
require_once 'Output.php';
require_once 'Database.php';
require_once 'Algoritham.php';
require_once 'Queue.php';

class GamePlanner
{
    private $conn;
    private $output;
    private $queue;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();
        $this->queue = new Queue($this->conn);
    }

    public function update($gameId)
    {

    }

    public function requestGame($playerId)
    {
        $this->queue->addPlayer($playerId);


        // $sql    = "INSERT INTO moves (move,playerId,gameId) VALUES ('$move','$playerId','$gameId')";
        // $result = $this->conn->query($sql);
        // if (!$result) {
        //     Log::e($this,(__FUNCTION__).": ". mysqli_error($this->conn));
        //     $this->output->error("access verification failed. Database Error");
        // }


    }

    public function requestGameWith($player1Id, $player2Id)
    {

    }

    public function surrender($playerId, $gameId)
    {

    }

}
