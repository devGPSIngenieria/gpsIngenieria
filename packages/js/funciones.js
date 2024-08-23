// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
        
    pantallaCarga('on');

    // OCULTA TODAS LAS SECCIONES
    document.getElementById("frmRegisterPackages").style.display = 'none';
    document.getElementById("frmPackagesFormation").style.display = 'none';
    document.getElementById("frmCatalogoPackages").style.display = 'none';

    // MUESTRA LA SECCION SELECCIONADA
    switch (opcion) {
        case 1:
            document.getElementById("frmRegisterPackages").style.display = 'flex';
            break;
        case 2:
            document.getElementById("frmPackagesFormation").style.display = 'flex';
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
                var categoria = data["paquetes"][i]; // Adjusted to match PHP output
                var descripcion = categoria["descripcion"];
                var precio = categoria["precio_public"];
                var packages = categoria["packages"];

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