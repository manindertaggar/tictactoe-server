<?php
class TicTacToeEngine
{
    public function __construct()
    {

    }

    public function onMessageReceived($message)
    {
        file_put_contents("log.txt", $message);
    }
}
