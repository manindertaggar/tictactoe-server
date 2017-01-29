<?php

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

