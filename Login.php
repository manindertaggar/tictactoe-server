<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Output.php';
$output = new Output();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $output->error("invalid request method");
}

require_once 'PlayerManager.php';
require_once 'Database.php';

$conn = (new Database())->getConnection();

$postBody = json_decode(file_get_contents('php://input'), true);

if (is_null($postBody) || !array_key_exists('intent', $postBody)) {
    $output->error("invalid arguments");
}

$intent        = $postBody['intent'];
$playerManager = new PlayerManager($conn);

if ($intent === "signup") {
    $playerManager->createPlayer($postBody['data']);
} else if ($intent === "login") {


    if (!array_key_exists('emailId', $postBody['data'])||
        !array_key_exists('token', $postBody['data'])) {
        $output->error("invalid arguments");
    }

    $emailId = $postBody['data']['emailId'];
    $token    = $postBody['data']['token'];

    $player = $playerManager->getPlayerFor($emailId, $token);
    $output->success(json_encode(array('player' => $player)));

} else if ($intent === "check") {

    if (!array_key_exists('emailId', $postBody['data'])) {
        $output->error("invalid arguments");
    }

    $emailId = $postBody['data']['emailId'];

    $playerExists = $playerManager->checkIfPlayerExists($emailId);
    $output->success(json_encode(array('playerExists' => $playerExists)));

}

// $password = get_hash_for($_POST['password']);

// $date = new DateTime();
// $time_stamp = $date->getTimestamp();
// $id = md5($date->getTimestamp() . "h" . rand(0, 1000));

// $win_percentage = 0;

// $DB_TABLE = 'players_data';

// $sql = "INSERT IGNORE INTO $DB_TABLE (email_id,password,id) VALUES ('$email_id', '$password', '$id')";
// $conn->query($sql);

// $token = md5(md5(rand() . rand() . rand()));

// $DB_TABLE = 'players';
// $sql = "INSERT IGNORE INTO $DB_TABLE (name, avatar_url, email_id, id, token,last_seen) VALUES ('$name', '$avatar_url', '$email_id', '$id', '$token','$time_stamp')";

// $conn->query($sql);
// var_dump($conn);

// $DB_TABLE = 'players_data';
// $sql = "SELECT * FROM $DB_TABLE WHERE `email_id` = '$email_id'";
// $result = $conn->query($sql)->fetch_assoc();
// $hash = $result['password'];
// $id = $result['id'];

// if (password_verify($_POST['password'], $hash)) {
//     $DB_TABLE = 'players';
//     $sql = "SELECT  * FROM $DB_TABLE WHERE id = '$id'";
//     $result = $conn->query($sql);
//     $row = $result->fetch_assoc();
//     $data = json_encode($row);
//     $output->show_success($data);
// } else {
//     $output->show_error("Username/password is incorrect.");
// }

// $conn->close();
