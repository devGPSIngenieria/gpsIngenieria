function abrirSeccion(opcion) {

    pantallaCarga('on');
    
    if (opcion == 1) {
        //MOVIENDO LA VISIBILIDAD
        document.getElementById("reporteES").style.display = 'flex';
        pantallaCarga('off');
    }
}

function buscarES() {

    pantallaCarga('on');

    var filtroTipo = document.getElementById("filtroTipo").value;
    var filtroMovimiento = document.getElementById("filtroMovimiento").value;
    var filtroProducto = document.getElementById("filtroProducto").value;
    var filtroFechaInicial = document.getElementById("filtroFechaInicial").value;
    var filtroFechaFinal = document.getElementById("filtroFechaFinal").value;

    const data = new FormData();

    data.append('filtroTipo', filtroTipo);
    data.append('filtroMovimiento', filtroMovimiento);
    data.append('filtroProducto', filtroProducto);
    data.append('filtroFechaInicial', filtroFechaInicial);
    data.append('filtroFechaFinal', filtroFechaFinal);

    const options = {
        method: "POST",
        body: data

    };

    // Petición HTTP
    fetch("../../reportes/php/traerReporteESAJAX.php", options)
        .then(response => response.json())
        .then(data => {
            
            pantallaCarga('off');

            var catalogoProductos = document.getElementById('catalogoProductos');

            catalogoProductos.innerHTML = "";
            cadenaProductos = "<tr><th class=\"text-center\" scope=\"col\" >N.parte</th><th class=\"text-center\" scope=\"col\">Descripcion</th><th class=\"text-center\" scope=\"col\">Tipo</th><th class=\"text-center\" scope=\"col\">Movimiento</th><th class=\"text-center\" scope=\"col\">Cantidad</th><th class=\"text-center\" scope=\"col\">Fecha</th><th class=\"text-center\" scope=\"col\">Hora</th></tr>";


            if (data["noDatos"] > 0) {
                alertImage('EXITO', 'Se creo el producto con existo', 'success')



                for (var i = 0; i < data["noDatos"]; i++) {

                 

                      let fecha = "";
                      let hora = "";

                      if (data[i]["fecha"] != "") {

                        let separarFecha = data[i]["fecha"].split(" ")

                        console.log(separarFecha)

                        fecha = separarFecha[0];
                        hora = separarFecha[1];
  
  
                      }else{

                        fecha = "----";
                        hora = "----";

                      }

                    cadenaProductos = cadenaProductos + "<tr><td class=\"text-center\" >" + data[i]["nparte"] + "</td><td class=\"text-center\" >" + data[i]["descripcion"] + "</td><td class=\"text-center\" >" + data[i]["tipo"] +"</td><td class=\"text-center\" >" + data[i]["movimiento"] + "</td><td  class=\"text-center\">" + data[i]["cantidad"] + "</td><td  class=\"text-center\">" + fecha+ "</td><td class=\"text-center\">" + hora + "</td></tr>";

                }

            } else {
                alertImage('ERROR', 'Surgio un error en el registro', 'error')
            }

            catalogoProductos.innerHTML = cadenaProductos;


        });


}