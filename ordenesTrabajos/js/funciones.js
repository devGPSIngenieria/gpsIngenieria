function abrirSeccion(opcion) {
    
    pantallaCarga('on');
    
    if (opcion == 1) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'flex';

        pantallaCarga('off');
    }
}


function filtrarOrdenes() {

    pantallaCarga('on');

    var filtroNFolio = document.getElementById("filtroNFolio").value;
    var filtroTrabajador = document.getElementById("filtroTrabajador").value;
    var filtroCliente = document.getElementById("filtroCliente").value;
    var filtroFechaI = document.getElementById("filtroFechaI").value;
    var filtroFechaF = document.getElementById("filtroFechaF").value;

    const options = {
        method: "GET"
    };

    // Petición HTTP
    fetch("../../ordenesTrabajos/php/filtrarTablaAJAX.php?filtroNFolio=" + filtroNFolio + "&filtroTrabajador=" + filtroTrabajador + "&filtroCliente=" + filtroCliente + "&filtroFechaI=" + filtroFechaI + "&filtroFechaF=" + filtroFechaF, options)
        .then(response => response.json())
        .then(data => {

            actualiza(data);

            pantallaCarga('off');

        });

}

function actualiza(data) {

    var catalogoProductos = document.getElementById("catalogoProductos");

    catalogoProductos.innerHTML = "<thead>" +
        "<tr>" +
        "<th class=\"text-center\" scope=\"col\">N.Folio</th>" +
        "<th class=\"text-center\" scope=\"col\">Trabajador</th>" +
        "<th class=\"text-center\" scope=\"col\">Cliente</th>" +
        "<th class=\"text-center\" scope=\"col\">Factura</th>" +
        "<th class=\"text-center\" scope=\"col\">Pago Total</th>" +
        "<th class=\"text-center\" scope=\"col\">Flete</th>" +
        "<th class=\"text-center\" scope=\"col\">Deuda</th>" +
        "<th class=\"text-center\" scope=\"col\">Pagos</th>" +
        "<th class=\"text-center\" scope=\"col\">Fecha</th>" +
        "<th class=\"text-center\" scope=\"col\">Orden de Trabajo</th>" +
        "</tr>" +
        "</thead>";

    var cadenaProductos = "<tbody>";

    for (var i = 0; i < data["noDatos"]; i++) {

        var id = data[i]["id"];
        var trabajador = data[i]["trabajador"];
        var cliente = data[i]["cliente"];
        var total = data[i]["total"];
        var fecha = data[i]["fecha"];
        var numfolio = data[i]["numfolio"];
        var factura = data[i]["factura"];
        var pagoP = data[i]["pagoP"];
        var flete = data[i]["flete"];



        cadenaProductos = cadenaProductos + " <tr> " +
            "<td class=\"text-center\">" + numfolio + "</td> " +
            "<td class=\"text-center\">" + trabajador + "</td> " +
            "<td class=\"text-center\">" + cliente + "</td> ";


        //checando si tiene factura
        console.log(factura)
        if (factura != null) {
            cadenaProductos = cadenaProductos + "<td class=\"text-center\"><div style=\"margin-right: 10px;\">" + factura + "</div><img src=\"../../src/imagenes/bills.svg\"  width=\"40px\" onclick=\"abrirEvidenciaFactura(" + id + ")\"  ></td> ";

        } else {
            cadenaProductos = cadenaProductos + "<td class=\"text-center\"><img src=\"../../src/imagenes/agregargps.png\" onclick=\"abrirModalFacturaAgregar(" + id + ")\" width=\"40px\"></td>";
        }



        cadenaProductos = cadenaProductos + "<td class=\"text-center\">" + total + "</td> " +
            "<td class=\"text-center\">" + flete + "</td> " +
            "<td class=\"text-center\">" + pagoP + "</td> " +
            "<td class=\"text-center\"><img src=\"../../src/imagenes/pagos.png\"   width=\"40px\" onclick=\"abrirPagos(" + id + ")\"></td>" +
            "<td class=\"text-center\">" + fecha + "</td> " +
            "<td class=\"text-center\"><img src=\"../../src/imagenes/pdf.png\" width=\"50\"  onclick=\"checarOrden(" + id + ")\"></td>" +
            "</tr>"


    }

    cadenaProductos = cadenaProductos + "</tbody>";

    catalogoProductos.innerHTML = catalogoProductos.innerHTML + cadenaProductos;

}

function abrirEvidenciaFactura(id) {


    window.open("../evidenciasFacturas/evidencia" + id + ".jpg", "_black");

}

function checarOrden(ordenid) {

    window.open("../../ordenesTrabajos/php/formatoOrdenTrabajo.php?ordenid=" + ordenid, "_blank");


}

