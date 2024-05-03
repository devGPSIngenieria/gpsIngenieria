// ABRE LA SECCION SELECCINADA POR EL USUARIO
function abrirSeccion(opcion) {
    
    pantallaCarga('on');

    if (opcion == 1) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'flex';
        document.getElementById("frmRegistroUsuario").style.display = 'none';
        document.getElementById("permisos").style.display = 'none';
        
        pantallaCarga('off');
    }

    if (opcion == 2) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'none';
        document.getElementById("frmRegistroUsuario").style.display = 'flex';
        document.getElementById("permisos").style.display = 'none';

        pantallaCarga('off');
    }

    if (opcion == 3) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'none';
        document.getElementById("frmRegistroUsuario").style.display = 'none';
        document.getElementById("permisos").style.display = 'flex';

        pantallaCarga('off');
    }

}

// ABRE EL MODAL
function abrirModal(usuarioid, nombre, login, correo) {
    var formulario = document.getElementById("frmModificar");
    formulario.id.value = usuarioid;
    formulario.nombre.value = nombre;
    formulario.login.value = login;
    formulario.correo.value = correo;

    $("#miModal").modal('show');
}

// MODIFICA DATOS DEL USUARIO
function modificarUsuario() {

    const data = new FormData(document.getElementById('frmModificar'));

    var campoId = data.get('id');
    var campoNombre = data.get('nombre');
    var campoLogin = data.get('login');
    var campoCorreo = data.get('correo');
    var campoPassword = data.get('password');

    if(campoId != '' && campoNombre != '' && campoLogin != '' && campoCorreo != ''){
    
        pantallaCarga('on');

        const options = {
            method: "POST",
            body: data
        };

        // Petición HTTP
        fetch("../../usuarios/php/modificarAJAX.php", options)
        .then(response => response.json())
        .then(data => {
            $('#miModal').modal('hide');
            if (data[0]["resultado"] == 0)
                alertImage('ERROR', 'Error en el registro', 'error');
                pantallaCarga('off');

            if (data[0]["resultado"] == 1)
                alertImage('ERROR', 'Necesita llenar todos los campos', 'error');
                pantallaCarga('off');

            if (data[0]["resultado"] == 2)
                alertImage('ÉXITO', 'Se modificó el usuario con éxito', 'success');
                pantallaCarga('off');

                actualizarUsuarios();
        });
    } else {
        alertImage('ERROR', 'Solo puede quedar vació el campo contraseña', 'error');
    }
}

// ACTUALIZA LA TABLA DEL CATALOGO
function actualizarUsuarios(){

    pantallaCarga('on');
    
    var frmFiltros = document.getElementById('frmFiltosCatalogoUsuarios');
    var nombre = frmFiltros.filtroNombre.value;
    var login = frmFiltros.filtroLogin.value;
    var correo = frmFiltros.filtroCorreo.value;

    const options = { method: "GET" };
    var ruta = "../../usuarios/php/traeUsuariosAJAX.php?nombre="+nombre+"&login="+login+"&correo="+correo;
    
    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        pantallaCarga('off');
        
        if (data["resultado"] == 1) {
            var noDatos = data[0]["noDatos"];
            var catalogoUsuarios = document.getElementById("catalogoUsuarios");

            catalogoUsuarios.innerHTML = "";
            catalogoUsuarios.innerHTML = "<thead class='sticky-top'><tr><th class=\"text-center\" scope=\"col\">Nombre</th><th class=\"text-center\" scope=\"col\">Login</th><th class=\"text-center\" scope=\"col\">Correo</th><th class=\"text-center\" colspan=\"2\" scope=\"col\"></th></tr></thead>";

            var cadenaUsuarios = "<tbody>";

            for (var i = 0; i < noDatos; i++) {
                var idusuario = data[i]["idusuario"];
                var nombreusuario = data[i]["nombreusuario"];
                var passwordusuario = data[i]["passwordusuario"];
                var correo = data[i]["correo"];
                var nombre = data[i]["nombre"];

                cadenaUsuarios = cadenaUsuarios + " <tr><td class=\"text-center\">" + nombre + "</td><td class=\"text-center\">" + nombreusuario + "</td><td class=\"text-center\">" + correo + "</td>" +
                "<td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"abrirModal(" + idusuario + ",'" + nombre + "','" + nombreusuario + "','" + correo + "')\"><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td>"+
                "<td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"eliminarUsuario(" + idusuario + ")\"><i class='fa-solid fa-xmark fa-lg'></i></div></div></td></tr>";
            }
            cadenaUsuarios = cadenaUsuarios + "</tbody>"

            catalogoUsuarios.innerHTML = catalogoUsuarios.innerHTML + cadenaUsuarios;
        }
    });
}

// CREA UN USUARIO NUEVO
function crearUsuario() {

    var frm = document.getElementById('frmRegistroUsuario');
    var nombre = frm.nombre.value;
    var correo = frm.correo.value;
    var login = frm.login.value;
    var password = frm.password.value;
    
    if(nombre != '' && correo != '' && login != '' && password != ''){
        pantallaCarga('on');

        const options = { method: "GET" };

        fetch("../../usuarios/php/crearAJAX.php?nombre="+nombre+"&login="+login+"&correo="+correo+"&password="+password, options)
        .then(response => response.json())
        .then(data => {

            //CHECANDO SI HUBO UN ERROR
            if(data[0]["resultado"] == 2){

                alertImage('EXITO', 'Se registró el usuario con éxito', 'success')
                pantallaCarga('off');
                
                actualizarUsuarios();
                abrirSeccion(1);
                document.getElementById("frmRegistroUsuario").reset();
            }else{

                if(data[0]["resultado"] == 0)alertImage('ERROR', 'Surgió un error al hacer el registro', 'error')

                if(data[0]["resultado"] == 1)alertImage('ERROR', 'El nombre o usuario ya se encuentran registrados', 'error')
                
                actualizarUsuarios();
                pantallaCarga('off');
            }
        })
    } else {
        alertImage('ERROR', 'Todos los campos deben estar llenos correctamente', 'error');
    }
}

