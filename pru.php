<?php
/* echo __FILE__.'              ';
var_dump( strpos(__FILE__, 'prGu.php'));
define('DIR', __DIR__.'/clientes');
if(!is_dir(DIR))die("No existe el directorio ".DIR);

$dir_cursor = @opendir(DIR) or die("Error al abrir el directorio");

$entrada = readdir($dir_cursor);
while ($entrada !== false) // mientras haya datos
{
    echo " $entrada\n";
    $entrada = readdir($dir_cursor); // lee siguiente entrada
}
echo "</pre>\n";
closedir($dir_cursor); // cerramos el directorio */
session_start();
mkdir("./clientes/".$_SESSION['BBDD'])
?>