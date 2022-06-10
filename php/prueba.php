
<?php
require __DIR__ . '/fpdf/fpdf.php';


class PDF extends FPDF
{
    protected $datosEmpresa;
    protected $datosCliente;
    protected $datosOperacion;
    protected $operador;
function __construct( $empresa, $cliente, $operacion, $operador)
{
    $this->datosEmpresa = $empresa;
    $this->datosCliente = $cliente;
    $this->datosOperacion = $operacion;
    $this->operador = $operador;
    parent::__construct();
}

    // Cabecera de página
    function Header()
    {
        // Logo+
        $this->Image('../src/img/Logo_TV_sssss2015.png', 20, 10, 50);
        $this->Rect(5, 5, 200, 287);
        $this->Rect(85, 10, 115, 56);
        $this->Rect(10, 78, 190, 40);
        // $this->Rect(5,5,200,287);
        // Arial bold 15
        $this->SetFont('Arial', 'I');
        $this->Cell(75, 0, '');
        $this->Cell(115, 8, utf8_decode('Datos del Cliente'), 1, 0, 'C');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('Nombre '.$this->datosCliente['nombreEmpresa']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('CIF '.$this->datosCliente['dni']));
        $this->Ln(8);
        $this->Cell(80, 0, '',);
        $this->Cell(100, 8, utf8_decode('Dirección '.$this->datosCliente['direccion']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('Teléfono '.$this->datosCliente['telefono']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('E-mail '.$this->datosCliente['email']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('Persona de contacto '.$this->datosCliente['personaContacto']));
        $this->Ln(12);


        //segunda caja 
        $this->Cell(190, 8, 'Datos de la empresa patrocinadora', 1, 0, 'C');
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Nombre: '.str_replace('_',' ',$this->datosEmpresa['basedatos'])));
        $this->Cell(95, 8, utf8_decode(' CIF : '.$this->datosEmpresa['dni']));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Dirección: '.$this->datosEmpresa['direccion']));
        $this->Cell(95, 8, utf8_decode(' Teléfono: '.$this->datosEmpresa['telefono']));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' E-mail: '.$this->datosEmpresa['email']));
        $this->Cell(95, 8, utf8_decode(' Persona de contacto : '.$this->datosEmpresa['nombre'] .' '.$this->datosEmpresa['apellido']  ));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Atendido por: '.$this->operador));
        $this->Cell(95, 8, utf8_decode(' Nº de operación: '.array_shift($this->datosOperacion)));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Fecha de operación: '.array_shift($this->datosOperacion)));
        // Título
        /*    $this->Cell(25,10,'DNI
                         titulo',1,0,'C'); */
        // Salto de línea
        $this->Ln(15);
    }

    function BasicTable($header, $datos)
    {

        $this->Cell(62.5, 7, $header[0], 1);
        $this->Cell(107, 7, $header[1], 1);
        $this->Cell(20.5, 7, $header[2], 1 );
        $this->Ln();

       // $medidas = [47.5, 122,20.5];
       $medidas = ['nombre'=> 62.5, 'descripcion'=> 107, 7, 'precio'=>20.5];
        $cont = 0;
        $cont2 = 0;
        for ($i=0; $i < count($datos); $i++) { 
                $dat = $datos[$i];
           foreach ($dat as $key => $value) {
                $this->Cell($medidas[$key], 7, utf8_decode($value));
                if($key = 'precio'){
                    $cont += intval($value);
                }
                $cont2 +=7;
           }
           $this->Ln();
        }
        $this->Cell(157,14,'',0);
        $this->Cell(20.5,14, $cont,0,0,'R');
        $this->Ln();
        $this->Cell(162.5,14,'');
        $this->Cell(20.5,14, utf8_decode('Total con IVA incluido '.($cont*1.21)."$"),0,0,'R');
      //  echo $cont;
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 1, 0, 'C');
    }
}


$serv =
    [
        "CUSC003", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC003", "CUSC006", "CUSC008", "CUSC007", "CUSC008", "CUSC007"
    ];
$cabeceraServ = ['Nombre', 'Descripcion', 'Precio'];

$datos = [
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]
    ,
    [

        "nombre" => "TARTA DE ARANDANO",
        "descripcion" => "TARTA DE ARANDANO",
        "precio" => "25"
    ],
    [
 
         "nombre" =>  "TARTA DE ARANDANO",  
          "descripcion" =>  "TARTA DE ARANDANO",   
          "precio" =>   "25"
    ]


];

// Creación del objeto de la clase heredada
$empresa=[
    "dni"=>
     "g87654321",
    "direccion"=>
     "calleita",
    "telefono"=>
     "6576765",
    "email"=>
     "kikocorreo@veneno.es",
    "nombre"=>
     "kiko",
    "apellido"=>
     "veneno",
    "basedatos"=>
    "kiko_veneno"
];
$cliente =[
    "dni"=>
    "g00000001",
    "nombreEmpresa"=>
    "Cocheras",
    "direccion"=>
     "c/ santo 12",
    "email"=>
     "alfons@gmail.com",
    "telefono"=>
    "632852369",
    "personaContacto"=>
    "alfonso santos"
];
$operacion=[
    "idPresupuesto"=>
    227079,
    "fechaCreacion"=>
   "2022-06-10 12:38:51"
];
$operador='yo mismo';
$pdf = new PDF( $empresa, $cliente, $operacion, $operador);
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$pdf->SetFont('Times', '', 12);
//$pdf->BasicTable($cabeceraServ,$datos);

/* for ($i = 1; $i < count($serv); $i++)
    $pdf->Cell(0, 10, utf8_decode($serv[$i]) . $i, 1, 1);
 */ $pdf->Output('F', '../clientes/cosas/prueba3.pdf');
    $pdf->Output('D', 'prueba3.pdf'); 
$pdf->Output();
