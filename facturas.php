<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de facturas
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Crear factura
            </li>
        </ul>
    </aside>
    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <main class="col-md bg-info">
        <div id="registrar-vista" class="d-flex flex-column flex-md-row d-none gap-2 
        pb-3 align-items-center row">
            <div class="col-12 col-md-2">
                <label for="factura-nombre-registrar">CIF / NIF de cliente</label>
                <input type="text" class="form-control" name="factura-nombre-registrar" id="factura-nombre-registrar" placeholder="ej: G123653214">
            </div>
            <div class="col-12 col-md border ficha-cliente">
                <p class="cliente-cif">nif cliente</p>
                <p class="cliente-nombre">Nombre</p>
                <p class="cliente-direccion">direccion</p>
                <p class="cliente-email">email</p>
                <p class="cliente-telefono">telefono</p>
                <p class="cliente-contacto">contacto</p>
            </div>
            <div class="col-12 gap-2 d-flex flex-column clientes-servicios">
                <label for="factura-codigo-registrar">Codigo factura</label>
                <input type="text" class="form-control" name="factura-codigo-registrar" id="factura-codigo-registrar" placeholder="ej: MS542" disabled>
                <select>
                    <option value="Servicio 1"> Servicio 1</option>
                    <option value="Servicio 1"> Servicio 1</option>
                    <option value="Servicio 1"> Servicio 1</option>
                </select>
                <div class="clientes-servicios-resumen bg-dark">
                    <p class="servicio">datos del Servicio</p>
                    <input type="hidden" name="idservicio" id="idServici">
                    <!-- parrafo en ibput se generan juntos  simepre -->
                </div>
            </div>
            <button name="registrar" id="registrar">Generar Factura</button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">

                    <!-- rellenar con  -->
                    <td>Cod Factura</td>
                    <td>Cod Presupuesto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                    <td>Seleccionar</td>
                </tr>

                <tr>
                    <td>Cod Factura</td>
                    <td>Cod Presupuesto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>

                    <td><button name="servicio-id-numeroid" id="id-3" data-bs-toggle="modal" data-bs-target="#modal-servicio">Seleccionar</button> (boton que seleciona el servicio)
                    </td>
                </tr>
            </table>

            <!-- actualizar modal con lod datos de la factura y sus serviucios+2 -->

            <div class="modal fade" id="modal-servicio" tabindex="-1" aria-hidden="true" aria-labelledby="label-modal-servicio" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                Datos factura
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3 bg-dark">
                            <div class="col-12 col-md border ficha-cliente-factura sticky-top bg-dark">
                                <p class="cliente-cif">nif cliente</p>
                                <p class="cliente-nombre">Nombre</p>
                                <p class="cliente-direccion">direccion</p>
                                <p class="cliente-email">email</p>
                                <p class="cliente-telefono">telefono</p>
                                <p class="cliente-contacto">contacto</p>
                            </div>
                            <!-- arreglar el proble del scroll en top -->
                            <div class="clientes-servicios-resumen-factura bg-dark  border my-1 d-flex justify-content-between">
                                <p class="servicio">Datos del Servicio</p>

                                <input type="hidden" name="idservicio" id="idServici">
                                <!-- parrafo en ibput se generan juntos  simepre -->
                            </div>
                            <div class="clientes-servicios-resumen-factura bg-dark  border my-1 d-flex justify-content-between">
                                <p class="servicio">Precio total</p>


                            </div>
                            <button name="factura-pdf" id="factura-pdf" data-bs-dismiss="modal">Generar PDF
                            </button>
                            <button name="factura-rectificativa" id="factura-rectificativa" data-bs-dismiss="modal">Factura rectificatica
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</section>
</body>
<?php
app::llamarLayout('footer');
?>