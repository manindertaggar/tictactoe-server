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

    public function getPlayerFor($emailId, $token)
    {
        $accountExists = $this->checkIfPlayerExists($emailId);
        if(!$accountExists){
            $this->output->error("Account doesnot exist");
        }
    }

    public function updatePlayer($playerId, $payload)
    {

    }

    public function checkIfPlayerExists($emailId)
    {
        return true;
    }

}
