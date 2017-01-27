<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'CredentialVerifier.php';
require 'Output.php';

class TicTacToeEngine
{
    private $credentialVerifier;
    private $output;

    public function __construct()
    {
        $this->credentialVerifier = new CredentialVerifier();
        $this->output             = new Output();
    }

    public function onpacketReceived($packet)
    {
        if (!$this->isPacketValid($packet)) {
            $this->output->error("invalid packet");
            return;
        }

        $type = $packet["type"];
        switch ($type) {
            case "makeMove":
                $this->makeMove($packet);
                break;
            case "endGame":
                $this->endGame($packet);
                break;
            case "requestGame":
                $this->requestGame($packet);
                break;
            case "updateProfile":
                $this->updateProfile($packet);
                break;
            default:
                $this->output->error("undefined packet type");
                break;
        }
    }

    private function makeMove($packet)
    {

    }

    private function endGame($packet)
    {

    }

    private function requestGame($packet)
    {

    }

    private function updateProfile($packet)
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

        if (!(array_key_exists('playerId', $packet) && array_key_exists('token', $packet))) {
            $this->output->error("user credentials not found in packet");
            return false;
        }

        $playerId      = $packet['playerId'];
        $token       = $packet['token'];
        $isValidUser = $this->credentialVerifier->verify($playerId, $token);

        if (!$isValidUser) {
            $this->output->error("user details donot match");
        }

        return $isValidUser;

    }

}
