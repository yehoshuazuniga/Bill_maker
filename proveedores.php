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
    <main class="col-12 col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="proveedor-nombre-registrar">Nombre proveedor</label>
            <input type="text" name="proveedor-nombre-registrar" id="proveedor-nombre-registrar" placeholder="ej: Mi proveedor">
            <label for="proveedor-cif-registrar">CIF</label>
            <input type="text" name="proveedor-cif-registrar" id="proveedor-cif-registrar" placeholder="G12345678">
            <label for="proveedor-direccion-registrar">Direccion</label>
            <input type="text" name="proveedor-direccion-registrar" id="proveedor-direccion-registrar" placeholder="Calle Anton 14">
            <label for="proveedor-email-registrar">Correo electronico</label>
            <input type="email" name="proveedor-email-registrar" id="proveedor-email-registrar" placeholder="Mi_usuario@email.org">
            <label for="proveedor-personaContacto-registrar">Persona de contacto</label>
            <input type="text" name="proveedor-personaContacto-registrar" id="proveedor-personaContacto-registrar" placeholder="6245854132">
            <label for="proveedor-telefono-registrar">Telefono de contacto</label>
            <input type="tel" name="proveedor-telefono-registrar" id="proveedor-telefono-registrar" placeholder="6245854132">
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

                    <td>Seleccionar</td>
                </tr>


            </table>
            <div class="modal fade" id="modal-proveedor" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-proveedor" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Registro tus datos
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3">
                            <label class="text-dark" for="proveedor-nombre-registro">Nombre comercial</label>
                            <input type="text" name="proveedor-nombre-registro" id="proveedor-nombre-registro" placeholder="ej: Mi empresa" disabled>
                            <label class="text-dark" for="proveedor-dni-registro">CIF</label>
                            <input type="text" name="proveedor-cif-registro" id="proveedor-cif-registro" placeholder="Y12345678X / 25148596D" disabled>
                            <label class="text-dark" for="proveedor-direccion-registro">Direccion</label>
                            <input type="text" name="proveedor-direccion-registro" id="proveedor-direccion-registro" placeholder="Calle Anton 14" disabled>
                            <label class="text-dark" for="proveedor-email-registro">Correo electronico</label>
                            <input type="email" name="proveedor-email-registro" id="proveedor-email-registro" placeholder="Mi_usuario@email.org" disabled>
                            <label class="text-dark" for="proveedor-telefono-registro">Telefono de contacto</label>
                            <input type="tel" name="proveedor-telefono-registro" id="proveedor-telefono-registro" placeholder="6245854132" disabled>
                            <label class="text-dark" for="proveedor-pcontacto-registro">Persona de contacto</label>
                            <input type="text" name="proveedor-pcontacto-registro" id="proveedor-pcontacto-registro" placeholder="Juan Manuel" disabled>

                            <button name="mofificar-proveedor" id="mofificar" >Modificar
                            </button>
                            <button name="dar-baja-proveedor" id="dar-baja-proveedor" data-bs-dismiss="modal">Dar baja </button>
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