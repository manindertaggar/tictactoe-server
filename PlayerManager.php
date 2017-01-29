<?php
class PlayerManager
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();

    }

    public function createPlayer($payload)
    {

    }

    public function updatePlayer($playerId, $payload)
    {

    }

    public function checkIfPlayerExists($playerId)
    {
        return false;
    }

}
