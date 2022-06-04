<?php require './php/appElementos.php';
app::llamarLayout('header');
?>
<section class="row bg-primary">
    <aside class="col col-lg-auto pe-4 col-12 " id="funcionesPagina">
        <ul class="nav d-flex flex-lg-column flex-row justify-content-around pe-md-5 pe-0">
            <li class="mb-lg-5 mb-0 btn listarClientes" id="panelLista">
                Listado de presupuestos
            </li>
            <li class="mb-lg-5 mb-0 btn registrarCliente" id="panelParaRegistro">
                Crear presupuesto
            </li>
        </ul>
    </aside>
    <!-- esta es la pestñana que aparecera cuando se registra un nuevo cliente -->
    <main class=" col-md bg-info ">
        <div id="registrar-vista" class="d-flex flex-column flex-md-row gap-2 pb-3 align-items-center d-none row">
            <div class="col-12 col-md-2">
                <label for="presupuesto-nombre-registrar">CIF / NIF de cliente</label>
                <input type="text" class="form-control" name="presupuesto-nombre-registrar" id="presupuesto-nombre-registrar" placeholder="ej: G123653214">
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
                <label for="presupuesto-codigo-registrar">Codigo presupuesto</label>
                <input type="text" class="form-control" name="presupuesto-codigo-registrar" id="presupuesto-codigo-registrar" placeholder="ej: MS542" disabled>
                <!-- esto sera un desplegable con las opciones de los serviccios -->
                <select>
                    <option value="proveedor1"> servicios 1</option>
                    <option value="proveedor1"> servicios 1</option>
                    <option value="proveedor1"> servicios 1</option>
                </select>servicios
                <div class="clientes-servicios-resumen bg-dark">
                    <p class="servicio">datos del Servicio</p>
                    <input type="hidden" name="idservicio" id="idServici">
                    <!-- parrafo en ibput se generan juntos  simepre -->
                </div>
            </div>
            <button name="registrar" id="registrar">Generar
                Presupuesto</button>
        </div>
        <!-- ENCONTRAR LA FORMA DE ENVIAR UN CONTRASEÑA POR MAIL O HACERLO QUE AL INICIAR SECION CAMBIE LA CONTRASEÑA-->
        <!-- esto se sera una lista interactiva que se rellenara automaticamente cuando con js  con unos registro que obtendra de php-DDBB -->
        <div id="lista-vista" class="d-flex flex-column table-responsive">
            <table class="table  table-hover table-sm" id="tabla-datos-pagina">
                <tr class="table-dark">

                    <!-- rellenar con  -->
                    <td>Cod Presupuesto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                    <td>Seleccionar</td>
                </tr>
                <tr>
                    <td>Cod Presupuesto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                    <td><button name="servicio-id-numeroid" id="id-3" data-bs-toggle="modal" data-bs-target="#modal-servicio">Seleccionar</button> (boton que seleciona el servicio)
                    </td>
                </tr>
                <tr>
                    <td>Cod Presupuesto</td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                    <td><button name="servicio-id-numeroid" id="id-3" data-bs-toggle="modal" data-bs-target="#modal-servicio">Seleccionar</button> (boton que seleciona el servicio)
                    </td>
                </tr>
                <tr>
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
                                Datos presupuesto
                            </h3>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div id="modal-body" class="modal-body row m-3 bg-dark">
                            <div class="col-12 col-md border ficha-cliente-presupuesto sticky-top bg-dark">
                                <p class="cliente-cif">nif cliente</p>
                                <p class="cliente-nombre">Nombre</p>
                                <p class="cliente-direccion">direccion</p>
                                <p class="cliente-email">email</p>
                                <p class="cliente-telefono">telefono</p>
                                <p class="cliente-contacto">contacto</p>
                            </div>
                            <!-- arreglar el proble del scroll en top -->
                            <div class="clientes-servicios-resumen-presupuesto bg-dark overflow-scroll">
                                <p class="servicio">datos del Servicio</p>

                                <input type="hidden" name="idservicio" id="idServici">
                                <!-- parrafo en ibput se generan juntos  simepre -->
                            </div>
                            <button name="presupuesto-pdf" id="presupuesto-pdf" data-bs-dismiss="modal">Generar PDF
                            </button>
                            <button name="presupuesto-aprobar" id="presupuesto-aprobar" data-bs-dismiss="modal">Aprobar presupuesto
                            </button>
                            <button name="presupuesto-cancelar" id="presupuesto-cancelar" data-bs-dismiss="modal">Cancelar presupuesto
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