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


function crearNuevoElemento() {

    pantallaCarga('on');
    
    const data = new FormData(document.getElementById('frmRegistroServicio'));

    const options = {
        method: "POST",
        body: data

    };

    // Petición HTTP
    fetch("../../servicios/php/crearAJAX.php", options)
        .then(response => response.json())
        .then(data => {

            console.log(data["query"]);
            if (data["resultado"]) {
                alertImage('EXITO', 'Se creo el producto con existo', 'success')
                actualiza(data);
            } else {
                alertImage('ERROR', 'Surgio un error en el registro', 'error')
            }

            pantallaCarga('off');
        });

}

function actualiza(data) {

    var catalogoServicios = document.getElementById("catalogoServicios");

    catalogoServicios.innerHTML = "<thead>" +
        "<tr>" +
        "<th class=\"text-center\" scope=\"col\">Nombre</th>" +
        "<th class=\"text-center\" scope=\"col\">Descripcion</th>" +
        "<th class=\"text-center\" scope=\"col\">Precio</th>" +
        "<th class=\"text-center\" colspan=\"2\" scope=\"col\"></th>" +
        "</tr>" +
        "</thead>";

    var cadenaServicios = "<tbody>";

    for (var i = 0; i < data["noDatos"]; i++) {

        var id = data[i]["id"];
        var nombre = data[i]["nombre"];
        var descripcion = data[i]["descripcion"];
        var precio = data[i]["precio"];
     

        cadenaServicios = cadenaServicios + " <tr> " +
            "<td class=\"text-center\">" + nombre + "</td> " +
            "<td class=\"text-center\">" + descripcion + "</td> " +
            "<td class=\"text-center\">" + precio + "</td> " +
            "<td class=\"text-center\"><img src=\"../../src/imagenes/editargps.png\" width=\"50px\" onclick=\"abrirModal(" + id + ",'" + nombre + "','" + descripcion + "','" + precio + "')\"></td> " +

            "</tr>"


    }

    cadenaServicios = cadenaServicios + "</tbody>";

    catalogoServicios.innerHTML = catalogoServicios.innerHTML + cadenaServicios;

}

function abrirModal(id, nombre, descripcion, precio) {

    var formulario = document.getElementById("frmModificar");
    formulario.id.value = id;
    formulario.nombre.value = nombre;
    formulario.descripcion.value = descripcion;
    formulario.precio.value = precio;



    $("#miModal").modal('show');



}



function modificarUsuario() {

    pantallaCarga('on');

    const data = new FormData(document.getElementById('frmModificar'));

    const options = {
        method: "POST",
        body: data

    };

    // Petición HTTP
    fetch("../../servicios/php/modificarAJAX.php", options)
        .then(response => response.json())
        .then(data => {
            if (data["resultado"]){
                alertImage('EXITO', 'Se modifico el registro con exito', 'success')
                actualiza(data);
            }else{
                alertImage('ERROR', 'hubo un error', 'error')

            }

            pantallaCarga('off');
        });

}

function filtrarProductos(){
    
    pantallaCarga('on');
    
    var filtroNParte = document.getElementById("filtroNParte").value;
    var filtroDescripcion = document.getElementById("filtroDescripcion").value;
    var filtroCategoria = document.getElementById("filtroCategoria").value;

    const options = {
        method: "GET"
    };

    // Petición HTTP
    fetch("../../productos/php/filtrarTablaAJAX.php?nParte="+filtroNParte+"&descripcion="+filtroDescripcion+"&categoriaid="+filtroCategoria, options)
    .then(response => response.json())
    .then(data => {
        
        actualiza(data);

        pantallaCarga('off');
    });
}


