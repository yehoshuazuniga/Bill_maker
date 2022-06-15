<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de proveedores
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Alta proveedor
            </li>
        </ul>
    </aside>
    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <div class="col-12 col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="nombre">Nombre proveedor</label>
            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="ej: Mi proveedor">
            <label for="dni">CIF</label>
            <input class="form-control" type="text" name="dni" id="dni1" placeholder="G12345678">
            <label for="direccion">Direccion</label>
            <input class="form-control" type="text" name="direccion" id="direccion1" placeholder="Calle Anton 14">
            <label for="email">Correo electronico</label>
            <input class="form-control" type="email" name="email" id="email1" placeholder="Mi_usuario@email.org">
            <label for="personaContacto">Persona de contacto</label>
            <input class="form-control" type="text" name="personaContacto" id="personaContacto1" placeholder="Antonio Cuenca">
            <label for="telefono">Telefono de contacto</label>
            <input class="form-control" type="tel" name="telefono" id="telefono1" placeholder="6245854132">
            <button name="registrar" id="registrar">Registrar proveedor </button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">
                    <td>NIF</td>
                    <td>Nombre proveedor</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>Estado</td>
                    <td>Seleccionar</td>
                </tr>
            </table>
            <div class="modal fade" id="modal-proveedor" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-proveedor" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-black">
                                Datos del proveedor
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3">
                            <label class="text-dark" for="nombre">Nombre comercial</label>
                            <input class="form-control " type="text" name="nombre" id="nombre" placeholder="ej: Mi empresa" disabled>
                            <label class="text-dark" for="dni">CIF</label>
                            <input class="form-control " type="text" name="dni" id="dni" placeholder="Y12345678X / 25148596D" disabled>
                            <label class="text-dark" for="direccion">Direccion</label>
                            <input class="form-control " type="text" name="direccion" id="direccion" placeholder="Calle Anton 14" disabled>
                            <label class="text-dark" for="email">Correo electronico</label>
                            <input class="form-control " type="email" name="email" id="email" placeholder="Mi_usuario@email.org" disabled>
                            <label class="text-dark" for="telefono">Telefono de contacto</label>
                            <input class="form-control " type="tel" name="telefono" id="telefono" placeholder="6245854132" disabled>
                            <label class="text-dark" for="personaContacto">Persona de contacto</label>
                            <input class="form-control " type="text" name="personaContacto" id="personaContacto" placeholder="Juan Manuel" disabled>
                            <div class="form-check">
                                <label for="activo" class="form-check-label text-dark">Estado activo</label>
                                <input type="radio" class="form-check-input" name="estado" id="activo" value="activo" disabled>
                            </div>
                            <div class="form-check">
                                <label for="inactivo" class="form-check-label text-dark">Estado inactivo</label>
                                <input type="radio" class="form-check-input" name="estado" id="inactivo" value="inactivo" disabled>
                            </div>
                            <button name="mofificar-proveedor" id="mofificar">Modificar</button>
                            <button id="mofificar-aceptar" disabled>Aceptar modificaciones</button>
                            <button name="dar-baja" id="dar-baja"">Dar baja</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php
app::llamarLayout('footer');
?>