<?php

use PHPMailer\PHPMailer\PHPMailer;


require __DIR__.'/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

// nueva instancia
class EnvioMail extends PHPMailer
{
    private $nombreEmpresa;
    private $destinatario;

    function __construct($empresa, $emailDest)
    {
        $this->nombreEmpresa = $empresa;   
        $this->destinatario = $emailDest;   
    }

    function envioMailGerenteYempleado($gerente, $empleado, $password)
    {
        $this->isSMTP();
        $this->Host = 'smtp.gmail.com';
        $this->SMTPAuth = true;
        $this->Port = 587; // or 587
        $this->Username = 'studyehoshua@gmail.com';
        $this->Password = 'nwxraisosqykzobg';
        $this->SMTPSecure = 'tls';

        // configurar el contenido

        $this->setFrom('admin@billmaker.com', 'adminBillMaker');
        $this->addAddress($this->destinatario, 'billmaker.com');
        $this->Subject = 'Se han enviado sus dos credenciales de Bill maker';


        //habiltar html
        $this->isHTML(true);
        $this->CharSet = 'UTF-8';

        $contenido = '<html>
        <h1>Datos de <i>' . $this->nombreEmpresa . '</i> </h1>
        <p>Nombre de usuario de gerente : <b>' . $gerente . '</b></p>
        <p>Nombre de usuario de empleado : <b>' . $empleado . '</b></p>
        <p>Tu contaseña :<b>' . $password . '<b></p>
        <p> </p>
        <p> </p>
        <p> </p>
        <p> </p>
        <p><i>Gracias por confiar en nosotros</i></p>
        </html>';

        $this->Body = $contenido;
        $this->AltBody = 'Nombre de usuario de gerente : ' . $gerente . ' Nombre de usuario de empleado :' . $empleado . ' Tu contaseña ' . $password;
        //enviar el ,mail

        return ($this->send());
    }
    function enviarMailEmpleado($usuario, $password)
    {
        $this->isSMTP();
        $this->Host = 'smtp.gmail.com';
        $this->SMTPAuth = true;
        $this->Port = 587; // or 587
        $this->Username = 'studyehoshua@gmail.com';
        $this->Password = 'nwxraisosqykzobg';
        $this->SMTPSecure = 'tls';

        // configurar el contenido

        $this->setFrom('admin@billmaker.com', 'adminBillMaker');
        $this->addAddress('yehoshua350@gmail.com', 'billmaker.com');
        $this->Subject = 'Se han enviado sus dos credenciales de Bill maker';


        //habiltar html
        $this->isHTML(true);
        $this->CharSet = 'UTF-8';

        $contenido = '<html>
        <h1>Datos de <i>' . $this->nombreEmpresa . '</i> </h1>
        <p>Nombre de usuario de empleado : <b>'.$usuario.'</b></p>
        <p>Tu contaseña : <b>'.$password.'</b></p>
        <p> </p>
        <p> </p>
        <p> </p>
        <p> </p>
        <p><i>Gracias por confiar en nosotros</i></p>
        </html>';

        $this->Body = $contenido;
        $this->AltBody = ' Nombre de usuario de empleado :' . $usuario . ' Tu contaseña ' . $password;
        //enviar el ,mail

        return ($this->send());
       
    }
}
//$email->envioMailGerenteYempleado('gerente@chocolates.com', 'gerente@chocolates.com', 'contraseña');
 /* $email->envioMail(); */

