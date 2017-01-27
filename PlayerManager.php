<?php
class PlayerManager
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
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
