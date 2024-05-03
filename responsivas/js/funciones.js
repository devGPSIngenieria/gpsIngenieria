function abrirSeccion(opcion) {
    
    pantallaCarga('on');
    
    if (opcion == 1) {
        //MOVIENDO LA VISIBILIDAD PARA VER EL APARTADO DE CREAR RESPONSIVAS
        document.getElementById("crearResponsivas").style.display = 'flex';
        document.getElementById('catalogoResponsivas').style.display = 'none';
        verProductos();
        pantallaCarga('off');
    }
    if(opcion == 2){
        //MOVIENDO LA VISIBILIDAD PARA VER CATALOGO DE RESPONSIVAS
        document.getElementById("crearResponsivas").style.display = 'none';
        document.getElementById('catalogoResponsivas').style.display = 'flex';
        verCatalogoResponsivas();
        pantallaCarga('off');
    }

}

function modalResponsiva(){
    
    const checkboxes = document.querySelectorAll('#tablaProductosResponsivas input[type="checkbox"]');
    const registrosSeleccionados = Array.from(checkboxes)
    
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value);
    
    if(registrosSeleccionados != "" || registrosSeleccionados.length > 0){

        pantallaCarga('on');

        const options = { method: "GET" };
        const variables = "?arrRegSeleccionados="+JSON.stringify(registrosSeleccionados);
        const url = "../php/AJAX/traeProductosAJAX.php"+variables;

        fetch(url, options)
        .then(response => response.json())
        .then(data => {

            pantallaCarga('off');
            // console.log(data);

            if(data['bandera'] == 0){
                alertImage('Error','Ocurrió un error, inténtalo más tarde.','error');
            }
            if(data['bandera'] == 1){
                
                var tablaProdSel = document.getElementById('tablaProdSel');
                var conTabla = "<tr></tr>";
                
                conTabla = "<thead><tr class='sticky-top text-center'><th>#</th><th>Numero de parte</th><th>Descripción</th><th>Existentes</th><th>Precio por unidad</th><th>Nombre</th><th>Cantidad</th></tr></thead>";

                for(puntero = 0 ; puntero < data['array'].length ; puntero++){
                    var indice = puntero+1;
                    conTabla += "<thead>";
                        conTabla += "<tr class='text-center'>";
                            conTabla += "<td>"+indice+"</td>";
                            conTabla += "<td>"+data['numParte'][puntero]+"</td>";
                            conTabla += "<td>"+data['descripcion'][puntero]+"</td>";
                            conTabla += "<td>"+data['existentes'][puntero]+"</td>";
                            conTabla += "<td>"+data['precioxunidad'][puntero]+"</td>";
                            conTabla += "<td>"+data['nombre'][puntero]+"</td>";
                            conTabla += "<td><div class='form-floating mb-3'><input onkeyup='validarInput(this, "+data['existentes'][puntero]+")' type='number' min='1' max='"+data['existentes'][puntero]+"' class='form-control' id='"+data['array'][puntero]+"' name='cantidad' placeholder='Ingrese la cantidad'><label>Cantidad</label></div></td>";
                        conTabla += "</tr>";
                    conTabla += "</thead>";
                }
                
                tablaProdSel.innerHTML = conTabla;

                $("#modalResponsiva").modal('show');   
                
            } 
        });
        
    } else {
        alertImage('Error','Debe seleccionar al menos un producto para generar la responsiva','error');
    }
    
}

function generarResponsiva(){
    var selectEmpleado = document.getElementById('empleado');
    var opcionSeleccionada = selectEmpleado.options[selectEmpleado.selectedIndex];
    var contenidoSelect = opcionSeleccionada.textContent;

    if(selectEmpleado.value != ""){

        var inputs = document.querySelectorAll("#tablaProdSel .form-control");

        var todosValidos = true;
        var valores = new Array;
        var ids = new Array;

        for (var i = 0; i < inputs.length; i++) {

            var valor = inputs[i].value.trim();
            var valorid = inputs[i];
            
            if (valor === "") {
                todosValidos = false;
                break;
            } else {
                valores[i] = valor;
                ids[i] = valorid.id;
            }
        }

        if (todosValidos) {
            pantallaCarga('on');

            const options = { method: "GET" };
            const variables = "?arrayId="+ids+"&arrayValores="+valores+"&empleado="+contenidoSelect+"&idempleado="+selectEmpleado.value;
            const url = "../php/AJAX/formatoResponsiva.php"+variables;

            fetch(url, options)
            .then(response => response.text())
            .then(data => {
                pantallaCarga('off');
                verProductos();
                verCatalogoResponsivas();

            })
            .catch(error => {
                console.error('Error al cargar el archivo de texto:', error);
            });

        } else {
            alertImage('Error','Ingrese las cantidades faltantes, al menos un campo esta vació','error');
        }
    } else {
        alertImage('Error','Debes ingresar el empleado para asignar responsiva','error');
    }
}

function validarInput(input, max) {
    var min = 1;
    
    valor = input.value.trim();

    if (!isNaN(valor)) {
        var numero = parseInt(valor);

        if (numero >= min && numero <= max) {
            return true;
        } else {
            input.value = valor.substring(0, 0);
        }
    } else {
        input.value = valor.substring(0, 0);
        return false;
    }
}

