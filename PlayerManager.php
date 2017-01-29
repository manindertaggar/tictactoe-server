<?php
require_once 'CredentialsManager.php';
require_once 'Log.php';
require_once 'Output.php';

class PlayerManager
{
    private $conn;
    private $output;
    private $credentialsManager;

    public function __construct($conn)
    {
        $this->conn               = $conn;
        $this->output             = new Output();
        $this->credentialsManager = new CredentialsManager($this->conn);
    }

    public function createPlayer($payload)
    {

    }

    public function getPlayerFor($emailId, $token)
    {
        $accountExists = $this->checkIfPlayerExists($emailId);
        if (!$accountExists) {
            $this->output->error("Account doesnot exist");
        }

        $isVerified = ($this->credentialsManager->verify($emailId, $token));
        if (!$isVerified) {
            $this->output->error("Invalid Credentials");

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
