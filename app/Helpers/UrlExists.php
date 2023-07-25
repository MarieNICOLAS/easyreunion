<?php

namespace App\Helpers;

class UrlExists
{

    public static function  UrlExists($url){

        if(!$url) return false;

        if(str_contains($url, 'localhost')) return false;

        if (@getimagesize($url)) {
            return true;
        } else {
            return false;
        }


    }
}
