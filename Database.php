<?php

class Database
{
    private $DB_HOST = "localhost";
    private $DB_USER = "root";
    private $DB_PASSWORD = "2eight1987";
    private $DB_NAME = "tictactoe";
    private $conn = null;

    public function __construct()
    {
        $this->conn = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB_NAME);
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
