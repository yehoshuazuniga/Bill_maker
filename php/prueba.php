<?php
require __DIR__.'/fpdf/fpdf.php';
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../src/img/Logo_TV_sssss2015.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80,36,);
    // Título
    $this->Cell(30,10,'title',1,0,'C');
    // Salto de línea
    $this->Ln(70);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}


$serv =[ "CUSC003"
, "CUSC003"
, "CUSC006"
, "CUSC008"
, "CUSC007"
, "CUSC008"
, "CUSC007"];

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetFont('Times','',12);
for($i=1;$i<count($serv);$i++)
    $pdf->Cell(0,10,utf8_decode($serv[$i]).$i,1,1);
 //   $pdf->Output('F', '../clientes/prueba/prueba2.pdf');
    //$pdf->Output('D', 'prueba2.pdf');
    $pdf->Output();
       

?>