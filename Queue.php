<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Log.php';

class Queue
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addPlayer($playerId)
    {
        $sql    = "INSERT INTO queue (playerId) VALUES ('$playerId')";
        $result = $this->conn->query($sql);
        if (!$result) {
            Log::e($this, (__FUNCTION__) . ": " . mysqli_error($this->conn));
            $this->output->error("access verification failed. Database Error");
        } else {
            Log::i($this, (__FUNCTION__) . ": " . $playerId . " added to queue");
        }
    }

    public function getPlayer()
    {
        $sql    = "SELECT playerId FROM queue LIMIT 1";
        $result = $this->conn->query($sql);
        if (!$result) {
            Log::e($this, (__FUNCTION__) . ": " . mysqli_error($this->conn));
            $this->output->error("access verification failed. Database Error");
        } else {
            Log::i($this, (__FUNCTION__) . ": " . $playerId . " added to queue");
        }
        $playerId = $result['playerId'];
        return $playerId;
    }

}
