<?php
require_once 'Log.php';
require_once 'Output.php';
require_once 'Database.php';

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

    public function verify($id, $password)
    {
        $sql    = "SELECT * FROM playersData WHERE ((`emailId` = '$id') or (`playerId` = '$id'))";
        $result = $this->conn->query($sql);
        if (!$result) {
            Log::e($this, "verify: database exception".mysqli_error($this->conn));
            $this->output->error("database exception");
        }
        $data =$result->fetch_assoc();
        
        $hash = $data['password'];

        if (password_verify($password, $hash)) {
            return $data['playerId'];
        }
        return false;
    }


    public function getHashFor($data)
    {
        $hash = password_hash($data, CRYPT_BLOWFISH);
        return $hash;
    }

}
