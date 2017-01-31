<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'TicTacToeEngine.php';

$message         = json_decode($_POST['message'], true);
$ticTacToeEngine = new TicTacToeEngine();
$ticTacToeEngine->onPacketReceived($message);
