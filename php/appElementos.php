<?php
class app
{

    private const LATOUT = __DIR__ . '/layout';
    private const SEGURIDAD = __DIR__ . '/';

    static function llamarLayout($nombre)
    {
        include self::LATOUT . "/{$nombre}.php";
        
    }
    static function llamrarSeguridad($nombre)
    {
        include self::SEGURIDAD . "/{$nombre}.php";
        
    }

    static function nombreTitle(){
        $arch  = substr(__FILE__, 0, strlen(__FILE__) - 4);
        $arch = explode(' ', str_replace(strpos($arch, '\\') > 0 ? '\\' : '/', ' ', $arch));
        echo ucfirst(array_pop($arch));
    }
}
 