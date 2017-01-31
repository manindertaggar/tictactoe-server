<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'CredentialsManager.php';
require_once 'Log.php';
require_once 'Output.php';
require_once 'Mover.php';
require_once 'Database.php';
require_once 'GamePlanner.php';

class TicTacToeEngine
{
    private $output;
    private $conn;
    private $credentialsManager;
    private $mover;
    private $gamePlanner;

    public function __construct()
    {
        $this->output             = new Output();
        $this->conn               = (new Database())->getConnection();
       
        $this->credentialsManager = new CredentialsManager($this->conn);
        $this->mover              = new Mover($this->conn);
        $this->gamePlanner        = new GamePlanner($this->conn);
    }

    public function onpacketReceived($packet)
    {
        Log::i($this,"onpacketReceived ". json_encode($packet));
        
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
            case "requestGameWithFriend":
                $this->requestGameWithFriend($playerId, $payload);
                break;
            default:
                $this->output->error("undefined packet type");
                break;
        }
    }

    private function makeMove($playerId, $payload)
    {
        $this->mover->makeMove($playerId, $payload);
        $gameId = $payload['gameId'];
        $this->gamePlanner->update($gameId);
    }

    private function endGame($playerId, $payload)
    {
        $gameId = $payload['gameId'];
        $this->gamePlanner->surrender($playerId, $gameId);
    }

    private function requestGame($playerId, $payload)
    {
        $this->gamePlaner->requestGame($playerId);
    }
    private function requestGameWith($playerId, $payload)
    {
        $otherPlayerId = $payload["otherPlayerId"];
        $this->gamePlaner->requestGameWith($playerId, $otherPlayerId);
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

        $playerId = $player['playerId'];
        $token    = $player['token'];

        $isValidUser = $this->credentialsManager->verifyToken($playerId, $token);
        if (!$isValidUser) {
            $this->output->error("user details donot match");
        }
        return $isValidUser;

        return true;
    }

}
