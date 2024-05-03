// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
    pantallaCarga('on');

    // OCULTA TODAS LAS SECCIONES
    document.getElementById("catalogo").style.display = 'none';
    document.getElementById("frmRegistroProductos").style.display = 'none';
    document.getElementById("catalogoEntradas").style.display = 'none';
    document.getElementById("uploadDataProducts").style.display = 'none';
    document.getElementById("generalInventory").style.display = 'none';
    document.getElementById("responsiveCatalog").style.display = 'none';

    // MUESTRA LA SECCION SELECCIONADA
    switch (opcion) {
        case 1:
            document.getElementById("catalogo").style.display = 'flex';
            actualizaCatalogoProductos();
            break;
        case 2:
            document.getElementById("frmRegistroProductos").style.display = 'flex';
            break;
        case 3:
            document.getElementById("catalogoEntradas").style.display = 'flex';
            actualizaCatalogoProductosEntradas();
            break;
        case 4:
            document.getElementById("uploadDataProducts").style.display = 'flex';
            actualizaCatalogoProductosEntradas();
            break;
        case 5:
            document.getElementById("generalInventory").style.display = 'flex';
            actualizaCatalogoInventarioGeneral();
            break;
        case 6:
            document.getElementById("responsiveCatalog").style.display = 'flex';
            updateResponsiveCatalog();
            break;
        default:
            break;
    }
    pantallaCarga('off');
}


// INSERTA UN PRODUCTO
function crearProducto() {

    const formulario = document.getElementById('frmRegistroProductos');
    const formData = new FormData(formulario);

    if (formData.get('nParte') != '' && formData.get('descripcion') != '' && formData.get('precioPublico') != '' && formData.get('precioVenta') && formData.get('categoria') != 0 && formData.get('subcategoria') != 0) {

        pantallaCarga('on');

        const options = {
            method: "POST",
            body: formData,
        };

        fetch("../../productos/php/crearAJAX.php", options)
            .then(response => response.json())
            .then(data => {

                if (data["resultado"]) {
                    alertImage('EXITO', 'Se registró el producto con éxito.', 'success')
                    formulario.reset();
                    actualizaCatalogoProductos();
                    pantallaCarga('off');

                } else {
                    alertImage('ERROR', 'Surgió un error en el registro', 'error')
                    pantallaCarga('off');
                }
            });
    } else {
        alertImage('ERROR', 'Llena todos los campos', 'error')
    }
}

// ACTUALIZA LA TABLA DE PRODUCTOS
function actualizaCatalogoProductos() {

    pantallaCarga('on');

    var tabla = document.getElementById('tablaCatalogoProductos');
    var contenidoTabla = '';
    tabla.innerHTML = contenidoTabla;

    var frmFiltros = document.getElementById('frmFiltosCatalogoProd');
    var numParte = frmFiltros.filtroNParte.value;
    var descripcion = frmFiltros.filtroDescripcion.value;
    var categoria = frmFiltros.filtroCategoria.value;
    var subcategoria = frmFiltros.filtroSubcategoria.value;

    const options = { method: "GET" };
    var ruta = "../../productos/php/traeProductosAJAX.php?numParte=" + numParte + "&descripcion=" + descripcion + "&categoria=" + categoria + "&subcategoria=" + subcategoria;

    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        pantallaCarga('off');
        if (data["resultado"] == 1) {
            
            contenidoTabla = '<thead class="sticky-top">'+
                        '<tr>'+
                            '<th colspan="9"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoProductos", "Catalogo productos", "Productos")\'><i class="fa-solid fa-file-excel fa-xl"></i></div></div></th>'+
                        '</tr>'+
                        '<tr>'+
                            '<th class="text-center">#</th>'+
                            '<th class="text-center">No. de parte</th>'+
                            '<th class="text-center">Descripción</th>'+
                            '<th class="text-center">Precio publico</th>'+
                            '<th class="text-center">Precio venta</th>'+
                            '<th class="text-center">Categoría</th>'+
                            '<th class="text-center">Subcategoría</th>'+
                            '<th></th>'+
                            '<th></th>'+
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

                contenidoTabla += '<tr>';
                    contenidoTabla += '<td class="text-center">'+indice+'</td>';
                    contenidoTabla += '<td class="text-center">'+no_parte+'</td>';
                    contenidoTabla += '<td class="text-center">'+descripcion+'</td>';
                    contenidoTabla += '<td class="text-center">$'+precio_public+'</td>';
                    contenidoTabla += '<td class="text-center">$'+precio_venta+'</td>';
                    contenidoTabla += '<td class="text-center">'+nombre_categoria+'</td>';
                    contenidoTabla += '<td class="text-center">'+nombre_subcategoria+'</td>';
                    contenidoTabla += "<td><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='Editar registro' class='cont-icono-tbl' onclick='abrirModalEditarProducto("+id_producto+", \""+encodeURIComponent(no_parte)+"\", \""+encodeURIComponent(descripcion)+"\", "+precio_public+", "+precio_venta+")'><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td>";
                    contenidoTabla += "<td><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='Agregar registro' class='cont-icono-tbl' onclick='abrirModalRegistrarEntrada("+id_producto+", \""+encodeURIComponent(no_parte)+"\", \""+encodeURIComponent(descripcion)+"\")'><i class='fa-solid fa-plus fa-lg'></i></div></div></td>";
                contenidoTabla += '</tr>';
            }

                contenidoTabla += '</tbody>';
                tabla.innerHTML = contenidoTabla;
            }

            if (data["resultado"] == 0) {
                alertImage('ERROR', 'Surgió un error en el catalogo productos', 'error')
            }
        });
}

