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

function registerPackage()
{
    const formulario = document.getElementById('frmRegisterPackages');
    const formData = new FormData(formulario);

    if (formData.get('namePackage') != '' && formData.get('pricePackage') != '') 
    {
        pantallaCarga('on');

        const options = 
        {
            method: "POST",
            body: formData,
        };

        fetch("../php/AJAX/registerPackageAJAX.php", options)
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

function traeCatalogoPackages() {   
    pantallaCarga('on');

    var frmFiltros = document.getElementById('frmCatalogoPackages');
    var nombre = frmFiltros.filtroNombre.value;

    const options = { method: "GET" };
    var ruta = '../php/AJAX/catalogPackageAJAX.php?nombre=' + nombre;
    
    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        
        pantallaCarga('off');

        if (data["resultado"] == 1) {
            var noDatos = data["noDatos"];
            var catalogoPackages = document.getElementById("tableCatalogPackage");

            catalogoPackages.innerHTML = "";
            var cadenaCategorias = "<tbody>";
            
            for (var i = 0; i < noDatos; i++) {
                var categoria = data["categorias"][i];
                var nombre = categoria["nombre"];
                var price = categoria["price"];
                var packages = categoria["packages"];

                cadenaCategorias += "<tr><th colspan='2' class='text-center' style='height:20px;'>" + nombre + "  ($" + price + ")</th></tr>";
                
                if (packages.length > 0) {
                    
                    cadenaCategorias += "<tr><th class='text-center' style='height:20px;'>Número de parte</th><th class='text-center' style='height:20px;'>Descripción</th></tr>";

                    for (var j = 0; j < packages.length; j++) {

                        var no_parte = packages[j]["no_parte"];
                        var descripcion = packages[j]["descripcion"];
                        
                        cadenaCategorias += "<tr style='background: #d5fccf;'><td class='text-center'>" + no_parte + "</td><td class='text-center'>" + descripcion + "</td></tr>";
                    }

                } else {

                    cadenaCategorias += "<tr><td colspan='2' class='text-center' style='height:20px; background: #d5fccf;'>Paquete sin productos aún</td></tr>";
                }
                
                cadenaCategorias += "<tr><td colspan='2' style='height:50px; background: #ffffff;''></td></tr>";
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