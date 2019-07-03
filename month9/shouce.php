<?php
class Something
{
    public function __construct()
    {
        echo __METHOD__ . PHP_EOL;
    }
    public function __destruct()
    {
        echo __METHOD__ . PHP_EOL;
        throw new Exception("Exception thrown out of ::__destruct()", 1);
    }
}
try{
    $Something = new Something();
    $Something = null; // will cause to call the objects ::__destruct()
    // also possible: unset($Something);
}catch(Exception $e){
    echo 'Exception: ' . $e->getMessage() . PHP_EOL;
}
echo 'End of script -- no Fatal Error.';
?>