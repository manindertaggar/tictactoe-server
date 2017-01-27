<?php
require 'TicTacToeEngine.php';

$message         = $_POST["message"];
$ticTacToeEngine = new TicTacToeEngine();
$ticTacToeEngine->onMessageReceived($message);