function abrirPagos(id) {

    $("#miModal").modal('show');

    var formularioPagos = document.getElementById("frmPagos");

    modalAbierto(1);



    formularioPagos.id.value = id;

    formularioPagos.style.display = "none";


    const options = {
        method: "GET"
    };

    // Petición HTTP
    fetch("../../ordenesTrabajos/php/traerPagosAJAX.php?id=" + id, options)
        .then(response => response.json())
        .then(data => {


            var tablaPagos = document.getElementById("tablaPagos");

            var cadena = "<tr><th>Cantidad</th><th>Evidencia</th></tr>";
            if (data["noDatos"] > 0) {

                for (var i = 0; i < data["noDatos"]; i++) {

                    cadena = cadena + "<tr><td>" + data[i]["cantidad"] + "</td><td><img src=\"../../src/imagenes/mostrarEvidencia.png\" width=\"30px\" onclick=\"mostrarEvidencia(" + data[i]["id"] + ")\"></td></tr>";

                }



            }

            tablaPagos.innerHTML = cadena;



        });








}

function abrirModalFacturaAgregar(id) {


    $("#miModal").modal('show');

    var frmFactura = document.getElementById("frmFactura");

    frmFactura.id.value = id;

    modalAbierto(2);




}


function agregarFactura() {
    
    pantallaCarga('on');
    
    const data = new FormData(document.getElementById('frmFactura'));

    const options = {
        method: "POST",
        body: data

    };

    // Petición HTTP
    fetch("../../ordenesTrabajos/php/subirFacturaAJAX.php", options)
        .then(response => response.json())
        .then(data => {
            if (data["resultado"]) {
                alertImage('EXITO', 'Se agrego la factura con exito', 'success')
                var formulario = document.getElementById("frmFactura");
                formulario.reset();
                actualiza(data)
                $("#miModal").modal('hide');

                pantallaCarga('off');

            } else {
                alertImage('ERROR', 'hubo un error', 'error')

                pantallaCarga('off');

            }

        });

}

function modalAbierto(elemento) {


    var formularioPagos = document.getElementById("frmPagos");
    var divPagos = document.getElementById("divPagos");
    var formularioFactura = document.getElementById("frmFactura");

    var btnFormulario = document.getElementById("btnNuevoPago");

    if (elemento == 1) {


        formularioPagos.style.display = "block";
        divPagos.style.display = "block";
        formularioFactura.style.display = "none"
        btnFormulario.textContent = "Nuevo Pago";
        btnFormulario.onclick = function () {
            nuevoPago();
        }

    }

    if (elemento == 2) {



        if (divPagos != null) {

            formularioPagos.style.display = "none";
            divPagos.style.display = "none";

        }

        btnFormulario.textContent = "Agregar Factura";

        formularioFactura.style.display = "block"
        btnFormulario.onclick = function () {
            agregarFactura();
        }

    }

}

function mostrarEvidencia(id) {

    window.open("../evidencias/evidencia" + id + ".jpg", "_blank");

}

function nuevoPago() {

    // if(estado==1){

    var formularioPagos = document.getElementById("frmPagos");



    var estado = formularioPagos.estado.value;
    if (estado == 1) {


        formularioPagos.style.display = "block";

        var btnNuevoPago = document.getElementById("btnNuevoPago");

        btnNuevoPago.textContent = "Subir"

        formularioPagos.estado.value = 0
    } else {

        formularioPagos.estado.value = 1


        const data = new FormData(document.getElementById('frmPagos'));

        const options = {
            method: "POST",
            body: data

        };

        // Petición HTTP
        fetch("../../ordenesTrabajos/php/subirPagoAJAX.php", options)
            .then(response => response.json())
            .then(data => {
                if (data["resultado"] == 1) {
                    alertImage('EXITO', 'Se agrego el pago con exito', 'success')
                    var formulario = document.getElementById("frmPagos");
                    formulario.reset();

                    actualiza(data);

                    var btnNuevoPago = document.getElementById("btnNuevoPago");

                    btnNuevoPago.textContent = "Nuevo Pago"
                    $("#miModal").modal('hide');
                }
                if (data["resultado"] == 0) {
                    alertImage('ERROR', 'La cantidad ya fue completada', 'error')

                }

            });



    }


}

function cerrarPago() {


    var formularioPagos = document.getElementById("frmPagos");
    var formularioFactura = document.getElementById("frmFactura");


    if (formularioPagos != null) {
        formularioPagos.estado.value = 1
        formularioPagos.reset();
    }

    if (formularioFactura != null) {
        formularioFactura.reset();
    }


    var btnNuevoPago = document.getElementById("btnNuevoPago");

    btnNuevoPago.textContent = "Nuevo Pago"
    $("#miModal").modal('hide');



}