// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
        
    pantallaCarga('on');

    // OCULTA TODAS LAS SECCIONES
    document.getElementById("frmRegisterPackages").style.display = 'none';
    document.getElementById("seccionInvPackages").style.display = 'none';
    document.getElementById("frmCatalogoPackages").style.display = 'none';

    // MUESTRA LA SECCION SELECCIONADA
    switch (opcion) {
        case 1:
            document.getElementById("frmRegisterPackages").style.display = 'flex';
            break;
        case 2:
            document.getElementById("seccionInvPackages").style.display = 'flex';
            actualizaCatalogoInventarioPaquetes();
            break;
        case 3:
            document.getElementById("frmCatalogoPackages").style.display = 'flex';
            traeCatalogoPackages();
            break;
        default:
            break;
    }
    pantallaCarga('off');
}

function registerPackage() {
    const formulario = document.getElementById('frmRegisterPackages');
    const formData = new FormData(formulario);

    if (formData.get('namePackage') !== '' && formData.get('pricePackage') !== '') {

        // Seleccionar todos los inputs y textareas
        const numeroParteInputs = document.querySelectorAll('.numeroParte-Package');
        const descripcionTextareas = document.querySelectorAll('.descripcion-Package');
        
        // Verifica que ambos NodeLists tengan el mismo número de elementos
        if (numeroParteInputs.length !== descripcionTextareas.length) {
            alertify.error('Error: Los números de parte y descripciones no coinciden.');
            return;
        }

        let banderaVacio = 0;

        // Recorre todos los inputs y textareas
        for (let i = 0; i < numeroParteInputs.length; i++) {
            const numeroParteValue = numeroParteInputs[i].value.trim();
            const descripcionValue = descripcionTextareas[i].value.trim();
            
            if (!numeroParteValue || !descripcionValue) {
                alertify.error(`Fila ${i + 1}: El campo "Número de parte" o "descripción" están vacíos.`);
                banderaVacio = 1;
            }
        }

        if (banderaVacio === 0) {
            // Convertir los valores a arrays
            const numeroParteValues = Array.from(numeroParteInputs).map(input => input.value);
            const descripcionValues = Array.from(descripcionTextareas).map(textarea => textarea.value);

            // Añadir los arrays al FormData
            numeroParteValues.forEach((value, index) => formData.append(`numeroParte[${index}]`, value));
            descripcionValues.forEach((value, index) => formData.append(`descripcion[${index}]`, value));

            pantallaCarga('on');

            const options = {
                method: "POST",
                body: formData
            };

            fetch("../php/AJAX/registerPackageAJAX.php", options)
            .then(response => response.json())
            .then(data => 
            {
                pantallaCarga('off');
                switch (data.bandera)
                {
                    case 0:
                        alertify.error('Error: Ocurrió un error en el sistema, intenta de nuevo.');
                        break;
                    case 1:
                        alertify.success('Éxito: Se registró con éxito el paquete.');
                        document.getElementById('frmRegisterPackages').reset();
                        document.getElementById('containerInputsProducts').innerHTML = "";
                        addInputsProducts();
                        break;
                }
            })
        }
    } else {
        alertify.error('Error: El campo "Nombre del paquete" o "Precio paquete" están vacíos.');
    }
}
function traeCatalogoPackages() {   
    // pantallaCarga('on');

    var frmFiltros = document.getElementById('frmCatalogoPackages');
    var nombre = encodeURIComponent(frmFiltros.filtroNombre.value); // Encode URI component for safety

    const options = { method: "GET" };
    var ruta = '../php/AJAX/catalogPackageAJAX.php?nombre=' + nombre;
    
    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        // pantallaCarga('off');

        if (data["resultado"] === 1) {
            var noDatos = data["noDatos"];
            var catalogoPackages = document.getElementById("tableCatalogPackage");

            catalogoPackages.innerHTML = "";
            var cadenaCategorias = "<tbody>";
            
            for (var i = 0; i < noDatos; i++) {
                var categoria = data["paquetes"][i]; 
                var descripcion = categoria["descripcion"];
                var precio = categoria["precio_public"];
                var packages = categoria["packages"];

                cadenaCategorias += "<tr><th colspan='2' class='text-center' style='height:20px;'><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick='agregarPaqueteFormado(" + JSON.stringify(categoria) + ")' title='Agregar paquete'><i class='fa-solid fa-clipboard-check fa-2xl'></i></div></div></th></tr>";
                cadenaCategorias += "<tr><th colspan='2' class='text-center' style='height:20px;'>" + descripcion + "  ($" + precio + ")</th></tr>";
                
                if (packages.length > 0) {
                    
                    cadenaCategorias += "<tr><th class='text-center' style='height:20px;'>Número de parte</th><th class='text-center' style='height:20px;'>Descripción</th></tr>";

                    for (var j = 0; j < packages.length; j++) {
                        var numeroParte = packages[j]["numero_parte"];
                        var descripcion = packages[j]["descripcion"];
                        
                        cadenaCategorias += "<tr style='background: #d5fccf;'><td class='text-center'>" + numeroParte + "</td><td class='text-center'>" + descripcion + "</td></tr>";
                    }

                } else {
                    cadenaCategorias += "<tr><td colspan='2' class='text-center' style='height:20px; background: #d5fccf;'>Paquete sin productos aún</td></tr>";
                }
                
                cadenaCategorias += "<tr><td colspan='2' style='height:50px; background: #ffffff;'></td></tr>";
            }

            cadenaCategorias += "</tbody>";
            catalogoPackages.innerHTML = catalogoPackages.innerHTML + cadenaCategorias;
        }
    });
}