// ELIMINA UN USUARIO
function eliminarUsuario(id) {

    var color = '#FFFFFF';
    var icono = 'warning';
    switch (icono) {
        case 'warning':
            color = "#03B559";
            color2 = "#B50309";
            break;
    }
    swal.fire({
        title: "ATENCIÓN",
        text: "¿Está seguro que desea eliminar este usuario?",
        icon: icono,
        showCancelButton: true,
        confirmButtonText: 'SI',
        confirmButtonColor: color,
        cancelButtonText: 'NO',
        cancelButtonColor: color2,
        allowOutsideClick: false

    }).then((result) => {
        if (result.isConfirmed) {
            
            pantallaCarga('on');
            
            const options = {
                method: "GET"
            };

            fetch("../../usuarios/php/eliminarAJAX.php?id=" + id, options)
            .then(response => response.json())
            .then(data => {

                if (data[0]["resultado"] == 1) {

                    alertImage('EXITO', 'Se eliminó el usuario con éxito', 'success');
                    pantallaCarga('off');
                    actualizarUsuarios();
                } else {

                    alertImage('ERROR', 'Error al tratar eliminar registro', 'error')
                    pantallaCarga('off');
                    actualizarUsuarios();
                }
            });
        }
    })
}

// CARGA LOS PERMISOS EN LA PANTALLA
function cargaPermisos(idusuario){
    
    document.getElementById('divSeccionTipoPermiso').innerHTML = "";
    document.getElementById("divSeccionPermiso").innerHTML = "";

    if(idusuario != 0){

        pantallaCarga('on');

        const options = { method: "GET" };
        
        fetch("../../usuarios/php/traerPermisosAJAX.php?idusuario="+idusuario, options)
        .then(response => response.json())
        .then(data => {

            var divSeccionPermiso = document.getElementById("divSeccionPermiso");
            divSeccionPermiso.innerHTML = "";
            var cadenaAreas = "";

            //NUMERO DE AREAS 
            nAreas = data["noDatosAreas"][0]["noDatos"];

            cadenaAreas = "<div class='contenedorInputs'>";
            
            for(var i = 0;i<nAreas;i++){
                cadenaAreas +=   "<div class='contenedorInputs'>"+
                                        "<button class='botonMenuLista' id='"+data["areas"][i]["id"]+"' onclick='verSeccionesDeArea("+idusuario+","+data["areas"][i]["id"]+","+JSON.stringify(data["noDatosSeccion"])+", "+JSON.stringify(data["noDatosAreas"])+", "+JSON.stringify(data["secciones"])+", "+JSON.stringify(data["areas"])+")'>"+                                        
                                            data["areas"][i]["nombre"]+
                                        "</button>"+
                                    "</div>";
            }
            cadenaAreas += "</div>";
            divSeccionPermiso.innerHTML = cadenaAreas;

            pantallaCarga('off');
        })
    }
}

// MUESTRA LAS SECCIONES DEL USUARIO
function verSeccionesDeArea(idusuario, idArea, noDatosSeccion, noDatosAreas,secciones, areas){
    
    var numDePermisos = noDatosSeccion[0]["noDatos"];
    var numDeAreas = noDatosAreas[0]["noDatos"];
    var divSeccionTipoPermiso = document.getElementById('divSeccionTipoPermiso');

    var cadenaPermiso = "";

    for(var j = 0 ; j < numDePermisos ; j++){

        if(idArea == secciones[j]["idarea"]){

            if(secciones[j]["permiso"]){
                
                cadenaPermiso +=    "<label class='containerCheck contenedorMargen'>" + 
                                        secciones[j]["nombre"]+
                                        "<input type='checkbox' id='"+secciones[j]["idseccion"]+"' checked='checked' onclick='ponerPermiso(this.id, "+idusuario+")'>" +
                                        "<div class='checkmark'></div>" +
                                    "</label>";
            }else{

                cadenaPermiso +=    "<label class='containerCheck contenedorMargen'>" + 
                                        secciones[j]["nombre"]+
                                        "<input type='checkbox' id='"+secciones[j]["idseccion"]+"' onclick='ponerPermiso(this.id, "+idusuario+")'>" +
                                        "<div class='checkmark'></div>" +
                                    "</label>";
            }                        
        } 
        divSeccionTipoPermiso.innerHTML = cadenaPermiso;
    }
}

// PONER Y QUITAR EL PERMISO AL USUARIO
function ponerPermiso(idseccion,idusuario){
    
    pantallaCarga('on');
    
    const options = {
        method: "GET"

    };

    fetch("../../usuarios/php/ponerPermisoAJAX.php?idseccion="+idseccion+"&idusuario="+idusuario, options)
    .then(response => response.json())
    .then(data => {

        if(data["resultado"]){
            alertImage('ÉXITO', 'Se quitó el permiso al usuario', 'success')
            pantallaCarga('off');
        }else{
            alertImage('ÉXITO', 'Se colocó el permiso al usuario', 'success')
            pantallaCarga('off');
        }
    });
}