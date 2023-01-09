<?php 

class Enviroment{
    public static function load($dir){

        if(!file_exists($dir.'/.env')){
            return false;
        }        

        $variables = file($dir.'/.env');
        foreach($variables as $line){
            putenv(trim($line));
        }
        
    }
}
