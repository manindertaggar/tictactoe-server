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

        /*
        private String name, age, avatarUrl, token, emailId;
        private List<Acheivement> acheivements;
        private int numberOfGamesPlayed;
        private long rank;
        private double winPercentage;
        private String playerId;
         */
        if (!array_key_exists('name', $payload) ||
            !array_key_exists('age', $payload) ||
            !array_key_exists('avatarUrl', $payload) ||
            !array_key_exists('password', $payload) ||
            !array_key_exists('emailId', $payload)) {
            $this->output->error("invalid arguments");
        }

        $emailId = $payload['emailId'];

        $accountExists = $this->checkIfPlayerExists($emailId);
        if ($accountExists) {
            $this->output->error("account already exists");
        }

        $name      = $payload['name'];
        $age       = $payload['age'];
        $avatarUrl = $payload['avatarUrl'];

        $password = $payload['password'];
        $password = $this->credentialsManager->getHashFor($password);

        $date = new DateTime();

        $numberOfGamesPlayed = -1;
        $rank                = -1;
        $winPercentage       = -1;
        $playerId            = md5($date->getTimestamp() . "playerId" . rand(111111, 999999));
        $token               = md5($date->getTimestamp() . "token" . rand(111111, 999999));

        // $DB_TABLE = 'players_data';

        $sql    = "INSERT IGNORE INTO $playersData (emailId,password,playerId) VALUES ('$emailId', '$password', '$playerId')";
        $result = $conn->query($sql);

        if (!$result) {
            Log::e($this, "createPlayer: " . mysqli_error($this->conn));
            $this->output->show_error("database exception ");
        }

        $DB_TABLE = 'players';
        $sql      = "INSERT IGNORE INTO $DB_TABLE (name,age,avatarUrl,emailId,password,numberOfGamesPlayed,rank,winPercentage,playerId,token) VALUES (
        '$name','$age','$avatarUrl','$emailId','$password','$numberOfGamesPlayed','$rank','$winPercentage','$playerId','$token')";

        $result = $conn->query($sql);
        if (!$result) {
            Log::e($this, "createPlayer: " . mysqli_error($this->conn));
            $this->output->show_error("database exception");
        }
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

        $sql    = "SELECT * FROM playersData WHERE `emailId` = '$emailId'";
        $result = $conn->query($sql)->fetch_assoc();
        if (!$result) {
            Log::e($this, "getPlayerFor: " . mysqli_error($this->conn));
            $this->output->show_error("database exception");
        }
        $playerId = $result['playerId'];

        $DB_TABLE = 'players';
        $sql      = "SELECT  * FROM $DB_TABLE WHERE playerId = '$playerId'";
        $result   = $conn->query($sql);
        $row      = $result->fetch_assoc();
        return $row;
    }

    public function updatePlayer($playerId, $payload)
    {

    }

    public function checkIfPlayerExists($emailId)
    {
        return true;
    }

}