// ABRE EL MODAL PARA EDITAR EL PRODUCTO
function abrirModalEditarProducto(id_producto, no_parte, descripcion, precio_public, precio_venta) {

    // Decodificar los valores de no_parte y descripcion
    no_parte = decodeURIComponent(no_parte);
    descripcion = decodeURIComponent(descripcion);

    $("#miModalEditarProducto").modal('show');
    var formulario = document.getElementById("frmModificarProducto");
    formulario.id.value = id_producto;
    formulario.nParte.value = no_parte;
    formulario.descripcion.value = descripcion;
    formulario.precioPublico.value = precio_public;
    formulario.precioVenta.value = precio_venta;
}

// ABRE EL MODAL PARA REGISTRAR ENTRADAS
function abrirModalRegistrarEntrada(idProducto, no_parte, descripcion) {
    // Decodificar los valores de no_parte y descripcion
    no_parte = decodeURIComponent(no_parte);
    descripcion = decodeURIComponent(descripcion);

    Swal.fire({
        title: 'Número de entradas que se harán con ese producto',
        input: 'number',
        inputPlaceholder: 'Ingresa cantidad aquí',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: (number) => {
            // Aquí puedes hacer algo con el valor ingresado por el usuario
            return new Promise((resolve) => {
                setTimeout(() => {
                    if (number > 0 && number < 21) {
                        resolve();
                    } else {
                        resolve(Swal.showValidationMessage('El mínimo para registrar es 1 y máximo 20'));
                    }
                }, 200);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {

        var numProductos = result.value;

        if (numProductos > 0) {

            var sectionCatalogo = document.getElementById('section_catalogo');
            var sectionEntradas = document.getElementById('section_entradas');

            var tabla = document.getElementById('tablaEntradas');

            sectionCatalogo.classList.add('col-md-6');
            sectionEntradas.removeAttribute('hidden');

            var tablaTieneFilas = tabla.rows.length > 0;

            for (var i = 0; i < numProductos; i++) {
                var newRow = tabla.insertRow();
                var indice = i+1;
                // Agregar filas solo si la tabla no tiene filas aún
                if (!tablaTieneFilas) {
                    // Agregar encabezado si es la primera fila
                    var headerRow = tabla.createTHead().insertRow();
                    headerRow.classList.add('sticky-top');
                    headerRow.innerHTML = '<th>#</th><th>No. de parte</th><th>Descripción</th><th></th><th></th>';
                    tablaTieneFilas = true;
                }

                var cell1 = newRow.insertCell(0);
                cell1.textContent = indice;

                var cell2 = newRow.insertCell(1);
                cell2.textContent = no_parte;

                var cell3 = newRow.insertCell(2);
                cell3.textContent = descripcion;

                var cell4 = newRow.insertCell(3);
                cell4.innerHTML = '<div class="inputContainer" style="margin-top:35px">' +
                    '<input name="' + idProducto + '" class="inputField" required="" type="text" placeholder="Escriba el número de serie">' +
                    '<label class="usernameLabel" for="noSerie">No. serie</label>' +
                    '<i class="userIcon fa-solid fa-barcode"></i>' +
                    '</div>';

                var cell5 = newRow.insertCell(4);
                cell5.innerHTML = "<label class='containerCheck contenedorMargen'>" +
                    "<input type='checkbox' id='' onclick='colocaNA(this)'>NA" +
                    "<div class='checkmark'></div>" +
                    "</label>";
            }
        }
    });
}

// COLOCA NA AL CAMPO QUE SE DESEA QUEDAR VACIÓ
function colocaNA(checkbox) {
    // OBTIENE EL ROW DEL CHECKBOX EN LA TABLA
    var row = checkbox.closest("tr");

    // ENCUENTRA EL INPUT EN ESE ROW DEL CHECKBOX
    var input = row.querySelector("input[type='text']");

    if (checkbox.checked) {
        if (input) {
            input.disabled = true;
            input.value = 'NA';
        }
    } else {
        if (input) {
            input.disabled = false;
            input.value = '';
        }
    }
}


function uploadDataProducts() {

    // Obtener el formulario
    const form = document.getElementById("frmExcelUpload");
    // Crear un objeto FormData para recopilar los datos del formulario
    const formData = new FormData(form);
    // Realizar la solicitud Fetch
    fetch("../../productos/php/uploadDataProductsAJAX.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la solicitud");
            }
            return response.json();
        })
        .then(data => {
             console.log("Respuesta del servidor:", data);
             alertImage('Exito', 'Productos Registrados Con Exito', 'success');        })
        .catch(error => {
            // console.error("Error al procesar la solicitud:", error);
            // Aquí puedes manejar el error, como mostrar un mensaje de error al usuario
        });
}

// INSERTA UNA ENTRADA DE PRODUCTO
function insertarEntradaProd() {

    var tablaEntradas = document.getElementById('tablaEntradas');

    // OBTIENE TODAS LAS FILAS MENOS EL ENCABEZADO
    var filas = tablaEntradas.querySelectorAll('tr');

    var indiceColumna = 2; // COLUMNA DE LOS INPUTS

    var hayInputsVacios = false;

    filas.forEach(function (fila) {

        var input = fila.cells[indiceColumna].querySelector('input');

        if (input && input.value.trim() === '') {
            hayInputsVacios = true;
            input.focus(); // ENFOCA AL INPUT VACIÓ
        }
    });

    if (hayInputsVacios) {
        alertImage('ERROR', 'Aún hay campos vacíos, complétalos', 'error');
    } else {
        var inputs = document.querySelectorAll('table input.inputField');

        var arrayEntradas = [];

        inputs.forEach(function (input) {
            var noSerie = input.value;
            var idProd = input.name;
            var entrada = { noSerie: noSerie, idProd: idProd };

            arrayEntradas.push(entrada);
        });

        pantallaCarga('on');

        // Serializar el array como parámetro GET
        var queryString = arrayEntradas.map(function (entrada) {
            return encodeURIComponent('arrayEntradas[]') + '=' + encodeURIComponent(JSON.stringify(entrada));
        }).join('&');

        fetch("../../productos/php/insertarEntradaAJAX.php?" + queryString, { method: "GET" })
            .then(response => response.json())
            .then(data => {

                if (data["resultado"]) {
                    alertImage('EXITO', 'Se registraron las entadas con éxito.', 'success')
                    pantallaCarga('off');
                } else {
                    alertImage('ERROR', 'Surgió un error en los registros', 'error')
                    pantallaCarga('off');
                }

                var sectionCatalogo = document.getElementById('section_catalogo');
                var sectionEntradas = document.getElementById('section_entradas');

                sectionCatalogo.classList.remove('col-md-6');
                sectionEntradas.setAttribute('hidden', 'true');
                var tabla = document.getElementById('tablaEntradas');
                tabla.innerHTML = '';
            });
    }
}

// MODIFICA EL PRODUCTO
function modificarProducto() {

    const formulario = document.getElementById('frmModificarProducto');
    const formData = new FormData(formulario);

    if (formData.get('nParte') != '' && formData.get('descripcion') != '' && formData.get('precioPublico') != '' && formData.get('precioVenta') != '') {

        pantallaCarga('on');

        const options = {
            method: "POST",
            body: formData,
        };

        fetch("../../productos/php/modificarProductoAJAX.php", options)
            .then(response => response.json())
            .then(data => {

                if (data["resultado"]) {
                    $("#miModalEditarProducto").modal('hide');
                    alertImage('EXITO', 'Se modificó el producto con éxito.', 'success')
                    formulario.reset();
                    actualizaCatalogoProductos();
                    pantallaCarga('off');

                } else {
                    alertImage('ERROR', 'Surgió un error en la modificación', 'error')
                    pantallaCarga('off');
                }
            });
    } else {
        alertImage('ERROR', 'Todos los campos deben estar llenos', 'error')
    }
}


function actualizaCatalogoProductosEntradas() {
    var tabla = document.getElementById('tablaCatalogoProductosEntradas');
    var contTabla = '';
    tabla.innerHTML = contTabla;

    var frmFiltros = document.getElementById('frmFiltosCatalogoProdEntradas');
    var numParte = frmFiltros.filtroNParte.value;
    var descripcion = frmFiltros.filtroDescripcion.value;
    var numSerie = frmFiltros.filtroNoSerie.value;
    var numEntrada = frmFiltros.filtroNumEntrada.value;
    var fechaInicio = frmFiltros.filtroFechaInicio.value;
    var fechaFin = frmFiltros.filtroFechaFin.value;
    var checkDetallado = document.getElementById('checkCatalogoEntradasDetallado').checked;

    pantallaCarga('on');
    
    fetch("../../productos/php/traerEntradasAJAX.php?numParte="+numParte+"&descripcion="+descripcion+"&numSerie="+numSerie+"&detallado="+checkDetallado+"&numEntrada="+numEntrada+"&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin, { method: "GET" })
    .then(response => response.json())
    .then(data => {
    
        pantallaCarga('off');

        if(data["detallado"] == 1){ 
            document.getElementById('frmFiltosCatalogoProdEntradas').style.display = "block";
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="6"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoProductosEntradas", "Catalogo entradas detallado", "Entradas detallado")\'><i class="fa-solid fa-file-excel fa-xl"></i></div></div></th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">No. de parte</th>'+
                                        '<th class="text-center">No. serial</th>'+
                                        '<th class="text-center">Descripción</th>'+
                                        '<th class="text-center">Número de entrada</th>'+
                                        '<th class="text-center">Fecha y hora</th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var id_entrada = data[i]["id_entrada"];
                    var no_serial = data[i]["no_serial"];
                    var no_parte = data[i]["no_parte"];
                    var descripcion = data[i]["descripcion"];
                    var num_entrada = data[i]["num_entrada"];
                    var fecha_registro = data[i]["fecha_registro"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
                        contenidoTabla += '<td class="text-center">'+no_parte+'</td>';
                        contenidoTabla += '<td class="text-center">'+no_serial+'</td>';
                        contenidoTabla += '<td class="text-center">'+descripcion+'</td>';
                        contenidoTabla += '<td class="text-center">Entrada '+num_entrada+'</td>';
                        contenidoTabla += '<td class="text-center">'+fecha_registro+'</td>';
                    contenidoTabla += '</tr>';
                }

                contenidoTabla += '</tbody>';
                tabla.innerHTML = contenidoTabla;
            } 

            if(data["resultado"] == 0) {
                // alertImage('ERROR', 'Surgió un error en el catalogo entradas', 'error')
            }
        } else {
            document.getElementById('frmFiltosCatalogoProdEntradas').style.display = "none";

            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="3"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoProductosEntradas", "Catalogo entradas general", "Entradas general")\'><i class="fa-solid fa-file-excel fa-xl"></i></div></div></th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">Número de entrada</th>'+
                                        '<th class="text-center">Fecha y hora</th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var num_entrada = data[i]["num_entrada"];
                    var fecha_registro = data[i]["fecha_registro"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
                        contenidoTabla += '<td class="text-center">Entrada '+num_entrada+'</td>';
                        contenidoTabla += '<td class="text-center">'+fecha_registro+'</td>';
                    contenidoTabla += '</tr>';
                }

                contenidoTabla += '</tbody>';
                tabla.innerHTML = contenidoTabla;
            } 

            if(data["resultado"] == 0) {
                // alertImage('ERROR', 'Surgió un error en el catalogo entradas', 'error')
            }
        }
    });
}

