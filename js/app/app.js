document.addEventListener('readystatechange', cargarEventos, false);

function cargarEventos() {
    if (document.readyState === 'interactive') {
        tituloAutomatico();
        if (!!document.getElementById('formulario_registrar')) {
            document.getElementById('registrar').addEventListener('click', registroUsuario, false);
        }
        if (!!document.getElementById('envio')) {
            document.getElementById('envio').addEventListener('click', busquedaSocio, false);
        }
        if (!!document.getElementById('cerrarSesion')) {
            document.getElementById('cerrarSesion').addEventListener('click', cerrarsesion, false);
        }
        if (!!document.getElementById('funcionesPagina')) {
            //generarListas
            document.getElementById('panelLista').addEventListener('click', panelListaClientes, false);
            document.getElementById('panelParaRegistro').addEventListener('click', panelRegistrarClientes, false);
        }
        if (!!document.getElementById('registrar-vista')) {
            document.getElementsByTagName('button')['registrar'].addEventListener('click', registrarCEFPS, false);
        }
        if (!!document.getElementById('productos_externos')) {
            document.getElementById('productos_externos').addEventListener('change', llamarProveedoresServ, false);
        }

        if (!!document.getElementById('select_proveedores')) {
            document.getElementById('select_proveedores').addEventListener('change', productoExternoSeleccionado, true)
        }
        if (!!document.getElementById('lista-vista')) {
            crearLIstas();
        }
        if (!!document.getElementById('mofificar')) {
            document.getElementById('mofificar').addEventListener('click', desbloquearInputs, true);

        } // eventos pequeños
        if (!!document.getElementById('cerrar-modal')) {
            document.getElementById('cerrar-modal').addEventListener('click', bloquearInputs, true);

        } // eventos pequeños
        //   document.getElementById('logo').addEventListener('click', compo, true);
    }
}

function prueba() {
    alert('e.target.value');
}

//crea un objeto html 

function crearObjHtml(elemento, arrayAtributoValor) {
    obj = document.createElement(elemento);
    for (const key in arrayAtributoValor) {
        obj.setAttribute(key, arrayAtributoValor[key]);
    }
    return obj;
}


// devuelve el nombre de la pagina de donde estas

function localizarDondeEstoy() {
    str = window.document.location.href
    var mySubString = str.substring(
        str.indexOf("r/") + 2,
        str.lastIndexOf(".")
    );

    if (mySubString == 'index') {
        mySubString = 'Bill maker'
    }
    return (mySubString);
}

function tituloAutomatico() {
    let nombre = localizarDondeEstoy();
    nombre = (nombre.substring(0, 1)).toUpperCase() + "" + nombre.substring(1, nombre.length);

    document.title = nombre;
}
//estas funcion se puede elimiar  solo es para probar
function compo() {
    alert('funciono');
    const varPOST = 'compo';
    let datosEnvioServ = JSON.stringify(true);
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            alert(objInfo);

        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varPOST + '=' + datosEnvioServ);
}
//funcion que mestra los paneles de listar de la pagina
function panelListaClientes() {
    panelListas = document.getElementById('lista-vista');
    panelRegistro = document.getElementById('registrar-vista');
    if (panelListas.classList.contains('d-none')) {
        if (!panelRegistro.classList.contains('d-none')) {
            panelRegistro.classList.add('d-none');
        }
        panelListas.classList.remove('d-none');

    }

}
//funciones que muestran los paneles de alta o registar
function panelRegistrarClientes() {
    panelListas = document.getElementById('lista-vista');
    panelRegistro = document.getElementById('registrar-vista');
    if (panelRegistro.classList.contains('d-none')) {
        if (!panelListas.classList.contains('d-none')) {
            panelListas.classList.add('d-none');
        }
        panelRegistro.classList.remove('d-none');

    }
}
//pasamos objeto DOM  wn gtupos don
//devuelve un array {} asociatico (id=>valor)

