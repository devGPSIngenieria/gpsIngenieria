// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
        
    pantallaCarga('on');

    // OCULTA TODAS LAS SECCIONES
    document.getElementById("quoter").style.display = 'none';

    // MUESTRA LA SECCION SELECCIONADA
    switch (opcion) {
        case 1:
            document.getElementById("quoter").style.display = 'flex';
            break;
        default:
            break;
    }
    pantallaCarga('off');
}

// TRAE LOS PRODUCTOS Y LOS 
function bringProducts(){
    pantallaCarga('on');

    var tabla = document.getElementById('tablaProductosBuscador');
    var contenidoTabla = '';
    tabla.innerHTML = contenidoTabla;

    var frmFiltros = document.getElementById('frmQuoter');
    var numParte = frmFiltros.filtroNParte.value;
    var descripcion = frmFiltros.filtroDescripcion.value;

    if(numParte.trim() != '' || descripcion.trim() != ''){

        const options = { method: "GET" };
        var ruta = "../../tools/php/AJAX/bringProductsAJAX.php?numParte=" + numParte + "&descripcion=" + descripcion;

        fetch(ruta, options)
        .then(response => response.json())
        .then(data => {
            pantallaCarga('off');
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                            '<tr>'+
                                '<th class="text-center">#</th>'+
                                '<th class="text-center">No. de parte</th>'+
                                '<th class="text-center">Descripción</th>'+
                                '<th class="text-center">Precio publico</th>'+
                                '<th class="text-center">Precio venta</th>'+
                                '<th class="text-center">Categoría</th>'+
                                '<th class="text-center">Subcategoría</th>'+
                            '</tr>'+
                        '</thead>';

                    contenidoTabla += '<tbody>';

                    for (var i = 0; i < data["noDatos"]; i++) {

                        var id_producto = data[i]["id_producto"];
                        var no_parte = data[i]["no_parte"];
                        var descripcion = data[i]["descripcion"];
                        var precio_public = data[i]["precio_public"];
                        var precio_venta = data[i]["precio_venta"];
                        var id_categoria = data[i]["id_categoria"];
                        var id_subcategoria = data[i]["id_subcategoria"];
                        var nombre_categoria = data[i]["nombre_categoria"];
                        var nombre_subcategoria = data[i]["nombre_subcategoria"];
                        var indice = i+1;

                        contenidoTabla += `
                            <tr onclick="placeProduct('${encodeURIComponent(id_producto)}', '${encodeURIComponent(no_parte)}', '${encodeURIComponent(descripcion)}', '${encodeURIComponent(precio_public)}')">
                                <td class="text-center">${indice}</td>
                                <td class="text-center">${no_parte}</td>
                                <td class="text-center">${descripcion}</td>
                                <td class="text-center">$${precio_public}</td>
                                <td class="text-center">$${precio_venta}</td>
                                <td class="text-center">${nombre_categoria}</td>
                                <td class="text-center">${nombre_subcategoria}</td>
                            </tr>
                        `;
                }

                    contenidoTabla += '</tbody>';
                    tabla.innerHTML = contenidoTabla;
                }

                if (data["resultado"] == 0) {
                    alertImage('ERROR', 'Surgió un error al buscar', 'error')
                }
            }
        );
    } else {
        pantallaCarga('off');
        tabla.innerHTML = contenidoTabla;
    }
}

function placeProduct(id_producto, no_parte, descripcion, precio_public) {
    var id_producto_decoded = decodeURIComponent(id_producto);
    var no_parte_decoded = decodeURIComponent(no_parte);
    var descripcion_decoded = decodeURIComponent(descripcion);
    var precio_public_decoded = decodeURIComponent(precio_public);

    var tabla = document.getElementById("tablaTemplateCotizador").getElementsByTagName('tbody')[0];

    var nuevaFila = tabla.insertRow();

    var celda1 = nuevaFila.insertCell(0);
    var celda2 = nuevaFila.insertCell(1);
    var celda3 = nuevaFila.insertCell(2);
    var celda4 = nuevaFila.insertCell(3);
    var celda5 = nuevaFila.insertCell(4);
    var celda6 = nuevaFila.insertCell(5);
    var celda7 = nuevaFila.insertCell(6);
    var celda8 = nuevaFila.insertCell(7);

    celda1.textContent = no_parte_decoded;
    celda2.textContent = descripcion_decoded;
    celda3.textContent = "$" + precio_public_decoded;
    celda4.textContent = "";
    celda4.style.backgroundColor = "#d6e7ff";
    celda5.textContent = "$";
    celda6.textContent = "$";
    celda7.textContent = "";
    celda7.style.backgroundColor = "#d6e7ff";
    celda8.textContent = "$";
    celda8.classList.add("precioTotalProducto");

    // AGREGA LA CLASE EDITABLE A LAS CELDAS VACIAS
    var celdas = nuevaFila.querySelectorAll('td');
    celdas.forEach(function(celda) {
        if (celda.textContent.trim() === "") {
            celda.classList.add('editable');
        }
    });

    // AGREGA EVENTO CLIC A LAS CELDAS VACIAS PARA QUE SE PUEDAN EDITAR
    nuevaFila.addEventListener('click', function(event) {
        var target = event.target;
        if (target.classList.contains('editable')) {
            var contenidoAnterior = target.textContent.trim();
            target.textContent = "";
            var input = document.createElement('input');
            input.value = contenidoAnterior;
            input.addEventListener('blur', function() {
                // VALIDA ENTRADA DE INPUT
                var contenidoNuevo = this.value.trim();
                if (/^\d+(\.\d+)?$/.test(contenidoNuevo)) { // EXPRESION REGULAR PARA ENTEROS Y DECIMALES
                    
                    target.textContent = contenidoNuevo;
                    // REALIZA EL CALCULO DEL DESCUENTO
                    calcularDatos();
                } else {
                    target.textContent = "";
                }
            });
            target.appendChild(input);
            input.focus();
        }
    });

    // FUNCION PARA CALCULAR LOS DATOS
    function calcularDatos() {
        var precioRegular = parseFloat(celda3.textContent.replace("$", "") || 0);
        var porcentajeDesc = parseFloat(celda4.textContent || 0);
        var cantidad = parseFloat(celda7.textContent || 1);

        var descuento = (precioRegular * porcentajeDesc) / 100;
        var precioDescuento = precioRegular - descuento;
        var precioTotal = precioDescuento * cantidad;

        celda5.textContent = "$" + descuento.toFixed(2);
        celda6.textContent = "$" + precioDescuento.toFixed(2);
        celda8.textContent = "$" + precioTotal.toFixed(2);
        celda7.textContent = cantidad;

        var SubTotalProductos = document.querySelectorAll(".SubTotalProductos");
        SubTotalProductos[0].textContent = "$" + sumarCeldasConClase('precioTotalProducto').toFixed(2);

        var totalVenta = document.querySelectorAll(".totalVenta");
        totalVenta[0].textContent = "$" + (( (SubTotalProductos[0].textContent).replace("$", "")) * (18.50)).toFixed(2);
        totalVenta
    }

    // SUMA LOS VALORES DE LAS CELDAS CON ESA CLASE 
    function sumarCeldasConClase(clase) {
        var celdasConClase = document.querySelectorAll("." + clase); // Selecciona todas las celdas con la clase especificada
        var suma = 0;

        celdasConClase.forEach(function(celda) {
            var valor = parseFloat(celda.textContent.replace("$", "") || 0); // Parsea el valor de la celda, eliminando el símbolo de "$"
            suma += valor;
        });
    
        return suma;
    }
}