function agregarPaqueteFormado(data)
{
//------------------------------------------------------------------
//          J.S.V
//          08/08/2024
//          DESCRIPCION:
//              Función para agregar los paquetes que están en
//              el catálogo de paquetes.
//              
//          versión.función - v.1.0    
//------------------------------------------------------------------
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            // console.log(data);
    Swal.fire({
        title: 'Número de paquetes que quieres agregar',
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

        var tablePaqAdd = document.getElementById('table-agregar-paquetes');
        var contTable =  '';
        tablePaqAdd.innerHTML = contTable;

        var numPaquetes = result.value;

        if(numPaquetes > 0)
        {
            for(var x = 0 ; x < numPaquetes ; x++)
            {
                var descripcion = data["descripcion"];
                var precio = data["precio_public"];
                var packages = data["packages"];
                var idProd = data["id_producto"];

                contTable += "<thead>";
                    contTable += "<tr>";
                        contTable += "<th colspan='3'>" + descripcion + "  ($" + precio + ")</th>";
                    contTable += "</tr>";
                    contTable += "<tr>";
                        contTable += "<th>Número de parte</th>";
                        contTable += "<th>Descripción</th>";
                        contTable += "<th>Selección</th>";
                    contTable += "</tr>";
                contTable += "</thead>";

                contTable += "<tbody>";
                    for(var i = 0 ; i < packages.length ; i++)
                    {
                        var package = packages[i];
                        var idPodPackage = package["id_prod_paq"];

                        // Crea un array con los parámetros y conviértelo a JSON
                        var valueArray = [x, idProd, idPodPackage];
                        var jsonValue = JSON.stringify(valueArray);

                        contTable += "<tr>";
                            contTable += "<td style='background: #d5fccf;'>" + package["numero_parte"] + "</td>";
                            contTable += "<td style='background: #d5fccf;'>" + package["descripcion"] + "</td>";
                            // En el value el primer valor es la pasada del for, el segundo es el id del producto y el tercero es el id del producto del paquete
                            contTable += "<td style='background: #d5fccf;'><input type='checkbox' class='checkbox-package-add' value='"+jsonValue+"'></td>";
                        contTable += "</tr>";
                    }
                    contTable += "<tr>";
                        contTable += "<td colspan='3' style='height:50px; background: #ffffff;'></td>";
                    contTable += "</tr>";
                contTable += "</tbody>";
            }
            tablePaqAdd.innerHTML = contTable;
            myModal.show();
        }
    });
}