function actualizaCatalogoInventarioGeneral(){
    var tabla = document.getElementById('tablaCatalogoInventarioGeneral');
    var contenidoTabla = '';
    tabla.innerHTML = contenidoTabla;

    var frmFiltros = document.getElementById('frmFiltrosGeneralInventory');
    var numParte = frmFiltros.filtroNParte.value;
    var descripcion = frmFiltros.filtroDescripcion.value;
    var numSerie = frmFiltros.filtroNoSerie.value;
    var fechaInicio = frmFiltros.filtroFechaInicio.value;
    var fechaFin = frmFiltros.filtroFechaFin.value;
    var checkDetallado = document.getElementById('checkInventarioGenDetallado').checked;
    var idsProductos = document.getElementById('idsProductos');

    pantallaCarga('on');
    
    fetch("../../productos/php/traerInventarioGeneralAJAX.php?numParte="+numParte+"&descripcion="+descripcion+"&numSerie="+numSerie+"&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&detallado="+checkDetallado+"&idsProductos="+idsProductos.value, { method: "GET" })
    .then(response => response.json())
    .then(data => {
        pantallaCarga('off');

        if(data["detallado"] == 1){ 
            document.getElementById('frmFiltrosGeneralInventory').style.display = "block";
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="6"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoInventarioGeneral", "Inventario General", "Inventario")\'><i class="fa-solid fa-file-excel fa-xl"></i></div>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">No. de parte</th>'+
                                        '<th class="text-center">No. serial</th>'+
                                        '<th class="text-center">Descripción</th>'+
                                        '<th class="text-center">Fecha y hora</th>'+
                                        '<th class="text-center"></th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var id_inventario = data[i]["id_inventario"];
                    var id_producto = data[i]["id_producto"];
                    var no_serial = data[i]["no_serial"];
                    var no_parte = data[i]["no_parte"];
                    var descripcion = data[i]["descripcion"];
                    var fecha_registro = data[i]["fecha_registro"];
                    var tipo_movimiento = data[i]["tipo_movimiento"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center" hidden>'+id_inventario+'</td>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
                        contenidoTabla += '<td class="text-center">'+no_parte+'</td>';
                        contenidoTabla += '<td class="text-center">'+no_serial+'</td>';
                        contenidoTabla += '<td class="text-center">'+descripcion+'</td>';
                        contenidoTabla += '<td class="text-center">'+fecha_registro+'</td>';
                        contenidoTabla += "<td><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='seleccionar para responsiva' class='cont-icono-tbl' onclick='agregarParaResponsiva(this)'><i class='fa-solid fa-plus fa-lg'></i></div></div></td>";
                    contenidoTabla += '</tr>';
                }

                contenidoTabla += '</tbody>';
                tabla.innerHTML = contenidoTabla;
            } 

            if(data["resultado"] == 0) {
                // alertImage('ERROR', 'Surgió un error en el catalogo entradas', 'error')
            }
        } else {
            document.getElementById('frmFiltrosGeneralInventory').style.display = "none";
    
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="5"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoInventarioGeneral", "Inventario detallado", "Inventario")\'><i class="fa-solid fa-file-excel fa-xl"></i></div></div></th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">No. de parte</th>'+
                                        '<th class="text-center">Descripción</th>'+
                                        '<th class="text-center">Existencias</th>'+
                                        '<th class="text-center" hidden></th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var id_inventario = data[i]["id_inventario"];
                    var existentes = data[i]["existentes"];
                    // var no_serial = data[i]["no_serial"];
                    var no_parte = data[i]["no_parte"];
                    var descripcion = data[i]["descripcion"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center" hidden>'+id_inventario+'</td>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
                        contenidoTabla += '<td class="text-center">'+no_parte+'</td>';
                        // contenidoTabla += '<td class="text-center" hidden>'+no_serial+'</td>';
                        contenidoTabla += '<td class="text-center">'+descripcion+'</td>';
                        contenidoTabla += '<td class="text-center">'+existentes+'</td>';
                        contenidoTabla += "<td hidden><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='seleccionar para responsiva' class='cont-icono-tbl' onclick='agregarParaResponsiva(this)'><i class='fa-solid fa-plus fa-lg'></i></div></div></td>";
                    contenidoTabla += '</tr>';
                }

                contenidoTabla += '</tbody>';
                tabla.innerHTML = contenidoTabla;
            } 

            if(data["resultado"] == 0) {
                // alertImage('ERROR', 'Surgió un error en el catalogo entradas', 'error')
            }
        }
    });
}

