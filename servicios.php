<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <h2 class="g2 text-center"> Servicios</h2>
    <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de servicios
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Crear servicio
            </li>
        </ul>
    </aside>

    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <div class="col-12 col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="nombre">Nombre del servicio </label>
            <input type="text" name="nombre" id="nombre" placeholder="ej: Mi servicio">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" placeholder=" Descripcion del servicio">
            <label for="precio">Precio sin IVA</label>
            <input type="decimal" step="any" name="precio" id="precio" placeholder="15.55">
            <label for="productos_externos">Es un productos externo?</label>
            <input type="checkbox" name="idProducto" id="productos_externos">
            <select id="select_proveedores" class="form-select align-self-end mb-3 d-none">
            </select>
            <button name="registrar" id="registrar">Registrar servicio</button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">
                    <td>Cod Servicio</td>
                    <td>Servicio/Producto</td>
                    <td>Descripcion</td>
                    <td>es externo?</td>
                    <td>Precio sin IVA</td>
                    <td>Estado</td>
                    <td>Seleccionar</td>
                </tr>

            </table>
            <div class="modal fade" id="modal-servicio" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-servicio" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Registro tus datos
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3">
                            <label class="text-dark" for="servicio-nombre-registro">Servicio</label>
                            <input type="text" name="servicio-nombre-registro" id="servicio-nombre-registro" placeholder="ej: Mi Servicio" disabled>
                            <label class="text-dark" for="servicio-codigo-registro">Cod. Servicio</label>
                            <input type="text" name="servicio-codigo-registro" id="servicio-codigo-registro" placeholder="SERV123" disabled>
                            <label class="text-dark" for="servicio-descripcion-registro">Direccion</label>
                            <input type="text" name="servicio-descripcion-registro" id="servicio-descripcion-registro" placeholder="descripcion del servicio" disabled>
                            <label class="text-dark" for="servicio-precioSinIva-registro">Precio sin IVA</label>
                            <input type="decimal" step="any" name="servicio-precioSinIva-registro" id="servicio-precioSinIva-registro" placeholder="15.55" disabled>
                            <label class="text-dark" for="servicio-precioConIva-registro">Precio con IVA</label>
                            <input type="number" name="servicio-precioConIva-registro" id="servicio-precioConIva-registro" placeholder="17.49" disabled>
                            <label class="text-dark" for="servicio-productoExterno-registro">Es un productos
                                externo?</label>
                            <input type="checkbox" name="servicio-productoExterno-registrar" id="servicio-productoExterno-registrar" disabled>
                            <label class="text-dark" for="servicio-codigoProductoExterno-registrar">Codigo del
                                producto externo</label>
                            <input type="text" maxlength="7" class="servicio-codigoProductoExterno-registrar" id="servicio-codigoProductoExterno-registrar" disabled>

                            <div class="form-check">
                                <label for="activo" class="form-check-label text-dark">Servicio activo</label>
                                <input type="radio" class="form-check-input" name="estado" id="activo" disabled>
                            </div>
                            <div class="form-check">
                                <label for="inactivo" class="form-check-label text-dark">Servicio inactivo</label>
                                <input type="radio" class="form-check-input" name="estado" id="inactivo" disabled>
                            </div>
                            <button name="mofificar-cliente" id="mofificar">Modificar</button>
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