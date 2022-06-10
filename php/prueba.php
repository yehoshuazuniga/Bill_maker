
<?php
require __DIR__ . '/fpdf/fpdf.php';


class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo+
        $this->Image('../src/img/Logo_TV_sssss2015.png', 20, 10, 50);
        $this->Rect(5, 5, 200, 287);
        $this->Rect(85, 10, 115, 56);
        $this->Rect(10, 70, 190, 40);
        // $this->Rect(5,5,200,287);
        // Arial bold 15
        $this->SetFont('Arial', 'I');
        $this->Cell(75, 0, '');
        $this->Cell(115, 8, 'Datos del Cliente', 1, 0, 'C');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, 'Nombre ');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, 'CIF');
        $this->Ln(8);
        $this->Cell(80, 0, '',);
        $this->Cell(100, 8, 'Direccion');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, 'Telefono');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, 'E-mail');
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, 'Persona de contacto ');
        $this->Ln(12);


        //segunda caja 
        $this->Cell(190, 8, 'Datos de la empresa patrocinadora', 1, 0, 'C');
        $this->Ln(8);
        $this->Cell(95, 8, ' Nombre: ');
        $this->Cell(95, 8, ' CIF : ');
        $this->Ln(8);
        $this->Cell(95, 8, ' Dirección: ');
        $this->Cell(95, 8, ' Telefono: ');
        $this->Ln(8);
        $this->Cell(95, 8, ' E-mail: ');
        $this->Cell(95, 8, ' Persona de contacto : ');
        $this->Ln(8);
        $this->Cell(95, 8, ' Atendido por: ');
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

       // $medidas = [47.5, 122,20.5];
       $medidas = ['nombre'=> 62.5, 'descripcion'=> 107, 7, 'precio'=>20.5];
        $cont = 0;
        for ($i=0; $i < count($datos); $i++) { 
            $this->Ln();
                $dat = $datos[$i];
           foreach ($dat as $key => $value) {
                $this->Cell($medidas[$key], 7, $value, 1);
           }
        }
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
        "nombre" => "TARTA DE LUNES DOBLE",
        "descripcion" => "TARTA DE LUNES DOBLE",
        "precio" => "25"
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
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
//$pdf->SetFont('Times', '', 12);
$pdf->BasicTable($cabeceraServ,$datos);
$pdf->AddPage('P', 'A4');
/* for ($i = 1; $i < count($serv); $i++)
    $pdf->Cell(0, 10, utf8_decode($serv[$i]) . $i, 1, 1);
//   $pdf->Output('F', '../clientes/prueba/prueba2.pdf');
//$pdf->Output('D', 'prueba2.pdf'); */
$pdf->Output();
