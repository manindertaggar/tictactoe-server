<?php
require 'config.php';

class Mover
{
	private $conn;

    public function __construct($conn)
    {	
    	$this->conn = $conn;
    }

    public function makeMove($playerId, $payload)
    {
        $this->verifyMovePayload($payload);

        $move   = $payload['move'];
        $gameId = $payload['gameId'];

        $this->verifyAccess($playerId, $gameId, $moveId);

    }

    private function verifyAccess($playerId, $gameId, $moveId)
    {
        $sql    = "SELECT player_id FROM $DB_TABLE WHERE id ='$game_id' ORDER BY i DESC LIMIT 1";
        $result = $this->conn->query($sql);
        $data   = $result->fetch_assoc();

        if ($data != null && $data['playerId'] === $playerId) {
            $output->show_error("its not your turn");
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