function verCatalogoResponsivas(){
    pantallaCarga('on');

    const options = { method: "GET" };
    const variables = "";
    const url = "../php/AJAX/catalogoResponsivasAJAX.php"+variables;

        fetch(url, options)
        .then(response => response.json())
        .then(data => {

            pantallaCarga('off');
            
            var tablaCatalogo = document.getElementById('tablaCatalogoResponsivas');
            var contenidoTablaCatalogo = "";
            tablaCatalogo.innerHTML = "<tr></tr>";

            contenidoTablaCatalogo =    "<thead>" +
                                            "<tr class='sticky-top'>" +
                                                "<th class='text-center'>#</th>" +
                                                "<th class='text-center'>Empleado</th>" +
                                                "<th class='text-center'>Creador</th>" +
                                                "<th class='text-center'>Fecha de creación</th>" +
                                                "<th class='text-center'>Firmado</th>" +
                                                "<th class='text-center'>Acción</th>" +
                                            "</tr>" +
                                        "</thead>";

            if(data["bandera"] == 0){
                contenidoTablaCatalogo +=   "<tbody>" +
                                                "<tr>" + 
                                                    "<td class='text-center' colspan='3'>Sin resultados</td>" +
                                                "</tr>" + 
                                            "</tbody>";
            }
            if(data["bandera"] == 1){
                contenidoTablaCatalogo +=   "<tbody>";
                for(punt = 0 ; punt < data['idResponsiva'].length ; punt++){
                    var num = punt + 1;
                    var rutapdf = '../php/responsivas/Responsiva_'+data['idResponsiva'][punt]+'_'+data['usuarioid'][punt]+'.pdf';
                    contenidoTablaCatalogo += "<tr><td class='text-center'>"+num+"</td><td class='text-center'>"+data['nombreUsuario'][punt]+"</td><td class='text-center'>"+data['usuarioid'][punt]+"</td><td class='text-center'>"+data['fechaCreacion'][punt]+"</td><td class='text-center'>"+data['firmado'][punt]+"</td><td class='text-center'><i title='Ver responsiva' id='"+rutapdf+"' onclick='verPdf(this)' data-bs-toggle='tooltip' data-bs-placement='right' class='fa-solid fa-eye fa-lg' style='color: #0033b5;'></i></td></tr>";
                }

                contenidoTablaCatalogo +=   "</tbody>";                       
                                                
            }
            tablaCatalogo.innerHTML = contenidoTablaCatalogo;
        });
}

function verProductos(){
    pantallaCarga('on');

    const options = { method: "GET" };
    const variables = "";
    const url = "../php/AJAX/productosResponsivasAJAX.php"+variables;

    fetch(url, options)
    .then(response => response.json())
    .then(data => {
        
        pantallaCarga('off');
            
        var tablaProductos = document.getElementById('tablaProductosResponsivas');
        var contenidoTablaProductos = "";
        tablaProductos.innerHTML = "<tr></tr>";

        contenidoTablaProductos =   "<thead>" +
                                        "<tr class='sticky-top'>" +
                                            "<th class='text-center'>#</th>" +
                                            "<th class='text-center'>Numero de Parte</th>" +
                                            "<th class='text-center'>Existentes</th>" +
                                            "<th class='text-center'>Precio Por Unidad</th>" +
                                            "<th class='text-center'>Foto</th>" +
                                            "<th class='text-center'>Acción</th>" +
                                        "</tr>" +
                                    "</thead>";

        if(data["bandera"] == 0){
            contenidoTablaProductos +=  "<tbody>" +
                                            "<tr>" + 
                                                "<td class='text-center' colspan='6'>Sin resultados</td>" +
                                            "</tr>" + 
                                        "</tbody>";
        }
        if(data["bandera"] == 1){
            contenidoTablaProductos +=   "<tbody>";
            for(punt = 0 ; punt < data['idProducto'].length ; punt++){
                var num = punt + 1;

                contenidoTablaProductos += "<tr>" +
                                                "<td class='text-center'>"+num+"</td>"+
                                                "<td class='text-center'>"+data['numParte'][punt]+"</td>"+
                                                "<td class='text-center'>"+data['existencias'][punt]+"</td>"+
                                                "<td class='text-center'>"+data['precioUnidad'][punt]+"</td>"+
                                                "<td class='text-center'><img src='"+data['foto'][punt]+"' width='100px'></td>";
                if(data['existencias'][punt] > 0){
                    contenidoTablaProductos +=  "<td class='text-center'>"+
                                                    "<label class='containerCheck'>" + 
                                                       "<input type='checkbox' value='"+data['idProducto'][punt]+"'>" +
                                                       "<div class='checkmark'></div>" +
                                                    "</label>"+
                                                "</td>";
                } else {
                    contenidoTablaProductos += "<td></td>";
                }
                                            "</tr>";
            }
            contenidoTablaProductos +=   "</tbody>";                       
            tablaProductos.innerHTML = contenidoTablaProductos;
        }
    });
}

function verPdf(a){
    
    var iframe = document.getElementById('iframeVerPdf');
    var rutapdf = a.id;

    // $("#modalVerResponsiva").modal('show');   
    document.getElementById("modalResponsivas").style.display = "table";
    iframe.src = rutapdf;
}

// CIERRA EL MODAL
function closeModal() {
	document.getElementById("modalResponsivas").style.display = "none";
	document.getElementById("iframeVerPdf").src = "";
}
