<?php
class Datos
{
    private $datos ;
    public function __set($nombre, $valor)
    {
        $this->datos[$nombre] = $valor;
    }
    public function __get($nombre)
    {
        return $this->datos[$nombre];
    }
}
$datos = new Datos;
$datos->datos = "Este es el primer dato";
$datos->datos = 1;

echo "<pre>";
print_r($datos);
echo "</pre>";