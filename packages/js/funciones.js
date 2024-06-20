// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
        
    pantallaCarga('on');

    // OCULTA TODAS LAS SECCIONES
    document.getElementById("frmRegisterPackages").style.display = 'none';
    document.getElementById("frmPackagesFormation").style.display = 'none';

    // MUESTRA LA SECCION SELECCIONADA
    switch (opcion) {
        case 1:
            document.getElementById("frmRegisterPackages").style.display = 'flex';
            break;
        case 2:
            document.getElementById("frmPackagesFormation").style.display = 'flex';
            break;
        default:
            break;
    }
    pantallaCarga('off');
}

function createPackage()
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