function abrirSeccion(opcion) {
    pantallaCarga('on');

    // Ocultar todas las secciones
    document.getElementById("catalogo").style.display = 'none';
    document.getElementById("registros").style.display = 'none';

    // Mostrar la sección seleccionada
    switch (opcion) {
        case 1:
            document.getElementById("catalogo").style.display = 'flex';
            break;
        case 2:
            document.getElementById("registros").style.display = 'flex';
            break;
        default:
            break;
    }

    pantallaCarga('off');
}

function crearEmpleado(){
    
    pantallaCarga('on');

    const data = new FormData(document.getElementById('frmRegistroEmpleados')); 
    
    const options = {
        method: "POST",
        body: data
    };
    
    fetch("../../empleados/php/crearEmpleadoAJAX.php", options)
    .then(response => response.json())
    .then(data => {

        if(data[0]["resultado"] == 1){
            alertImage('EXITO', 'Se registró el empleado con éxito', 'success')                    
            actualizar(data);
            document.getElementById('frmRegistroEmpleados').reset();
            pantallaCarga('off');
        }else{
            if(data[0]["resultado"] == 0)alertImage('ERROR', 'Surgió un error al hacer el registro', 'error')
            pantallaCarga('off');
        }

    })
}

function actualizar(data){
    var noDatos = data[0]["noDatos"];
    
    var catalogoEmpleados = document.getElementById("catalogoEmpleados");

    catalogoEmpleados.innerHTML = "";

    catalogoEmpleados.innerHTML = "<thead>"+
    "<tr>"+
        "<th class=\"text-center\" scope=\"col\">Nombre</th>"+
        "<th class=\"text-center\" scope=\"col\">Correo</th>"+
        "<th class=\"text-center\" scope=\"col\">Telefono</th>"+
        "<th class=\"text-center\" scope=\"col\">Puesto</th>"+
        "<th class=\"text-center\" scope=\"col\" colspan='2'>Acción</th>"+
    "</tr>"+
"</thead>";

    var cadenaEmpleados = "<tbody>";
    for (var i = 0; i < noDatos; i++) {

        var idEmpleado = data[i]["idempleado"];
        var nombre = data[i]["nombre"];
        var apellidos = data[i]["apellidos"];
        var correo = data[i]["correo"];
        var telefono = data[i]["telefono"];
        var puesto = data[i]["puesto"];

        cadenaEmpleados = cadenaEmpleados + " <tr>"+
        "<td class=\"text-center\">" + nombre + " " +apellidos+"</td>"+
        "<td class=\"text-center\">" + correo + "</td>"+
        "<td class=\"text-center\">" + telefono + "</td>"+
        "<td class=\"text-center\">" + puesto + "</td>"+
        "<td class=\"text-center\"><img src=\"../../src/imagenes/editargps.png\" width=\"50px\" onclick=\"abrirModal(" +idEmpleado+ ",'" +nombre+ "','" +apellidos+ "','" +correo+ "','" +telefono+ "','"+puesto+"')\"></td>"+
        "<td class=\"text-center\"><img src=\"../../src/imagenes/eliminargps.png\" width=\"50px\" onclick=\"eliminarUsuario(" +idEmpleado+ ")\"></td>"+
        "</tr>"
    }

    cadenaEmpleados = cadenaEmpleados + "</tbody>"
    catalogoEmpleados.innerHTML = catalogoEmpleados.innerHTML + cadenaEmpleados;
}

function abrirModal(idEmpleado,nombre,apellidos,correo,telefono,puesto){

    var formulario = document.getElementById("frmModificar");
    formulario.id.value = idEmpleado;
    formulario.nombre.value = nombre;
    formulario.apellidos.value = apellidos;
    formulario.correo.value = correo;
    formulario.telefonoCelular.value = telefono;
    formulario.puesto.value = puesto;

    $("#miModal").modal('show');
}

function modificarEmpleado(){

    pantallaCarga('on');

    const data = new FormData(document.getElementById('frmModificar'));
    const options = {
        method: "POST",
        body: data
    };

    fetch("../../empleados/php/modificarEmpleadoAJAX.php", options)
    .then(response => response.json())
    .then(data => {
        if (data[0]["resultado"] == 0)
            alertImage('ERROR', 'Error en el registro', 'error')
            pantallaCarga('off');

        if (data[0]["resultado"] == 1)
            alertImage('ERROR', 'Necesita llenar todos los campos', 'error')
            pantallaCarga('off');

        if (data[0]["resultado"] == 2)
            alertImage('EXITO', 'Se modificó el empleado con éxito', 'success')
            actualizar(data);
            pantallaCarga('off');
    });
}

function eliminarUsuario(id){
    
    pantallaCarga('on');
    
    alertImageConfirma('¡Atención!','¿Estás seguro de eliminar empleado?.','warning',si,no);

    function si(){ 
        const variables = '?&id='+id;
        const url = '../../empleados/php/eliminarEmpleadoAJAX.php'+variables;
        const options = { method: "GET" };
    
        fetch(url, options)
        .then(response => response.json())
        .then(data => {
      
            if (data[0]["resultado"] == 0)
                alertImage('ERROR!', 'Ocurrió un error al eliminar el empleado, inténtalo de nuevo', 'error');
                pantallaCarga('off');
    
            if (data[0]["resultado"] == 1)
                alertImage('ÉXITO!', 'Se eliminó el empleado correctamente', 'success');
                actualizar(data);
                pantallaCarga('off');
        });
    }
    function no(){
        pantallaCarga('off');
    }
}