//funciones genericas para todas las paginas

// se simplifica nombres largospar mail y codigos
function nombreLargo(empresaNombre) {
    let nombreSeparado = []
    let cod = '';
    nombreSeparado = empresaNombre.split(' ');
    if (nombreSeparado.length != 1) {
        for (let i = 0; i < nombreSeparado.length; i++) {
            if (nombreSeparado[i].length >= 3) {
                cod += nombreSeparado[i].substring(0, 1);
            }
        }
    } else {
        cod = empresaNombre;
    }
    return (cod.substring(0, 2).toUpperCase());
}
// simplifica nombres cortos  para mail y codigos
function nombreCorto(empresaNombre) {
    let nombre = '';
    if (empresaNombre.includes(' ')) {
        nombre = empresaNombre.replace(' ', '-')
    } else {
        nombre = empresaNombre.substring(0, 2).toUpperCase();
    }
    return (nombre);
}
// crea un mail para el usuario
function crearEmail(empresaNombre, cargo, nombre, apellido) {
    const arroba = '@';
    let email = '';
    let roll = '';
    let dominio = '';
    nombreSeparado = empresaNombre.split(' ');
    // alert(empresaNombre + " " + +nombreSeparado.length + " " + nombreSeparado[0])
    if (nombreSeparado.length > 2) {
        dominio = nombreLargo(empresaNombre);
    } else {
        dominio = nombreCorto(empresaNombre);
    }

    if (cargo === 'gerente') {
        roll = 'GT';
    } else {
        if (cargo === 'empleado') {
            roll = 'EP';
        }
    }
    email = nombre + '.' + apellido + '_' + roll + arroba + dominio + '.com';

    return (email.toLocaleLowerCase())
}
// crea id para empleado servicio gerente, falta agregar un metodo qpara que no cree 2 iguales , revisara en bbdd   
function crearId(empresaNombre, cargo) {
    roll = '';
    let cod = nombreLargo(empresaNombre);
    switch (cargo) {
        case 'gerente':
            roll = 'gt';
            break;
        case 'empleado':
            roll = 'ed';
            break;
        case 'servicio':
            roll = 'sc';
            break;
    }

    nRand = (Math.floor((Math.random() * 899)))
    nRand = String(nRand)
    if (String(nRand).length == 1) {
        nRand = '0' + String(nRand) + "";
    }
    if (nRand.length == 2) {
        nRand = '0' + String(nRand) + "";
    }
    return ((cod + roll + nRand).toUpperCase());
    //agreagar un proceso que busque en la base de datos un id igual
    //si existe hay que hacerlo de nuevos
}
//recopila valores de donde se apunte, se pasa la direccion dom lo los que hay q extraer datos para el servidor
function obtenerValores(grupo) {
    let idValue = {};
    for (const indi of grupo) {
        idValue[indi.id] = indi.value
    }

    return idValue
}
// crea estructurar dom, no funciona
function crearMensajesDom(mensaje) {

    //esto hay que mejorarlo
    document.getElementsByTagName('button')[1].appendChild(document.createElement('p').appendChild(document.createTextNode('ljdnjsn')))
    "ljdnjsn"
}
// para estructuras que se quiera solo un momento   
function setTimeOut(funcName, retraso) {
    const timer = setTimeOut(funcName + "()", parseInt(retraso))
}

//cambia locaclizacion
function cambiaLoc(localizacion) {
    window.location.href = localizacion;
}
//para formulario de registro
//resalta en rojo lo invalido
function invalido(elemento) {

    elemento.classList.add('is-invalid');
}
//resalta en verde lo valido
function valido(elemento) {
    elemento.classList.add('is-valid');

}
//comprueba dni
function validarDniCif(dni) {
    var expre = new RegExp("^[0-9]{7,8}[a-hA-H]{1}$|^[a-zA-Z]{1}[0-9]{7,8}$")
    respuesta = null;
    expre.test(dni) ? respuesta = true :
        respuesta = false;
    return respuesta;
}
//comprueba email
function validarEmail(email) {
    var expre = new RegExp("^[-_.a-zA-Z0-9]{5,25}@[-_.a-zA-Z]{3,25}\.[a-z]{2,3}$")
    respuesta = null;
    expre.test(email) ? respuesta = true :
        respuesta = false;

    return respuesta;

}

