<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <h2 class=" text-center"> Empleados</h2>
    <aside class="col col-lg-auto pe-4 col-12 position-sticky " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0 position-sticky desplaSticky">
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
            <label class="text-dark" for="nombre">Nombre y Apellido</label>
            <input class="form-control" type="text" name="nombre" id="nombre1" placeholder="ej: Juan">
            <label class="text-dark" for="dni">DNI/NIE</label>
            <input class="form-control" type="text" name="dni" id="dni1" placeholder="Y12345678X / 25148596D">
            <label class="text-dark" for="direccion">Direccion</label>
            <input class="form-control" type="text" name="direccion" id="direccion1" placeholder="Calle Anton 14">
            <label class="text-dark" for="email">Correo electronico</label>
            <input class="form-control" type="email" name="email" id="email1" placeholder="Mi_usuario@email.org">
            <label class="text-dark" for="telefono">Telefono de contacto</label>
            <input class="form-control" type="tel" name="telefono" id="telefono1" placeholder="6245854132">
            <label for="empleado-telefono-registrar">Password</label>
            <input class="form-control" type="password" name="password" id="password">
            <button name="registrar" id="registrar">Registrar empleado
            </button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive-md ">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">
                    <td>Codigo empleado</td>
                    <td>Nombre y apellido</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>Estado</td>
                    <td>Seleccionar</td>
                </tr>

            </table>
            <div class="modal fade" id="modal-empleado" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-empleado" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-black">
                                Datos del empleado
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id="cerrar-modal"></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3">
                            <label class="text-dark" for="nombre">Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="ej: Juan" disabled>
                            <label class="text-dark" for="dni">DNI/NIE</label>
                            <input class="form-control" type="text" name="dni" id="dni" placeholder="Y12345678X / 25148596D" disabled>
                            <label class="text-dark" for="direccion">Direccion</label>
                            <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Calle Anton 14" disabled>
                            <label class="text-dark" for="email">Correo electronico</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Mi_usuario@email.org" disabled>
                            <label class="text-dark" for="telefono">Telefono de contacto</label>
                            <input class="form-control" type="tel" name="telefono" id="telefono" placeholder="6245854132" disabled>
                            <div class="form-check">
                                <label for="activo" class="form-check-label text-dark">Estado activo</label>
                                <input type="radio" class="form-check-input" name="estado" id="activo" value="activo" disabled>
                            </div>
                            <div class="form-check">
                                <label for="inactivo" class="form-check-label text-dark">Estado inactivo</label>
                                <input type="radio" class="form-check-input" name="estado" id="inactivo" value="inactivo" disabled>
                            </div>
                            <button name="mofificar-empleado" id="mofificar">Modificar
                            </button>
                            <button id="mofificar-aceptar" disabled>Aceptar modificaciones</button>
                            <button name="dar-baja" id="dar-baja"">Dar baja</button>
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