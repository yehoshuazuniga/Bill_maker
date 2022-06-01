<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <aside class="col col-lg-auto pe-4 col-12 "  id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de empleados
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Alta empleado
            </li>
        </ul>
    </aside>

    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <main class="col-12 col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="empleado-nombre-registrar">Nombre y Apellido</label>
            <input type="text" name="empleado-nombre-registrar" id="empleado-nombre-registrar" placeholder="ej: Juan">
            <label for="empleado-dni-registrar">DNI/NIE</label>
            <input type="text" name="empleado-dni-registrar" id="empleado-dni-registrar" placeholder="Y12345678X / 25148596D">
            <label for="empleado-direccion-registrar">Direccion</label>
            <input type="text" name="empleado-direccion-registrar" id="empleado-direccion-registrar" placeholder="Calle Anton 14">
            <label for="empleado-email-registrar">Correo electronico</label>
            <input type="email" name="empleado-email-registrar" id="empleado-email-registrar" placeholder="Mi_usuario@email.org">
            <label for="empleado-telefono-registrar">Telefono de contacto</label>
            <input type="tel" name="empleado-telefono-registrar" id="empleado-telefono-registrar" placeholder="6245854132">
            <button name="registrar" id="registrar" >Registrar empleado
            </button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive-md ">
            <table class="table  table-hover table-sm">
                <tr class="table-dark">
                    <td>Codigo empleado</td>
                    <td>Nombre y apellido</td>
                    <td>Telefono</td>
                    <td>Email</td>

                    <td>Seleccionar</td>
                </tr>
                <tr>
                    <td>Codigo empleado</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>

                    <td><button name="empleado-id-numeroid" id="id-1">Seleccionar</button> (boton que seleciona el empleado) </td>
                </tr>
                <tr>
                    <td>Codigo empleado</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>

                    <td><button name="empleado-id-numeroid" id="id-2">Seleccionar</button> (boton que seleciona el empleado) </td>
                </tr>
                <tr>
                    <td>Codigo empleado</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>

                    <td><button name="empleado-id-numeroid" id="id-3" data-bs-toggle="modal" data-bs-target="#modal-empleado">Seleccionar</button> (boton que seleciona el empleado)
                    </td>
                </tr>
            </table>
            <div class="modal fade" id="modal-empleado" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-empleado" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Registro tus datos
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body row m-3">
                            <label class="text-dark" for="empleado-nombre-registro">Nombre</label>
                            <input type="text" name="empleado-nombre-registro" id="empleado-nombre-registro" placeholder="ej: Juan">
                            <label class="text-dark" for="empleado-dni-registro">DNI/NIE</label>
                            <input type="text" name="empleado-dni-registro" id="empleado-dni-registro" placeholder="Y12345678X / 25148596D">
                            <label class="text-dark" for="empleado-direccion-registro">Direccion</label>
                            <input type="text" name="empleado-direccion-registro" id="empleado-direccion-registro" placeholder="Calle Anton 14">
                            <label class="text-dark" for="empleado-email-registro">Correo electronico</label>
                            <input type="email" name="empleado-email-registro" id="empleado-email-registro" placeholder="Mi_usuario@email.org">
                            <label class="text-dark" for="empleado-telefono-registro">Telefono de contacto</label>
                            <input type="tel" name="empleado-telefono-registro" id="empleado-telefono-registro" placeholder="6245854132">
                            <button name="mofificar-empleado" id="mofificar-empleado" data-bs-dismiss="modal">Modificar
                            </button>
                            <button name="dar-baja-empleado" id="dar-baja-empleado" data-bs-dismiss="modal">Dar baja
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</section>
<?php
app::llamarLayout('footer');
?>