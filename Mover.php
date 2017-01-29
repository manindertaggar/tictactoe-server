<?php

class Mover
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->output = new Output();
    }

    public function makeMove($playerId, $payload)
    {
        $this->verifyMovePayload($payload);

        $move   = $payload['move'];
        $gameId = $payload['gameId'];

        $this->verifyAccess($playerId, $gameId, $move);

        //everything is fine, lets make move now

        $sql    = "INSERT INTO moves (move,playerId,gameId) VALUES ('$move','$playerId','$gameId')";
        $result = $this->conn->query($sql);

    }

    private function verifyAccess($playerId, $gameId, $move)
    {
        $this->isGameInProgress($gameId);
        $this->checkIfSameMoveHasBeenMade($gameId, $move);
        $this->doesPlayerHaveHisTurn($playerId, $gameId);
    }

    private function checkIfSameMoveHasBeenMade($gameId, $move)
    {

        $sql    = "SELECT * FROM moves WHERE gameId ='$gameId' and move = '$move'";
        $result = $this->conn->query($sql);
        if (!$result) {
            $this->output->error("access verification failed. Database Error");
        }

        $data = $result->fetch_assoc();
        if ($data != null) {
            $this->output->error("invalid move, move has been already made." . $gameId);
        }

    }

    private function doesPlayerHaveHisTurn($playerId, $gameId)
    {
        $sql    = "SELECT playerId FROM playerGame WHERE gameId ='$game_id' ORDER BY id DESC LIMIT 1";
        $result = $this->conn->query($sql);
        if (!$result) {
            $this->output->error("access verification failed. Database Error");
        }

        $data = $result->fetch_assoc();
        if ($data === null) {
            $this->output->error("access verification failed, no game found with id " . $gameId);
        }

        if ($data['player_id'] === $player_id) {
            $this->output->error("$playerId doesnot have its turn");
        }
    }

    private function isGameInProgress($gameId)
    {
        $sql    = "SELECT status FROM games WHERE gameId ='$gameId'";
        $result = $this->conn->query($sql);
        if (!$result) {
            $this->output->error("access verification failed. Database Error");
        }

        $data = $result->fetch_assoc();
        if ($data === null) {
            $this->output->error("access verification failed, no game found with id " . $gameId);
        }

        if ($data['status'] !== "inProgess") {
            $this->output->error("access verification failed, game has been already completed");
        }
    }

    private function verifyMovePayload($payload)
    {
        if ($payload === null) {
            $this->output->error("move payload is null");
            return false;
        }

        if (!array_key_exists('move', $payload)) {
            $this->output->error("move not found in payload");
            return false;
        }

        if (!array_key_exists('gameId', $payload)) {
            $this->output->error("gameId not found in payload");
            return false;
        }

        $move = $payload['move'];
        if (!($move >= 0 && $move < 9)) {
            $this->output->error("invalid move location");
            return false;
        }

        return true;
    }

}
