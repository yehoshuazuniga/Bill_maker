document.addEventListener('readystatechange', cargarEventos, false);

function cargarEventos() {
    if (document.readyState === 'interactive') {
        // document.getElementById('envio').addEventListener('click', busquedaSocio, false);
        document.getElementById('registrar').addEventListener('click', registroUsuario, false);
        // eventos pequeños
    }
}
//pasamos objeto DOM  wn gtupos don
//devuelve un array {} asociatico (id=>valor)

//funciones genericas para todas las paginas
function nombreLargo(empresaNombre) {
    let nombreSeparado = []
    let cod = '';
    nombreSeparado = empresaNombre.split(' ');
    for (let i = 0; i < nombreSeparado.length; i++) {
        if (nombreSeparado[i].length > 3) {
            cod += nombreSeparado[i].substring(0, 1);
        }
    }
    return (cod.substring(0, 2).toUpperCase());
}

function nombreCorto(empresaNombre) {
    return (empresaNombre.replace(' ', '-'))
}

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

    //return
    return (cod + roll + (Math.floor(Math.random() * 999))).toUpperCase();
    //agreagar un proceso que busque en la base de datos un id igual
    //si existe hay que hacerlo de nuevos
}

function obtenerValores(grupo) {
    let idValue = {};
    for (const indi of grupo) {
        idValue[indi.id] = indi.value
    }

    return idValue
}

function crearMensajesDom(mensaje) {

    //esto hay que mejorarlo
    document.getElementsByTagName('button')[1].appendChild(document.createElement('p').appendChild(document.createTextNode('ljdnjsn')))
    "ljdnjsn"
}

function setTimeOut(funcName, retraso) {
    const timer = setTimeOut(funcName + "()", parseInt(retraso))
}


function cambiaLoc(localizacion) {
    window.location.href = localizacion;
}

function invalido(elemento) {
    elemento.setAttribute('class', ' form-control ');
    elemento.classList.add('is-invalid');
}

function valido(elemento) {
    elemento.setAttribute('class', ' form-control ');
    elemento.classList.add('is-valid');

}

function validarDniCif(dni) {
    var expre = new RegExp("^[0-9]{7,8}[a-hA-H]{1}$|^[a-zA-Z]{1}[0-9]{7,8}$")
    respuesta = null;
    expre.test(dni) ? respuesta = true :
        respuesta = false;
    return respuesta;
}

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

    if (inputForm[6].value === '') {
        invalido(inputForm[6])

    } else {
        valido(inputForm[6])
        input6 = true;
    }
    if (input0 && input1 && input3 && input6) {
        apto = true;
    }

    return apto;
}

function validacionusuario(varPOST, datos) {
    let loc = './inicio.html';
    let datosEnvioServ = JSON.stringify(datos);
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const objInfo = JSON.parse(this.responseText);
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
    xhttp.open('POST', './php/accesoBD.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(varPOST + '=' + datosEnvioServ);
}

function busquedaSocio() {
    //funcion  para acceder de usuarios que ya tiene cuenta
    //solo se acceder con mail y passwor que a esten registradas
    const varPOST = 'accesousuario';
    let divRegistro = document.getElementsByName('usuario_np');
    let datosEnvioServ = {};
    let extDatosEnvioServ = 0;
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

//funcion para requistrar el usuario en la base de datos
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
        let loc = './index.html';
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
                alert(objInfo);

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
        xhttp.open('POST', './php/accesoBD.php', true);
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