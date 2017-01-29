<?php

class CredentialVerifier
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();
    }

    public function verify($playerId, $token)
    {

//        return true;
    }

    // private function getHashFor($data)
    // {
    //     $hash = password_hash($data, CRYPT_BLOWFISH);
    //     return $hash;
    // }

    private function verifyCredentils($emailId, $password)
    {

        $sql    = "SELECT * FROM playersData WHERE `emailId` = '$emailId'";
        $result = $this->conn->query($sql)->fetch_assoc();
        if (!$result) {
            Log::e($this, "verifyCredentils: database exception".mysqli_error($this->conn));
            return false;
        }
        $hash = $result['password'];

        if (password_verify($password, $hash)) {
            return $result['playerId'];
        }
        return false;
    }}
