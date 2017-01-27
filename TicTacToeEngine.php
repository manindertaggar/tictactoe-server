<?php
class TicTacToeEngine
{
    public function __construct()
    {

    }

    public function onMessageReceived($message)
    {
        var_dump(file_put_contents("log.txt", $message));
    }
}