//funciones de pagina html index

function comprobarCamposRegistroUsuario(inputForm) {
    let apto = false;
    let input0 = false;
    let input1 = false;
    let input3 = false;
    let input6 = false;
    if (inputForm[0].value === '') {
        invalido(inputForm[0])
    } else {
        valido(inputForm[0])
        input0 = true;
    }

    if (validarDniCif(inputForm[1].value)) {
        valido(inputForm[1])
        input1 = true;
    } else {
        invalido(inputForm[1]);
    }

    inputForm[2].value === '' ? invalido(inputForm[2]) : valido(inputForm[2]);

    if (validarEmail(inputForm[3].value)) {
        valido(inputForm[3]);
        input3 = true;
    } else {
        invalido(inputForm[3]);

    }

    inputForm[4].value === '' ? invalido(inputForm[4]) : valido(inputForm[4]);
    inputForm[5].value === '' ? invalido(inputForm[5]) : valido(inputForm[5]);

    if (!!inputForm[6]) {
        if (inputForm[6].value === '') {
            invalido(inputForm[6])

        } else {
            valido(inputForm[6])
            input6 = true;
        }
    }
    if (input0 && input1 && input3 && input6) {
        apto = true;
    }

    return apto;
}
// envia usuario y pass al servidor para verificar si existe
function validacionusuario(varPOST, datos) {
    let loc = './inicio.php';
    let datosEnvioServ = JSON.stringify(datos);
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            // alert(objInfo);
            if (typeof objInfo === "boolean") {
                if (objInfo) {
                    cambiaLoc(loc);
                } else {
                    alert('usuario o contraseña incorrecta')
                    let divRegistro = document.getElementsByName('usuario_np');
                    for (const ind of divRegistro) {
                        ind.value = '';
                    }
                }
            }
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varPOST + '=' + datosEnvioServ);
}
//funcion  para acceder de usuarios que ya tiene cuenta
//solo se acceder con mail y passwor que a esten registradas
function busquedaSocio() {

    const varPOST = 'accesousuario';
    let divRegistro = document.getElementsByName('usuario_np');
    let datosEnvioServ = {};
    let extDatosEnvioServ = 0;
    // este for se puede sustiruir por obtenerValores
    for (const input of divRegistro) {
        if (input.value != null && input.value != '') {
            datosEnvioServ[input.id] = input.value;
            extDatosEnvioServ++;
        }
    }
    if (extDatosEnvioServ === 2) {
        validacionusuario(varPOST, datosEnvioServ);
    }

    //alert(JSON.stringify(datosEnvioServ));
    //return (JSON.stringify(datosEnvioServ))
}

