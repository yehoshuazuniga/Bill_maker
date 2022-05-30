<?php
    include './php/seguridad/elPuertasYelCoyote.php';
     PuertasYcoyote::sessionIniciada();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="Yehoshua Zuñiga">
    <title>Bill maker</title>
    <link rel="stylesheet" href="./css/bootstrap_css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/mi_estilo/misestilos.css">
</head>

<body>
    <div class="container-fluid">
        <section class="row pt-5 pt-md-0
                                justify-content-center 
                                vh-100">
            <div class="col-auto col-md-4
                        pd-md-5 p-0 row
                        bg-primary">
                <div class="registro_formulario col d-grid  mx-2  mt-3 gap-2 mb-0  align-self-start align-self-md-center" id="registro_formulario">
                    <label for="usuario_nick">Nombre del usuario</label>
                    <input type="text" id="usuario_nick" name="usuario_np" placeholder="ejemplo: Mi_usuario@email.org" value="yehoshua_gt@bill-maker.com">
                    <label for="usuario_password">Password</label>
                    <input type="password" id="usuario_password" name="usuario_np" autocomplete="on" value="password">
                    <button name="boton_envio" id="envio" class="btn btn-primary"> Acceder</button>
                    <button name="boton_registro" id="registro" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-registro">Registrar</button>
                    <!-- creacion del modal que contiene el formaulario de registro
                            solo sera visible cuando se de al boton de registrarse

                            -->
                    <div class="modal fade" id="modal-registro" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static">
                        <div class=" modal-dialog modal-dialog-centered modal-dialog-crollable">
                            <div class="modal-content bg-dark">
                                <div class="modal-header">
                                    <h3 class="modal-title">
                                        Registro tus datos
                                    </h3>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body row m-3 bg-dark d-flex gap-2" id="formulario_registrar">
                                    <label for="usuario_nick_registro">Nombre de la empresa</label>
                                    <input type="text" name="usuario_nick_registro" id="usuario_nick_registro" placeholder="Nombre fiscal">
                                    <label for="usuario_cif">CIF</label>
                                    <input type="text" name="usuario_cif" id="usuario_cif" placeholder="G12345678 / 25148596D">
                                    <label for="usuario_direccion">Direccion</label>
                                    <input type="text" name="usuario_direccion" id="usuario_direccion" placeholder="Calle Anton 14">
                                    <label for="usuario_email">Correo electronico</label>
                                    <input type="email" name="usuario_email" id="usuario_email" placeholder="Mi_usuario@email.org">
                                    <label for="usuario_telefono">Telefono de contacto</label>
                                    <input type="tel" name="usuario_telefono" id="usuario_telefono" placeholder="6245854132">
                                    <label for="usuario_contacto">Persona de contactos</label>
                                    <input type="text" name="usuario_contacto" id="usuario_contacto" placeholder="Miguel Angel">
                                    <label for="usuario_password_registro">Password</label>
                                    <input type="password" name="usuario_password_registro" id="usuario_password_registro" autocomplete="on">
                                    <button name="registrar" id="registrar">registrar </button>
                                    <button name="cerrar" id="cerrar" data-bs-dismiss="modal">cerrar </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col col-md-8 bg-warning  d-none d-md-block "></div>

        </section>
    </div>
    <script src="./js/bootstrap_js/bootstrap.bundle.min.js"></script>
    <script src="./js/app/app.js"></script>
</body>

</html>