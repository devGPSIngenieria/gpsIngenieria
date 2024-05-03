function abrirSeccion(opcion) {

    if (opcion == 1) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogo").style.display = 'flex';

    }

}

function abrirVenta(id){

  window.open("../php/ventaRecibo.php?id="+id,"_blank");

}

function filtrarVentas(){

   let filtroCliente =  document.getElementById("filtroCliente").value;
   let filtroTrabajador =  document.getElementById("filtroTrabajador").value;
   let filtroCompra =  document.getElementById("filtroCompra").value;
   let filtroFechaI =  document.getElementById("filtroFechaI").value;
   let filtroFechaF =  document.getElementById("filtroFechaF").value;

   
   const options = {
    method: "GET"
};

// Petición HTTP
fetch("../../ventas/php/AJAX/obtenVentasAJAX.php?filtroCliente=" + filtroCliente + "&filtroTrabajador=" + filtroTrabajador + "&filtroCompra=" + filtroCompra + "&filtroFechaI=" + filtroFechaI + "&filtroFechaF=" + filtroFechaF, options)
    .then(response => response.json())
    .then(data => {

        actualiza(data);

        pantallaCarga('off');

    });

}

function actualiza(data){

    let tabla = document.getElementById("catalogoVentas");
    console.log(tabla);

    tabla.innerHTML = "";

    let cadenaDatos = " <tr><th class=\"text-center\" scope=\"col\">Cliente</th>"+
    "<th class=\"text-center\" scope=\"col\">Trabajador</th>"+
    "<th class=\"text-center\" scope=\"col\">fecha</th>"+
    "<th class=\"text-center\" scope=\"col\">Compra</th>"+
    "<th class=\"text-center\" scope=\"col\">Total</th>"+
    "<th class=\"text-center\" scope=\"col\">Deuda</th>"+
    "<th class=\"text-center\" colspan=\"1\" scope=\"col\">Venta</th>"+
    "</tr>";

    for(let i = 0 ;i<data["noDatos"]; i++){

        cadenaDatos = cadenaDatos + " <tr>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["cliente"]+"</td>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["trabajador"]+"</td>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["fecha"]+"</td>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["compra"]+"</td>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["total"]+"</td>"+
        "<td class=\"text-center\" scope=\"col\">"+data[i]["deuda"]+"</td>"+
        "<td class=\"text-center\" colspan=\"1\" scope=\"col\"><img src=\"../../src/imagenes/pdf.png\" width=\"50px\" onclick=\"abrirVenta("+data[i]["ventaid"]+")\"></td></td>"+
        "</tr>";

    }

   tabla.innerHTML=cadenaDatos; 



   

}