//funcion para requistrar el usuario en la base de datos cuando se dat de alta la bbdd
function registroUsuario() {

    let inputForm = document.getElementById('formulario_registrar').getElementsByTagName('input');
    let datosEnvioServ = {};

    if (comprobarCamposRegistroUsuario(inputForm)) {
        const empleado = 'empleado';
        const gerente = 'gerente';
        let datosDeEnt = obtenerValores(inputForm);
        let nombreApellido = inputForm[5].value.split(' ');
        datosDeEnt['idGerente'] = crearId(inputForm[0].value, gerente);
        datosDeEnt['idEmpleado'] = crearId(inputForm[0].value, empleado);
        datosDeEnt['usuarioGerente'] = crearEmail(inputForm[0].value, gerente, nombreApellido[0], nombreApellido[1]);
        datosDeEnt['usuarioEmpleado'] = crearEmail(inputForm[0].value, empleado, nombreApellido[0], nombreApellido[1]);
        //
        //envio info al servidor
        //
        const varPOST = 'nuevoUsuario';
        let loc = './index.php';
        //creaando id gerente 

        //esto hay que eliminarlo
        count = 0;
        for (const key in datosDeEnt) {
            if (Object.hasOwnProperty.call(datosDeEnt, key)) {
                const element = datosDeEnt[key];
                count++;
            }
        }
        //hasta aqui

        datosEnvioServ = JSON.stringify(datosDeEnt);
        alert(datosEnvioServ + ' <br> ' + count)
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const objInfo = JSON.parse(this.responseText);
                alert(objInfo[0]);
                if (!objInfo[1]) {
                    cambiaLoc(loc);
                }
                //intentar inluir modales a cambio de alerts
                //si devuelve true  salta aiso de que la empresa ya esta registrada 
                // si devuelve false salta aviso de que la empresa se esta registrando ahora mismo
                /* if (typeof objInfo === "boolean") {
                    if (objInfo) {
                        cambiaLoc(loc);
                    } else {
                        alert('usuario o contraseña incorrecta')
                        let divRegistro = document.getElementsByName('usuario_np');
                        for (const ind of divRegistro) {
                            ind.value = '';
                        }
                    }
                } */
            }
        }
        xhttp.open('POST', './php/appFunciones.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(varPOST + '=' + datosEnvioServ);
        //
        //fin de funcion de envio al servidor
        //
    } else {
        alert('revisa los datos');
    }
}
// fin de funiones de la pagina index


//funciones de resto de paginas
//funciones paginas interiores


function cerrarsesion() {
    let loc = './index.php';
    const varPOST = 'cerrarSesion';
    let datosEnvioServ = JSON.stringify(true);
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            alert(objInfo[0]);
            if (objInfo[1]) {
                cambiaLoc(loc);
            }
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varPOST + '=' + datosEnvioServ);
}


//funcion para obtener registarr servicio
//fatla funcion ue lo envie al servidor y lo registre

function registrarCEFPS() {
    let locDeDatos = document.getElementById('registrar-vista').getElementsByTagName('input')
    let empresa = document.getElementById('miEmpresa');
    let datosEnt = obtenerValores(locDeDatos);
    if (localizarDondeEstoy() === 'empleados') {
        apellido = datosEnt['nombre'].split(' ');
        datosEnt['nombre'] = apellido[0];
        if (typeof apellido[1] === 'undefined' || apellido[1] === '') {
            datosEnt['apellido'] = 'undefined';
        } else {
            datosEnt['apellido'] = apellido[1]
        }
        datosEnt['idGerente'] = empresa.name;
        datosEnt['idEmpleado'] = crearId(empresa.value, 'empleado');
        datosEnt['usuario'] = crearEmail(empresa.value, 'empleado', datosEnt['nombre'], datosEnt['apellido']);

        console.log(JSON.stringify(datosEnt));
    }
    if (localizarDondeEstoy() === 'servicios') {
        datosEnt['idServicios'] = crearId(empresa.value, 'servicio');
    }
    let packEnvioServ = JSON.stringify([localizarDondeEstoy(), JSON.stringify(datosEnt)]);
    let varServ = 'registrar';

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            // alert(typeof objInfo)
            if (typeof objInfo == 'boolean' || objInfo == 'true' || objInfo == 'false') {
                if (objInfo || objInfo == 'true') {
                    alert(localizarDondeEstoy() + ' registrado');
                    cambiaLoc('./' + locDeDatos + '.php')
                } else {
                    alert(localizarDondeEstoy() + ' no registrado');
                }
            } else {
                alert(objInfo);
            }
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varServ + '=' + packEnvioServ);

}
//llamar a proveedores del servidor

