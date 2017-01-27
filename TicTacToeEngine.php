<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'CredentialVerifier.php';
require 'Output.php';
require 'Mover.php';
require 'Database.php';

class TicTacToeEngine
{
    private $credentialVerifier;
    private $output;
    private $mover;
    private $conn;

    public function __construct()
    {
        $this->output             = new Output();
        $this->conn               = new Database()->getConnection();
        $this->credentialVerifier = new CredentialVerifier($this->conn);
        $this->mover              = new Mover($this->conn);
    }

    public function onpacketReceived($packet)
    {
        if (!$this->isPacketValid($packet)) {
            $this->output->error("invalid packet");
            return;
        }

        $type     = $packet["type"];
        $payload  = $packet["payload"];
        $playerId = $packet["player"]["playerId"];
        switch ($type) {
            case "makeMove":
                $this->makeMove($playerId, $payload);
                break;
            case "endGame":
                $this->endGame($playerId, $payload);
                break;
            case "requestGame":
                $this->requestGame($playerId, $payload);
                break;
            case "updateProfile":
                $this->updateProfile($playerId, $payload);
                break;
            default:
                $this->output->error("undefined packet type");
                break;
        }
    }

    private function makeMove($playerId, $payload)
    {
        $this->mover->makeMove($playerId, $payload);
    }

    private function endGame($playerId, $payload)
    {

    }

    private function requestGame($playerId, $payload)
    {

    }

    private function updateProfile($playerId, $payload)
    {

    }

    private function isPacketValid($packet)
    {
        if ($packet === null || $packet === '') {
            $this->output->error("empty or invalid packet recieved");
            return false;
        }

        if (!array_key_exists('type', $packet)) {
            $this->output->error("\'type\'' index not found in packet");
            return false;
        }

        if (!array_key_exists('player', $packet)) {
            $this->output->error("user not found in packet");
            return false;
        }

        $player = $packet['player'];

        if (!(array_key_exists('playerId', $player) && array_key_exists('token', $player))) {
            $this->output->error("user credentials not found in packet");
            return false;
        }

        $playerId    = $player['playerId'];
        $token       = $player['token'];
        $isValidUser = $this->credentialVerifier->verify($playerId, $token);

        if (!$isValidUser) {
            $this->output->error("user details donot match");
        }

        return $isValidUser;

    }

}
