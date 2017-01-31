<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Output
{
    function error($errorMessage)
    {
        die('{"error": {"message": "' . $errorMessage . '"}}');
    }

    function success($data)
    {
        echo '{"data":' . $data . '}';
    }
}