//funcio publicar proveedores
function mostrarProveedores(datosDelServ) {
    packProveedores = datosDelServ;
    // alert(JSON.stringify(packProveedores))
    checkbox = document.getElementById('productos_externos')
    select = document.getElementById('select_proveedores');
    if (select.classList.contains('d-none') && checkbox.checked) {
        select.classList.remove('d-none');
        for (let i = 0; i < packProveedores.length; i++) {
            proveedor = packProveedores[i];
            option = document.createElement('option');
            texto = document.createTextNode(proveedor['nombre']);
            option.setAttribute('value', proveedor['idProducto']);
            option.appendChild(texto);
            select.appendChild(option);
        }
        //ponesmos un escuchador a los option creados
        /*  if (document.getElementsByTagName('option').length > 0) {
             opt = document.getElementsByTagName('option');
             alert('las ve')
             for (let i = 0; i < opt.length; i++) {
                 opt[i].addEventListener('click', prueba, true);
             }
         } */
    } else {
        while (select.hasChildNodes()) {
            select.removeChild(select.lastChild);
        }
        select.classList.add('d-none')

    }
}

function llamarProveedoresServ() {
    let varPOST = 'proveedorProExt';
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            mostrarProveedores(objInfo);
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varPOST);
}
// cre un imput text pcuando se confirme el proveedor
function imputCodProExt() {
    btn = document.getElementById('registrar');
    contenedor = document.getElementById('registrar-vista');

    label = document.createElement('label');
    textoLabel = document.createTextNode('Codigo del producto externo');
    label.setAttribute('for', 'servicio-codigoProductoExterno-registrar');
    label.appendChild(textoLabel);

    inputText = document.createElement('input');
    inputText.setAttribute('type', 'text');
    inputText.setAttribute('maxlength', '7');
    inputText.setAttribute('id', 'servicio-codigoProductoExterno-registrar');

    contenedor.insertBefore(label, btn);
    contenedor.insertBefore(inputText, btn);

    //< label for= "servicio-codigoProductoExterno-registrar" > Codigo del producto externo</label >
    //  <input type="text" maxlength="7" class="servicio-codigoProductoExterno-registrar" id="servicio-codigoProductoExterno-registrar" disabled>


}

//regsitra el dni del proveedor en un input hidden
function productoExternoSeleccionado(e) {
    select = document.getElementById('select_proveedores');
    idProducto = e.target.value;
    atributos = { 'type': 'hidden', 'value': idProducto, 'id': 'idProducto' };
    if (document.getElementById('idProducto') === null) {
        objetoHTML = crearObjHtml('input', atributos);
        select.appendChild(objetoHTML);
    } else {
        document.getElementById('idProducto').value = idProducto;
    }

    //imputCodProExt();
}

function tablaListaClientes(datos) {

    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        fila = `<tr>
                    <td>${element['dni']}</td>
                    <td>${element['nombreEmpresa']}</td>
                    <td>${element['telefono'] == null ? '- - - - - -' : element['telefono']}</td>
                    <td>${element['email']}</td>
                    <td>
                        <button name="botones-lista" id="${element['dni']}" data-bs-toggle="modal" data-bs-target="#modal-cliente">Seleccionar</button>

                    </td>
                </tr>`;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }

}

function tablaListaEmpleados(datos) {

    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        nombre = (element['nombre'].substring(0, 1)).toLocaleLowerCase() + '' + element['nombre'].substring(1, element['nombre'].length);
        apellido = ((element['apellido']).substring(0, 1)).toLocaleLowerCase() + '' + (element['apellido']).substring(1, element['apellido'].length);

        fila = `<tr>
                    <td>${element['idEmpleado']}</td>
                    <td> ${nombre} ${apellido}</td>
                    <td>${element['telefono'] == null ? '- - - - - -' : element['telefono']}</td>
                    <td>${element['email']}</td>
                    <td>
                        <button name="botones-lista" id="${element['dni']}" data-bs-toggle="modal" data-bs-target="#modal-empleado">Seleccionar</button>

                    </td>
                </tr>`;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }
}

