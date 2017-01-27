<?php
class CredentialVerifier
{
	private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function verify($playerId, $token)
    {
        return true;
    }
}