function agregarParaResponsiva(fila) {

    // Cambiar el color del botón
    fila.style.display = "none"; // oculta para que ya no se pueda agregar dos veces ese registro

    // Obtener la fila que contiene el botón
    var filaSeleccionada = fila.closest('tr');

    // Clonar la fila seleccionada y todos sus hijos
    var filaClonada = filaSeleccionada.cloneNode(true);

    // Eliminar la última celda de la fila clonada
    filaClonada.deleteCell(-1);

    // Obtener la tabla de destino
    var tablaDestino = document.getElementById('tablaResponsiva');

    var tablaTieneFilas = tablaDestino.rows.length > 0;

    // Agregar filas solo si la tabla no tiene filas aún
    if (!tablaTieneFilas) {
        // Agregar encabezado si es la primera fila
        var headerRow = tablaDestino.createTHead().insertRow();
        headerRow.classList.add('sticky-top');
        headerRow.innerHTML = '<th>No. de parte</th><th>No. serial</th><th>Descripción</th>';
        tablaTieneFilas = true;
    }
    
    // Crear una nueva fila en la tabla de destino
    var newRow = tablaDestino.insertRow();

    // Iterar sobre cada celda de la fila clonada y agregar su contenido a la nueva fila
    for (var i = 0; i < filaClonada.cells.length; i++) {
        var cell = newRow.insertCell();
        cell.textContent = filaClonada.cells[i].textContent;
        
        if (i === 0 || i === 1 || i === 5) {
            cell.classList.add('oculto'); 
        }

        if (i === 0) {
            var idsProductos = document.getElementById('idsProductos');

            if(idsProductos.value != ''){
                idsProductos.value = idsProductos.value + ',' +  filaClonada.cells[i].textContent
            } else {
                idsProductos.value = filaClonada.cells[i].textContent;
            }
        }

        var idsProductos = document.getElementById('idsProductos');
    }

    // Mostrar la sección de la tabla de responsiva
    var sectionInventarioGeneral = document.getElementById('section_inventario_general');
    var sectionInventarioResponsiva = document.getElementById('section_inventario_responsiva');
    sectionInventarioGeneral.classList.add('col-md-6');
    sectionInventarioResponsiva.removeAttribute('hidden');

    actualizaCatalogoInventarioGeneral();
}