function tablaListaFacturas(datos) {

    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        fila = `<tr>
                    <td>${element['idFacturas']}</td>
                    <td>${element['idPresupuesto'] == null ? '' : element['idPresupuesto']}</td>
                    <td>${element['precioTotalSinIva']} €</td>
                    <td>${parseInt(element['precioTotalSinIva']) * 1.21} €</td>

                    <td>
                       <button name="botones-lista"  id="${element['idFacturas']}" data-bs-toggle="modal" data-bs-target="#modal-factura">Seleccionar</button>
                    </td>
                </tr>
                `;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }

}

function tablaListaPresupuestos(datos) {

    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        fila = `<tr>
                    <td>${element['idPresupuesto']}</td>
                    <td>${element['precio']} €</td>
                    <td>${parseInt((element['precio'] * 1.21))} €</td>
                    <td>
                        <button name="botones-lista" id="${element['idPresupuesto']}" data-bs-toggle="modal" data-bs-target="#modal-presupuesto">Seleccionar</button>
                    </td>
                </tr>`;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }

}

//crea la tabla de los proveedores con eventos
function tablaListaProveedores(datos) {
    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        fila = `<tr>
                <td>NIF ${element['dni']}</td>
                <td>${element['nombre']}</td>
                <td>${element['telefono']}</td>
                <td>${element['email']}</td>
                <td>
                     <button name="botones-lista" id="${element['dni']}" data-bs-toggle="modal" data-bs-target="#modal-proveedor">Seleccionar</button>
                </td>
            </tr>`;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }

}

function tablaListaServicios(datos) {

    tablaProveedoresId = document.getElementById('tabla-datos-pagina').getElementsByTagName('tbody')[0];
    let fila = '';
    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];

        fila = `<tr>
                    <td>${element['idServicios']}</td>
                    <td>${element['nombre']}</td>
                    <td>${element['descripcion']}</td>
                    <td>${(element['idProducto'] == null ? 'No' : 'Si')}</td>
                    <td>${element['precio']} €</td>
                    <td><button name="botones-lista" id="${element['idServicios']}" data-bs-toggle="modal" data-bs-target="#modal-servicio">Seleccionar</button> 
                    </td>
                </tr>`;
        tablaProveedoresId.innerHTML += fila;
    }
    //cuando creamos los botones, le añadimos a todos un escuchador
    if (document.getElementsByName('botones-lista').length > 0) {
        boton = document.getElementsByName('botones-lista');
        for (let i = 0; i < boton.length; i++) {
            boton[i].addEventListener('mouseover', rellenarModal, true);
        }
    }

}
// filta que lista se va a usar
function seleccionarTabla(nombreTabla, datosTabla) {
    switch (nombreTabla) {
        case 'clientes':
            tablaListaClientes(datosTabla);
            break;
        case 'empleados':
            tablaListaEmpleados(datosTabla);
            break;
        case 'facturas':
            tablaListaFacturas(datosTabla);
            break;
        case 'presupuestos':
            tablaListaPresupuestos(datosTabla);
            break;
        case 'proveedores':
            tablaListaProveedores(datosTabla);
            break;
        case 'servicios':
            tablaListaServicios(datosTabla)
            break;
    }
}
//funcion que fuiltra el modal que se tiene que rellenar
function seleccionarModal(nombrePagina, datosParaMOdal) {
    switch (nombrePagina) {
        case 'clientes':
            camposModalClientes(datosParaMOdal);
            break;
        case 'empleados':
            camposModalEmpleados(datosParaMOdal);
            break;
        case 'facturas':
            camposModalFacturas(datosParaMOdal);
            break;
        case 'presupuestos':
            camposModalPresupuestos(datosParaMOdal);
            break;
        case 'proveedores':
            camposModalProveedores(datosParaMOdal);
            break;
        case 'servicios':
            camposModalServicios(datosParaMOdal)
            break;
    }
}

