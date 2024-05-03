
function abrirSeccion(opcion) {
    pantallaCarga('on');
    if (opcion == 1) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'flex';
        document.getElementById("registros").style.display = 'none';
        pantallaCarga('off');
       
    }

    if (opcion == 2) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'none';
        document.getElementById("registros").style.display = 'flex';
        pantallaCarga('off');
    }
}

function crearCliente(){
    
    pantallaCarga('on');

        const data = new FormData(document.getElementById('frmRegistroCliente')); 
    
        console.log(data);
        const options = {
            method: "POST",
            body: data
    
        };
    
    
        fetch("../../clientes/php/crearAJAX.php", options)
            .then(response => response.json())
            .then(data => {
    
                //CHECANDO SI HUBO UN ERROR
                if(data[0]["resultado"] == 1){
    
                    alertImage('EXITO', 'Se registró el usuario con éxito', 'success')
                    
                    actualizar(data);

                    pantallaCarga('off');
    
                }else{
    
                   if(data[0]["resultado"] == 0)alertImage('ERROR', 'Surgio un error al hacer el registro', 'error')
    
                   //if(data[0]["resultado"] == 1)alertImage('ERROR', 'El nombre o usuario ya fueron registrados', 'error')
                   pantallaCarga('off');
                }
               
            })


}


function abrirModal(idcliente, nombres, apellidos, domicilio,estado,codigoPostal,contacto,rfc,email) {

    var formulario = document.getElementById("frmModificar");
    formulario.id.value = idcliente;
    formulario.nombres.value = nombres;
    formulario.apellidos.value = apellidos;
    formulario.domicilio.value = domicilio;
    formulario.estado.value = estado;
    formulario.codigoPostal.value = codigoPostal;
    formulario.contacto.value = contacto;
    formulario.rfc.value = rfc;
    formulario.email.value = email;
   

    $("#miModal").modal('show');

}


function modificarCliente() {

    pantallaCarga('on');

    const data = new FormData(document.getElementById('frmModificar'));

    const options = {
        method: "POST",
        body: data

    };

    // Petición HTTP
    fetch("../../clientes/php/modificarAJAX.php", options)
        .then(response => response.json())
        .then(data => {
            if (data[0]["resultado"] == 0)
                alertImage('ERROR', 'Error en el registro', 'error')
                pantallaCarga('off');

            if (data[0]["resultado"] == 1)
                alertImage('ERROR', 'Nesesita llenar todos los campos', 'error')
                pantallaCarga('off');

            if (data[0]["resultado"] == 2)
                alertImage('EXITO', 'Se modifico el usuario con existo', 'success')
                pantallaCarga('off');

                actualizar(data);


        });

}

function actualizar(data){
    var noDatos = data[0]["noDatos"];
    
    var catalogoUsuarios = document.getElementById("catalogoClientes");

    catalogoUsuarios.innerHTML = "";

    catalogoUsuarios.innerHTML = "<thead>"+
    "<tr>"+
        "<th class=\"text-center\" scope=\"col\">Nombre</th>"+
        "<th class=\"text-center\" scope=\"col\">Domicilio</th>"+
        "<th class=\"text-center\" scope=\"col\">Estado</th>"+
        "<th class=\"text-center\" scope=\"col\">Codigo Postal</th>"+
        "<th class=\"text-center\" scope=\"col\">Contacto</th>"+
        "<th class=\"text-center\" scope=\"col\">Rfc</th>"+
        "<th class=\"text-center\" scope=\"col\">Email</th>"+
        "<th class=\"text-center\" colspan=\"2\" scope=\"col\"></th>"+
    "</tr>"+
"</thead>";

    var cadenaUsuarios = "<tbody>";
    for (var i = 0; i < noDatos; i++) {

        var idcliente = data[i]["idcliente"];
        var nombre = data[i]["nombre"];
        var apellidos = data[i]["apellidos"];
        var domicilio = data[i]["domicilio"];
        var estado = data[i]["estado"];
        var codigopostal = data[i]["codigopostal"];
        var contacto = data[i]["contacto"];
        var rfc = data[i]["rfc"];
        var email = data[i]["email"];
        

        cadenaUsuarios = cadenaUsuarios + " <tr>"+
        "<td class=\"text-center\">" + nombre + " " +apellidos+"</td>"+
        "<td class=\"text-center\">" + domicilio + "</td>"+
        "<td class=\"text-center\">" + estado + "</td>"+
        "<td class=\"text-center\">" + codigopostal + "</td>"+
        "<td class=\"text-center\">" + contacto + "</td>"+
        "<td class=\"text-center\">" + rfc + "</td>"+
        "<td class=\"text-center\">" + email + "</td>"+
        "<td class=\"text-center\"><img src=\"../../src/imagenes/editargps.png\" width=\"50px\" onclick=\"abrirModal(" +idcliente+ ",'" +nombre+ "','" +apellidos+ "','" +domicilio+ "','" +estado+ "','" +codigopostal+ "','" +contacto+ "','" +rfc+ "','" +email+ "')\"></td>"+
        
       "</tr>"



    }

    cadenaUsuarios = cadenaUsuarios + "</tbody>"

    catalogoUsuarios.innerHTML = catalogoUsuarios.innerHTML + cadenaUsuarios;
}