function prepararParaResponsiva(){
    var tablaResponsiva = document.getElementById('tablaResponsiva');
    var idsProductos = document.getElementById('idsProductos').value;
    var frmGenResponsiva = document.getElementById('frmEmpleadoResponsable');
    var empleado = frmGenResponsiva.empleado.value;
    var comentarios = frmGenResponsiva.comentarios.value;

    var tablaTieneFilas = tablaResponsiva.rows.length > 0;

    if(empleado == 0 || !tablaTieneFilas){
        if(empleado == 0){
            alertImage('Error', 'Selecciona un empleado para asignar responsiva.', 'error');
        }
        if(!tablaTieneFilas){
            alertImage('Error', 'Selecciona productos del inventario para asignar responsable.', 'error');
        }
    } else {
        pantallaCarga('on');

        const options = { method: "GET" };
        const variables = "?idsProductos="+idsProductos+"&idempleado="+empleado+"&comentarios="+comentarios;
        const url = "../../responsivas/php/AJAX/formatoResponsiva.php"+variables;

        fetch(url, options)
        .then(response => response.json())
        .then(data => {
            
            if (data.rutaPDF) {
                actualizaCatalogoInventarioGeneral();

                tablaResponsiva.innerHTML = "";
                
                var idsProductos = document.getElementById('idsProductos');
                idsProductos.value = "";

                frmGenResponsiva.reset();
                descargarArchivo('../../responsivas/php/responsivas/'+data.rutaPDF, data.rutaPDF);
                // window.open('../../responsivas/php/responsivas/'+data.rutaPDF, '_blank');
            } else if (data.error) {
                console.error(data.error);
            }
            pantallaCarga('off');
        });
    }
    
}