function guardarSeleccionPackages()
{
//------------------------------------------------------------------
//          J.S.V
//          08/08/2024
//          DESCRIPCION:
//              Función para traer todos los checkbox que el
//              usuario selecciono, los cuales traen el id 
//              del producto y el id del producto del paquete.
//              
//          versión.función - v.1.0    
//------------------------------------------------------------------

    // Obtiene todos los checkboxes con la clase 'checkbox-package-add'
    const checkboxes = document.querySelectorAll('.checkbox-package-add');

    // Array para almacenar los valores de los checkboxes seleccionados
    const selectedValues = [];

    // Variable para verificar si al menos un checkbox está seleccionado
    let isAnyChecked = false;
    
    // Recorre todos los checkboxes
    checkboxes.forEach(checkbox => {
        // Verifica si el checkbox está seleccionado
        if (checkbox.checked) {
            // Añade el valor del checkbox al array
            selectedValues.push(checkbox.value);
            isAnyChecked = true;  // Marca que al menos uno está seleccionado
        }
    });
    
    // Si ninguno está seleccionado, muestra una advertencia
    if (!isAnyChecked) {
        alertify.warning('Debes seleccionar las casillas que desees para tu paquete.');
    }
    else
    {
        const options = { method: "GET" };
        var ruta = '../php/AJAX/insertaPaqueteInvAJAX.php?array=' + selectedValues;
        
        pantallaCarga('on');

        fetch(ruta, options)
        .then(response => response.json())
        .then(data => {
            pantallaCarga('off');
            $('#exampleModal').modal('hide');
            switch(data['bandera']){

                case 0:
                    alertify.error('Ocurrió un error en el sistema, contacta con el administrador.');
                    break;

                    case 1:
                        alertify.success('Se registraron los paquetes al inventario correctamente.');
                        break;

                        case 3:
                            alertify.error('No existe nada en el inventario, el paquete no se registro correctamente.');
                            break;
            }

        });
    }
}

function createPackage()
{
    const formulario = document.getElementById('frmPackagesFormation');
    const formData = new FormData(formulario);

    if (formData.get('nParte') != '' && formData.get('filtroPackage') != 0 && formData.get('descripcion') != '') 
    {
        pantallaCarga('on');

        const options = 
        {
            method: "POST",
            body: formData,
        };

        fetch("../php/AJAX/createPackageAJAX.php", options)
            .then(response => response.json())
            .then(data => {

                if (data["resultado"]) {
                    alertImage('EXITO', 'Se registró el paquete con éxito.', 'success')
                    formulario.reset();
                    pantallaCarga('off');

                } else {
                    alertImage('ERROR', 'Surgió un error en el registro', 'error')
                    pantallaCarga('off');
                }
            });
    } 
    else 
    {
        alertImage('ERROR', 'Llena todos los campos', 'error')
    }
}


function addInputsProducts() 
{
    const container = document.getElementById('containerInputsProducts');
    
    const inputGroup = document.createElement('div');
    inputGroup.className = 'row d-flex justify-content-center input-group';

    // Crea el input para el número de parte
    const col1 = document.createElement('div');
    col1.className = 'col-sm-12 col-md-6';
    col1.innerHTML = `
        <div class="inputContainer">
            <input class="inputField numeroParte-Package" required="" type="text" placeholder="Escriba el número de parte" maxlength="50">
            <label class='usernameLabel' for='nParte'>Número de parte</label>
            <i class="userIcon fa-solid fa-hashtag"></i>
        </div>
    `;

    // Crea el textarea para la descripción
    const col2 = document.createElement('div');
    col2.className = 'col-sm-12 col-md-6';
    col2.innerHTML = `
        <div class="inputContainer">
            <textarea class="inputField descripcion-Package" required="" placeholder="Escriba descripción" maxlength="200"></textarea>
            <label class='usernameLabel' for='descripcion'>Descripción</label>
            <i class="userIcon fa-solid fa-align-left"></i>
        </div>
    `;

    inputGroup.appendChild(col1);
    inputGroup.appendChild(col2);
    container.appendChild(inputGroup);
}

