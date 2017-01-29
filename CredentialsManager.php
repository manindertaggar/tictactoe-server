<?php

class CredentialsManager
{
    private $conn;
    private $output;

    public function __construct($conn)
    {
        $this->conn   = $conn;
        $this->output = new Output();
    }


    /*
	id = userId or emailId
	returns userId if verified else false
    */

    public function verify($id, $token)
    {
        $sql    = "SELECT * FROM playersData WHERE ((`emailId` = '$emailId') or (`userId` = '$userId'))";
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
    }


    // private function getHashFor($data)
    // {
    //     $hash = password_hash($data, CRYPT_BLOWFISH);
    //     return $hash;
    // }

}
