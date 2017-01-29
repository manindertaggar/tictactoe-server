<?php
class Log
{
    public static function e($obj, $message)
    {
        $tag= get_class($obj);
    	$printableMessage ="\terror - $tag\n$message"; 
    	Log::show($printableMessage);
    }


    public static function w($obj, $message)
    {
        $tag= get_class($obj);
    	$printableMessage ="\twarning - $tag\n$message"; 
    	Log::show($printableMessage);
    
    }

    public static function d($obj, $message)
    {
        $tag= get_class($obj);
    	$printableMessage ="\tdebug - $tag\n$message"; 
    	Log::show($printableMessage);
    }

    public static function i($obj, $message)
    {
        $tag= get_class($obj);
    	$printableMessage ="\tinfo - $tag\n$message"; 
    	Log::show($printableMessage);    
    }

    private static function show($message)
    {
	    $fileName = "log.txt";

        $time = date('Y-m-d H:i:s');
        $message = $time." : ".$message;

		file_put_contents($fileName, $message.PHP_EOL.PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    public static function clear(){
	    $fileName = "log.txt";
        $time = date('Y-m-d H:i:s');
		file_put_contents($fileName, "cleared at : $time\n\n");    	
    }
}
