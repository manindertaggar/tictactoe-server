<?php
require 'TicTacToeEngine.php';

$message         = json_decode($_POST['message'], true);
$ticTacToeEngine = new TicTacToeEngine();
$ticTacToeEngine->onPacketReceived($message);