// CATALOGO RESPONSIVAS
function updateResponsiveCatalog(){
    var tabla = document.getElementById('tableResponsiveCatalog');
    var contenidoTabla = '';
    tabla.innerHTML = contenidoTabla;

    var frmFiltros = document.getElementById('frmFiltrosResponsiveCatalog');
    var fechaInicio = frmFiltros.filtroFechaInicio.value;
    var fechaFin = frmFiltros.filtroFechaFin.value;
    var empleado = frmFiltros.filtroEmpleado.value;
    var firmado = frmFiltros.filtroFirmado.value;

    pantallaCarga('on');
    
    fetch("../../productos/php/bringResponsiveAJAX.php?fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&empleado="+empleado+"&firmado="+firmado, { method: "GET" })
    .then(response => response.json())
    .then(data => {
        pantallaCarga('off');

        if (data["resultado"] == 1) {
                
            contenidoTabla = '<thead class="sticky-top">'+
                                '<tr>'+
                                    '<th colspan="6"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tableResponsiveCatalog", "Catálogo responsivas", "responsivas")\'><i class="fa-solid fa-file-excel fa-xl"></i></div>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th class="text-center">#</th>'+
                                    '<th class="text-center">Fecha creación</th>'+
                                    '<th class="text-center">Responsable</th>'+
                                    '<th class="text-center">Firma</th>'+
                                    '<th class="text-center">Comentarios</th>'+
                                    '<th class="text-center">PDF</th>'+
                                '</tr>'+
                            '</thead>';

            contenidoTabla += '<tbody>';
                
            for (var i = 0; i < data["noDatos"]; i++) {
            
                var id_responsiva = data[i]["id_responsiva"];
                var idempleado = data[i]["idempleado"];
                var id_usuariocreador = data[i]["id_usuariocreador"];
                var fecha_creacion = data[i]["fecha_creacion"];
                var nombreResponsable = data[i]["nombreResponsable"];
                var firma = data[i]["firma"];
                var comentarios = data[i]["comentarios"];
                var indice = i+1;

                contenidoTabla += '<tr>';
                    contenidoTabla += '<td class="text-center">'+indice+'</td>';
                    contenidoTabla += '<td class="text-center">'+fecha_creacion+'</td>';
                    contenidoTabla += '<td class="text-center">'+nombreResponsable+'</td>';
                    if(firma == 0){
                        contenidoTabla += '<td class="text-center" style="background-color: #f8b5b5">Sin firmar</td>';
                    } else {
                        contenidoTabla += '<td class="text-center" style="background-color: #baf7b5">Firmada</td>';
                    }
                    contenidoTabla += '<td class="text-center">'+comentarios+'</td>';
                    contenidoTabla += "<td><div class='cont-btn-tabla'><div data-toggle='tooltip' data-placement='top' title='ver pdf' class='cont-icono-tbl' onclick=\"descargarArchivo('../../responsivas/php/responsivas/Responsiva_" + id_responsiva + "_" + id_usuariocreador + ".pdf', 'Responsiva" + id_responsiva + "_" + id_usuariocreador + ".pdf')\"><i class='fa-solid fa-file-pdf fa-xl'></i></div></div></td>";

                contenidoTabla += '</tr>';
            }

            contenidoTabla += '</tbody>';
            tabla.innerHTML = contenidoTabla;
        }
        if(data["resultado"] == 0) {
            
        }
    });
}