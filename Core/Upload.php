<?php

namespace Core;

class Upload
{
    public static function one($filename, $save_as, $output){
        //$extension = explode('.', $filename['name']);
        //$extension = end($extension);
        //$file = $output.$save_as.'.'.$extension;
        $file = $output.$save_as;
        if(file_exists($file)){
            unlink($file); //delete from disk
        }
        move_uploaded_file($filename['tmp_name'], $file);
    }

}