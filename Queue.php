<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Log.php';
require_once 'Output.php';

class Queue
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();
    }

    public function addPlayer($playerId)
    {
        $sql    = "INSERT INTO queue (playerId) VALUES ('$playerId')";
        $result = $this->conn->query($sql);
        if (!$result) {
            Log::e($this, (__FUNCTION__) . ": " . mysqli_error($this->conn));
            return;
        } else {
            Log::i($this, (__FUNCTION__) . ": " . $playerId . " added to queue");
        }
    }

    public function getPlayers()
    {
        $sql    = "SELECT playerId FROM queue LIMIT 2";
        $result = $this->conn->query($sql);
        if (!$result) {
            Log::e($this, (__FUNCTION__) . ": " . mysqli_error($this->conn));
            return;
        } else {
            Log::i($this, (__FUNCTION__) . ": " . " added to queue");
        }

        $players = array();
        $row1    = $result->fetch_assoc();
        $row2    = $result->fetch_assoc();
        if ($row1 === null || $row2 === null) {
            return null;
        }
        $players[] = $row1['playerId'];
        $players[] = $row2['playerId'];
        return $players[];

    }

}