function actualizaCatalogoInventarioPaquetes()
{
//------------------------------------------------------------------
//          J.S.V
//          08/08/2024
//          DESCRIPCION:
//              Función para actualizar el inventario de paquetes.
//              
//          versión.función - v.1.0    
//------------------------------------------------------------------   
    var tabla = document.getElementById('tablaCatalogoInventarioPaquetes');
    var contenidoTabla = '';
    tabla.innerHTML = contenidoTabla;

    var frmFiltros = document.getElementById('frmFiltrosPackagesInventory');
    var descripcion = frmFiltros.filtroDescripcion.value;
    var fechaInicio = frmFiltros.filtroFechaInicio.value;
    var fechaFin = frmFiltros.filtroFechaFin.value;
    var checkDetallado = document.getElementById('checkInventarioPaqDetallado').checked;
    var idsProductos = document.getElementById('idsProductosPaquetes');

    // pantallaCarga('on');

    fetch("../php/AJAX/traeInventarioPaquetesAJAX.php?descripcion="+descripcion+"&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin+"&detallado="+checkDetallado+"&idsProductos="+idsProductos.value, { method: "GET" })
    .then(response => response.json())
    .then(data => {
        // pantallaCarga('off');

        if(data["detallado"] == 1){ 
            document.getElementById('frmFiltrosPackagesInventory').style.display = "block";
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="6"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoInventarioGeneral", "Inventario General", "Inventario")\'><i class="fa-solid fa-file-excel fa-xl"></i></div>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">Nombre paquete</th>'+
                                        '<th class="text-center">Fecha y hora</th>'+
                                        '<th class="text-center"></th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var id_inventario = data[i]["id_inventario"];
                    var id_producto = data[i]["id_producto"];
                    var descripcion = data[i]["descripcion"];
                    var fecha_registro = data[i]["fecha_registro"];
                    var tipo_movimiento = data[i]["tipo_movimiento"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center" hidden>'+id_inventario+'</td>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
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
            document.getElementById('frmFiltrosPackagesInventory').style.display = "none";
    
            if (data["resultado"] == 1) {
                
                contenidoTabla = '<thead class="sticky-top">'+
                                    '<tr>'+
                                        '<th colspan="5"><div class="cont-btn-tabla"><div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#00a85a" class="cont-icono-tbl" onclick=\'exportarTablaExcel("tablaCatalogoInventarioGeneral", "Inventario detallado", "Inventario")\'><i class="fa-solid fa-file-excel fa-xl"></i></div></div></th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="text-center">#</th>'+
                                        '<th class="text-center">Nombre paquete</th>'+
                                        '<th class="text-center">Existencias</th>'+
                                        '<th class="text-center" hidden></th>'+
                                    '</tr>'+
                                '</thead>';

                contenidoTabla += '<tbody>';
                
                for (var i = 0; i < data["noDatos"]; i++) {
                
                    var id_inventario = data[i]["id_inventario"];
                    var existentes = data[i]["existentes"];
                    var descripcion = data[i]["descripcion"];
                    var indice = i+1;

                    contenidoTabla += '<tr>';
                        contenidoTabla += '<td class="text-center" hidden>'+id_inventario+'</td>';
                        contenidoTabla += '<td class="text-center">'+indice+'</td>';
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