
<?php
    include './php/seguridad/elPuertasYelCoyote.php';
    session_start();
    PuertasYcoyote::seccionDesignada();
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
                        ">
                <div class="registro_formulario col d-grid  mx-2  mt-3 gap-2 mb-0  align-self-start align-self-md-center bg-primary" id="registro_formulario">
                    <label for="usuario_nick">Nombre del usuario</label>
                    <input type="text" id="usuario_nick" name="usuario_np" placeholder="ejemplo: Mi_usuario@email.org" value="arturo.soria_ep@chocolates-union.com">
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
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                                </div>
                                <div class="modal-body row m-3 bg-dark d-flex gap-2" id="formulario_registrar">
                                    <label for="nombreEmpresa">Nombre de la empresa</label>
                                    <input class="form-control" type="text" name="nombreEmpresa" id="nombreEmpresa" placeholder="Nombre fiscal">
                                    <label for="dni">CIF</label>
                                    <input class="form-control" type="text" name="dni" id="dni" placeholder="G12345678 / 25148596D">
                                    <label for="direccion">Direccion</label>
                                    <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Calle Anton 14">
                                    <label for="email">Correo electronico</label>
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Mi_usuario@email.org">
                                    <label for="telefono">Telefono de contacto</label>
                                    <input class="form-control" type="tel" name="telefono" id="telefono" placeholder="6245854132">
                                    <label for="contacto">Persona de contactos</label>
                                    <input class="form-control" type="text" name="contacto" id="contacto" placeholder="Miguel Angel">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" autocomplete="on">
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
