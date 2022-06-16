<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row   fondo_section  fondo_section">
    <h2 class=" text-center"> Facturas</h2>
    <div class="col row h-100 p-0 m-0 contenedor_vistas">
        <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
            <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0 position-sticky desplaSticky">
                <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                    Listado de facturas
                </li>
                <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                    Crear factura
                </li>
            </ul>
        </aside>
        <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
        <div class="col-md     ">
            <div id="registrar-vista" class="d-flex flex-column flex-md-row gap-2 pb-3 pt-4 align-items-start d-none row ">
                <div class="col-12 col-md-2">
                    <label for="doc-dni-registrar">CIF / NIF de cliente</label>
                    <input type="text" class="form-control" name="doc-dni-registrar" id="doc-dni-registrar" placeholder="ej: G123653214">
                </div>
                <div class="col-12 col-md border ficha-cliente" id="ficha-cliente">
                    <p class="cliente-cif">NIF cliente: </p>
                    <p class="cliente-nombre">Nombre: </p>
                    <p class="cliente-direccion">Direccion: </p>
                    <p class="cliente-email">E-mail: </p>
                    <p class="cliente-telefono">Telefono: </p>
                    <p class="cliente-contacto">Contacto: </p>
                </div>
                <div class="col-12 gap-2 d-flex flex-column clientes-servicios">
                    <!-- esto sera un desplegable con las opciones de los serviccios -->
                    <select id="servicios" class=" form-select" disabled>
                        <option value="" label=" "> </option>
                    </select>
                    <div class="bg-dark ">
                        <p id="total" class="d-none text-center fs-3 fw-bold position-sticky top-0 ">Total sin IVA <span id="precio">0</span> € </p>
                        <hr class="d-none order-1" />
                        <div class="clientes-servicios-resumen resumen_altoMax" id="resumen_servicios">

                        </div>
                    </div>
                </div>
                <button name="registrar" id="registrar" disabled>Generar Factura</button>
            </div>
            <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
            <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
            <div id="lista-vista" class="d-flex flex-column table-responsive ">
                <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                    <tr class="table-dark ">
                        <td>Cod Factura</td>
                        <td>Cod Presupuesto</td>
                        <td>Precio sin IVA</td>
                        <td>Precio con IVA</td>
                        <td>Estado</td>
                        <td>Seleccionar</td>
                    </tr>
                </table>
                <!-- actualizar modal con lod datos de la factura y sus serviucios+2 -->

                <div class="modal fade" id="modal-factura" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title text-black">
                                    Datos factura
                                </h3>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id=cerrar-modal></button>
                            </div>
                            <div id="modal-body" class="modal-body row m-3 bg-dark">
                                <div class="col-12 col-md border ficha-cliente-factura- sticky-top bg-dark">
                                    <p class="fw-bold dato-factura">CIF: <span class="fw-ligth"></span></p>
                                    <p class="fw-bold dato-factura">Nombre: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Factura: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Presupuesto: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Direccion: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Email: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Telefono: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Contacto: <span class="fw-ligth"></span> </p>
                                    <p class="fw-bold dato-factura">Fecha Creacion: <span class="fw-ligth"></span> </p>
                                </div>
                                <div class="clientes-servicios-resumen-factura bg-dark  border my-1 d-flex justify-content-around">
                                    <p class="fw-bold">Precio total</p>
                                    <p class="dato-factura"> <span class="fw-ligth"></span> €</p>

                                </div>
                                <button name="factura-pdf" id="generar-pdf" value="">Generar PDF
                                </button>
                                <button name="rectificado" id="factura-rectificativa">Factura rectificativa
                                </button>
                            </div>
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