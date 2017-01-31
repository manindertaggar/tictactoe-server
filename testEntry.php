<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'TicTacToeEngine.php';


$message = json_decode(file_get_contents('php://input'), true);
$ticTacToeEngine = new TicTacToeEngine();
$ticTacToeEngine->onPacketReceived($message);