//crea las lista en el panel de lista vista
function crearLIstas() {
    nombrePagina = localizarDondeEstoy(); // aqui va la funcion localizarDondeEstoy
    nombreSolicitud = nombrePagina;

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            seleccionarTabla(nombrePagina, objInfo);
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(nombrePagina + '=' + nombreSolicitud);
}

function camposModalClientes(datos) {
    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');
    input[0].value = datos['nombreEmpresa'];
    input[1].value = datos['dni'];
    input[2].value = datos['direccion'];
    input[3].value = datos['email'];
    input[4].value = datos['telefono'];
}

function camposModalEmpleados(datos) {
    nombre = (datos['nombre'].substring(0, 1)).toLocaleLowerCase() + '' + datos['nombre'].substring(1, datos['nombre'].length);
    apellido = ((datos['apellido']).substring(0, 1)).toLocaleLowerCase() + '' + (datos['apellido']).substring(1, datos['apellido'].length);

    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');

    input[0].value = nombre + ' ' + apellido;
    input[1].value = datos['dni'];
    input[2].value = datos['direccion'];
    input[3].value = datos['email'];
    input[4].value = datos['telefono'] == null ? '- - - - - -' : datos['telefono'];
}

function camposModalFacturas(datos) {
    modal = document.getElementById('modal-body');
    span = modal.getElementsByTagName('span');
    c = 0;
    //alert(JSON.stringify(datos))
    for (const k in datos) {
        if (Object.hasOwnProperty.call(datos, k)) {
            const dato = datos[k];
            span[c].innerHTML = dato;
            c++;
        }
    }
    //   span[span.length].innerHTML = (parseInt(datos['precioTotalSinIva']) * 1.21);
}

function camposModalPresupuestos(datos) {
    modal = document.getElementById('modal-body');
    span = modal.getElementsByTagName('span');
    c = 0;
    //alert(JSON.stringify(datos))
    for (const k in datos) {
        if (Object.hasOwnProperty.call(datos, k)) {
            const dato = datos[k];
            span[c].innerHTML = dato;
            c++;
        }
    }
    //  span[span.length].innerHTML = (parseInt(datos[span.length]) * 1.21);
}

function camposModalProveedores(datos) {
    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');
    input[0].value = datos['dni'];
    input[1].value = datos['nombre'];
    input[2].value = datos['direccion'];
    input[3].value = datos['email'];
    input[4].value = datos['telefono'];
    input[5].value = datos['personaContacto'];
}

function camposModalServicios(datos) {
    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');
    input[0].value = datos['nombre'];
    input[1].value = datos['idServicios'];
    input[2].value = datos['descripcion'];
    input[3].value = datos['precio'];
    input[4].value = (parseInt(datos['precio']) * 1.21);
    input[5].checked = datos['idProducto'] == 'null' ? false : true;
    input[6].value = datos['idProducto'];
}



function rellenarModal(e) {
    //alert(e.target.id)
    dni = e.target.id;
    pagina = localizarDondeEstoy();
    varServ = 'soicitarUnRegistro';
    packEnvioServ = JSON.stringify([pagina, dni]);

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
            seleccionarModal(pagina, objInfo[0]);
            // camposModalProveedores(objInfo[0]);
            //    alert(JSON.stringify(objInfo));
        }
    }
    xhttp.open('POST', './php/appFunciones.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varServ + '=' + packEnvioServ);
}

function desbloquearInputs() {
    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');
    for (let i = 0; i < input.length; i++) {
        input[i].disabled = false;
    }
}

function bloquearInputs() {
    modal = document.getElementById('modal-body');
    input = modal.getElementsByTagName('input');
    for (let i = 0; i < input.length; i++) {
        input[i].disabled = true;
    }
}