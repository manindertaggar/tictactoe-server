<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Output.php';
require_once 'Log.php';

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
        !array_key_exists('password', $postBody['data'])) {
        $output->error("invalid arguments");
    }

    $emailId = $postBody['data']['emailId'];
    $password    = $postBody['data']['password'];

    $player = $playerManager->getPlayerFor($emailId, $password);
    $output->success(json_encode(array('player' => $player)));

} else if ($intent === "check") {

    if (!array_key_exists('emailId', $postBody['data'])) {
        $output->error("invalid arguments");
    }

    $emailId = $postBody['data']['emailId'];

    $playerExists = $playerManager->checkIfPlayerExists($emailId);
    $output->success(json_encode(array('playerExists' => $playerExists)));

}

