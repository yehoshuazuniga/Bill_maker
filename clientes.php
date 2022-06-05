<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <h2 class="g2 text-center"> Clientes</h2>
    <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de clientes
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Alta cliente
            </li>
        </ul>
    </aside>

    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <div class="col-12 col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="cliente-nombre-registrar">Nombre </label>
            <input type="text" name="cliente-nombre-registrar" id="cliente-nombre-registrar" placeholder="ej: Mi empresa">
            <label for="cliente-cif-registrar">CIF</label>
            <input type="text" name="cliente-cif-registrar" id="cliente-cif-registrar" placeholder="G12345678">
            <label for="cliente-direccion-registrar">Direccion</label>
            <input type="text" name="cliente-direccion-registrar" id="cliente-direccion-registrar" placeholder="Calle Anton 14">
            <label for="cliente-email-registrar">Correo electronico</label>
            <input type="email" name="cliente-email-registrar" id="cliente-email-registrar" placeholder="Mi_usuario@email.org">
            <label for="cliente-personaContacto-registrar">Persona de contacto</label>
            <input type="text" name="cliente-personaContacto-registrar" id="cliente-personaContacto-registrar" placeholder="6245854132">
            <label for="cliente-telefono-registrar">Telefono de contacto</label>
            <input type="tel" name="cliente-telefono-registrar" id="cliente-telefono-registrar" placeholder="6245854132">
            <button name="registrar" id="registrar">Registrar </button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive" id="tabla-datos-pagina">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">
                    <td>CIF/NIF</td>
                    <td>Nombre de empresa</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>Seleccionar</td>
                </tr>

            </table>
            <div class="modal fade" id="modal-cliente" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-cliente" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Registro tus datos
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3">
                            <label class="text-dark" for="cliente-nombre-registro">Nombre comercial</label>
                            <input type="text" name="cliente-nombre-registro" id="cliente-nombre-registro" placeholder="ej: Mi empresa" disabled>
                            <label class="text-dark" for="cliente-dni-registro">CIF</label>
                            <input type="text" name="cliente-cif-registro" id="cliente-dni-registro" placeholder="Y12345678X / 25148596D" disabled>
                            <label class="text-dark" for="cliente-direccion-registro">Direccion</label>
                            <input type="text" name="cliente-direccion-registro" id="cliente-direccion-registro" placeholder="Calle Anton 14" disabled>
                            <label class="text-dark" for="cliente-email-registro">Correo electronico</label>
                            <input type="email" name="cliente-email-registro" id="cliente-email-registro" placeholder="Mi_usuario@email.org" disabled>
                            <label class="text-dark" for="cliente-telefono-registro">Telefono de contacto</label>
                            <input type="tel" name="cliente-telefono-registro" id="cliente-telefono-registro" placeholder="6245854132" disabled>
                            <button name="mofificar-cliente" id="mofificar">Modificar
                            </button>
                            <button name="dar-baja-cliente" id="dar-baja-cliente" data-bs-dismiss="modal">Dar baja
                            </button>
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