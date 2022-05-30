<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <aside class="col col-lg-auto pe-4 col-12 "  id="funcionesPagina">
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
    <main class=" col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column d-none gap-2 pb-3">
            <label for="servicio-nombre-registrar">Nombre del servicio </label>
            <input type="text" name="servicio-nombre-registrar" id="servicio-nombre-registrar" placeholder="ej: Mi servicio">
            <label for="servicio-codigo-registrar">Codifo servicio</label>
            <input type="text" name="servicio-codigo-registrar" id="servicio-codigo-registrar" placeholder="ej: MS542">
            <label for="servicio-descripcion-registrar">Descripción</label>
            <input type="text" name="servicio-descripcion-registrar" id="servicio-descripcion-registrar" placeholder=" Descripcion del servicio">
            <label for="servicio-precioSinIva-registrar">Precio sin IVA</label>
            <input type="decimal" step="any" name="servicio-precioSinIva-registrar" id="servicio-precioSinIva-registrar" placeholder="15.55">
            <label for="servicio-precioConIva-registrar">Precio con IVA</label>
            <input type="number" name="servicio-precioConIva-registrar" id="servicio-precioConIva-registrar" placeholder="17.49">
            <label for="servicio-productoExterno-registrar">Es un productos externo?</label>
            <input type="checkbox" name="servicio-productoExterno-registrar" id="servicio-productoExterno-registrar">
            <label for="servicio-codigoProductoExterno-registrar">Codigo del producto externo</label>
            <input type="text" maxlength="7" class="servicio-codigoProductoExterno-registrar" id="servicio-codigoProductoExterno-registrar">
            <button name="registrar-servicio" id="registrar-servicio" data-bs-dismiss="modal">Registrar
                servicio</button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive">
            <table class="table  table-hover table-sm">
                <tr class="table-dark">
                    <td>Cod Servicio</td>
                    <td>Servicio/Producto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                    <td>es externo? (introducr un si/no)</td>
                    <td>es externo? (introducr un si/no)</td>
                    <td>Seleccionar</td>
                </tr>
                <tr>
                    <td>serv12345</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>es externo? (introducr un si/no)</td>
                    <td>cod producto externo</td>
                    <td><button name="servicio-id-numeroid" id="id-1">Seleccionar</button> (boton que seleciona el servicio) </td>
                </tr>
                <tr>
                    <td>serv12345</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>es externo? (introducr un si/no)</td>
                    <td>cod producto externo</td>
                    <td><button name="servicio-id-numeroid" id="id-2">Seleccionar</button> (boton que seleciona el servicio) </td>
                </tr>
                <tr>
                    <td>serv12345</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>es externo? (introducr un si/no)</td>
                    <td>cod producto externo</td>
                    <td><button name="servicio-id-numeroid" id="id-3" data-bs-toggle="modal" data-bs-target="#modal-servicio">Seleccionar</button> (boton que seleciona el servicio)
                    </td>
                </tr>
            </table>
            <div class="modal fade" id="modal-servicio" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-servicio" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Registro tus datos
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body row m-3">
                            <label class="text-dark" for="servicio-nombre-registro">Servicio</label>
                            <input type="text" name="servicio-nombre-registro" id="servicio-nombre-registro" placeholder="ej: Mi empresa">
                            <label class="text-dark" for="servicio-codigo-registro">Cod. Servicio</label>
                            <input type="text" name="servicio-codigo-registro" id="servicio-codigo-registro" placeholder="SERV123">
                            <label class="text-dark" for="servicio-descripcion-registro">Direccion</label>
                            <input type="text" name="servicio-descripcion-registro" id="servicio-descripcion-registro" placeholder="descripcion del servicio">
                            <label class="text-dark" for="servicio-precioSinIva-registro">Precio sin IVA</label>
                            <input type="decimal" step="any" name="servicio-precioSinIva-registro" id="servicio-precioSinIva-registro" placeholder="15.55">
                            <label class="text-dark" for="servicio-precioConIva-registro">Precio con IVA</label>
                            <input type="number" name="servicio-precioConIva-registro" id="servicio-precioConIva-registro" placeholder="17.49">
                            <label class="text-dark" for="servicio-productoExterno-registro">Es un productos
                                externo?</label>
                            <input type="checkbox" name="servicio-productoExterno-registrar" id="servicio-productoExterno-registrar">
                            <label class="text-dark" for="servicio-codigoProductoExterno-registrar">Codigo del
                                producto externo</label>
                            <input type="text" maxlength="7" class="servicio-codigoProductoExterno-registrar" id="servicio-codigoProductoExterno-registrar">
                            <button name="mofificar-servicio" id="mofificar-servicio" data-bs-dismiss="modal">Moficar
                            </button>
                            <button name="dar-baja-servicio" id="dar-baja-servicio" data-bs-dismiss="modal">Dar baja
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</section>
</body>
<script src="./js/bootstrap_js/bootstrap.bundle.min.js"></script>
<script src="./js/app/app.js"></script>

</html>