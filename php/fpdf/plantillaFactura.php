
<?php
require __DIR__ . '/fpdf.php';

class PDF extends FPDF
{
    protected $datosEmpresa;
    protected $datosCliente;
    protected $datosOperacion;
    protected $operador;
    protected $documento;
    function __construct($empresa, $cliente, $operacion, $operador, $tipoDoc)
    {
        $this->datosEmpresa = $empresa;
        $this->datosCliente = $cliente;
        $this->datosOperacion = $operacion;
        $this->operador = $operador;
        $this->documento = $tipoDoc;
        parent::__construct();
    }

    protected $javascript;
    protected $n_js;

    function IncludeJS($script, $isUTF8 = false)
    {
        if (!$isUTF8)
            $script = utf8_encode($script);
        $this->javascript = $script;
    }

    function _putjavascript()
    {
        $this->_newobj();
        $this->n_js = $this->n;
        $this->_put('<<');
        $this->_put('/Names [(EmbeddedJS) ' . ($this->n + 1) . ' 0 R]');
        $this->_put('>>');
        $this->_put('endobj');
        $this->_newobj();
        $this->_put('<<');
        $this->_put('/S /JavaScript');
        $this->_put('/JS ' . $this->_textstring($this->javascript));
        $this->_put('>>');
        $this->_put('endobj');
    }
    function _putresources()
    {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }
    function _putcatalog()
    {
        parent::_putcatalog();
        if (!empty($this->javascript)) {
            $this->_put('/Names <</JavaScript ' . ($this->n_js) . ' 0 R>>');
        }
    }
    function Header()
    {
        header("COntent-type:application/pdf");
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
        $this->Cell(100, 8, utf8_decode('Nombre ' . $this->datosCliente['nombreEmpresa']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('CIF ' . $this->datosCliente['dni']));
        $this->Ln(8);
        $this->Cell(80, 0, '',);
        $this->Cell(100, 8, utf8_decode('Dirección ' . $this->datosCliente['direccion']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('Teléfono ' . $this->datosCliente['telefono']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('E-mail ' . $this->datosCliente['email']));
        $this->Ln(8);
        $this->Cell(80, 0, '');
        $this->Cell(100, 8, utf8_decode('Persona de contacto ' . $this->datosCliente['personaContacto']));
        $this->Ln(12);
        //segunda caja 
        $this->Cell(190, 8, 'Datos de la empresa patrocinadora', 1, 0, 'C');
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Nombre: ' . str_replace('_', ' ', $this->datosEmpresa['basedatos'])));
        $this->Cell(95, 8, utf8_decode(' CIF : ' . $this->datosEmpresa['dni']));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Dirección: ' . $this->datosEmpresa['direccion']));
        $this->Cell(95, 8, utf8_decode(' Teléfono: ' . $this->datosEmpresa['telefono']));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' E-mail: ' . $this->datosEmpresa['email']));
        $this->Cell(95, 8, utf8_decode(' Persona de contacto : ' . $this->datosEmpresa['nombre'] . ' ' . $this->datosEmpresa['apellido']));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Atendido por: ' . $this->operador));
        $this->Cell(95, 8, utf8_decode(' Nº de ' . $this->documento . ': ' . array_shift($this->datosOperacion)));
        $this->Ln(8);
        $this->Cell(95, 8, utf8_decode(' Fecha de creacion: ' . array_shift($this->datosOperacion)));
        $this->Ln(15);
    }

    function BasicTable($header, $datos)
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(84.75, 7, $header[0], 1);
        $this->Cell(84.75, 7, $header[1], 1);
        $this->Cell(20.5, 7, $header[2], 1);
        $this->Ln();
        // $medidas = [47.5, 122,20.5];
        $cont = 0;
        $this->SetFont('Arial', '', 7);
        for ($i = 0; $i < count($datos); $i++) {
            $dat = $datos[$i][0];
            $this->Cell(84.75, 7, $dat['nombre'], 1);
            $this->Cell(84.75, 7, $dat['descripcion'], 1);
            $this->Cell(20.5, 7, $dat['precio'], 1);
            $cont += intval($dat['precio']);
            $this->Ln();
        }
        $this->SetFont('Arial', '', 10);
        $this->Cell(157, 14, 'Sumatorio Total', 0,0, 'R');
        $this->Cell(20.5, 14, $cont, 0, 0, 'R');
        $this->Ln();
        $this->Cell(162.5, 14, 'Total con IVA incluido', 0,0, 'R');
        $this->SetFont('Arial', 'B',18);
        $this->Cell(20.5, 14, utf8_decode( ($cont * 1.21) . "$"), 0, 0);
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
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
?>