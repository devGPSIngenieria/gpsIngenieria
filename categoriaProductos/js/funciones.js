// MUESTRA LA SECCION SELECCIONADA
function abrirSeccion(opcion) {
    
    pantallaCarga('on');

    if (opcion == 1) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogoCategorias").style.display = 'flex';
        document.getElementById("registrosCategorias").style.display = 'none';
        document.getElementById("registrosSubcategorias").style.display = 'none';
        document.getElementById("catalogoSubcategoria").style.display = 'none';
        actualizarCategoria();
        pantallaCarga('off');
    }

    if (opcion == 2) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogoCategorias").style.display = 'none';
        document.getElementById("registrosCategorias").style.display = 'flex';
        document.getElementById("registrosSubcategorias").style.display = 'none';
        document.getElementById("catalogoSubcategoria").style.display = 'none';
        pantallaCarga('off');
    }

    if (opcion == 3) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogoCategorias").style.display = 'none';
        document.getElementById("registrosCategorias").style.display = 'none';
        document.getElementById("registrosSubcategorias").style.display = 'flex';
        document.getElementById("catalogoSubcategoria").style.display = 'none';
        pantallaCarga('off');
    }

    if (opcion == 4) {

        //MOVIENDO LA VISIBILIDAD
        document.getElementById("catalogoCategorias").style.display = 'none';
        document.getElementById("registrosCategorias").style.display = 'none';
        document.getElementById("registrosSubcategorias").style.display = 'none';
        document.getElementById("catalogoSubcategoria").style.display = 'flex';
        actualizarSubcategoria();
        pantallaCarga('off');
    }
}

// CREA LA CATEGORIA
function crearCategoria() {

    var formulario = document.getElementById("frmRegistroCategoria");
    var categoria = formulario.categoria.value;

    if(categoria != ''){
        
        pantallaCarga('on');

        const options = { method: "GET" };

        fetch("../../categoriaProductos/php/crearCategoriaAJAX.php?categoria=" + categoria, options)
        .then(response => response.json())
        .then(data => {

            if (data["resultado"]) {
                actualizarCategoria();
                alertImage('ÉXITO', 'Se registró la categoría correctamente.', 'success');
                pantallaCarga('off');
                document.getElementById('frmRegistroCategoria').reset();

            } else {
                alertImage('ERROR', 'Surgió un error en el registro.', 'error');
                pantallaCarga('off');
            }
        })
    } else {
        alertImage('ERROR', 'Llena el campo para poner una categoría.', 'error');
    }
}

// CREAR SUBCATEGORIA
function crearSubCategoria() {

    var formulario = document.getElementById("frmRegistroSubcategoria");
    var subCategoria = formulario.subcategoria.value;

    if(subCategoria != ''){
        
        pantallaCarga('on');

        const options = { method: "GET" };

        fetch("../../categoriaProductos/php/crearSubcategoriaAJAX.php?subcategoria="+subCategoria, options)
        .then(response => response.json())
        .then(data => {

            if (data["resultado"]) {
                actualizarSubcategoria();
                alertImage('ÉXITO', 'Se registró la subcategoría correctamente.', 'success');
                document.getElementById('frmRegistroSubcategoria').reset();
                pantallaCarga('off');
            } else {
                alertImage('ERROR', 'Surgió un error en el registro.', 'error');
                pantallaCarga('off');
            }
        })
    } else {
        alertImage('Error', 'Llena el campo vació.', 'error');
    }
}

// ACTUALIZA LA TABLA DE LAS CATEGORIAS
function actualizarCategoria() {
    
    pantallaCarga('on');

    var frmFiltros = document.getElementById('frmFiltrosCatalogoCategorias');
    var nombre = frmFiltros.filtroNombre.value;

    const options = { method: "GET" };
    var ruta = "../../categoriaProductos/php/traeCategoriasAJAX.php?nombre="+nombre;
    
    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        
        pantallaCarga('off');

        if (data["resultado"] == 1) {
            var noDatos = data["noDatos"];
            var catalogoCategorias = document.getElementById("tablaCatalogoCategorias");

            catalogoCategorias.innerHTML = "";
            catalogoCategorias.innerHTML = "<thead><tr><th class=\"text-center\" scope=\"col\">Nombre de categoría</th><th class=\"text-center\" colspan=\"1\" scope=\"col\"></th></tr></thead>";

            var cadenaCategorias = "<tbody>";
            for (var i = 0; i < noDatos; i++) {
                var id = data[i]["id"];
                var nombre = data[i]["nombre"];

                cadenaCategorias = cadenaCategorias + " <tr><td class=\"text-center\">" + nombre + "</td><td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"abrirModalCategoria(" + id + ",'" + nombre + "')\"><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td></tr>";
            }

            cadenaCategorias = cadenaCategorias + "</tbody>"
            catalogoCategorias.innerHTML = catalogoCategorias.innerHTML + cadenaCategorias;
        }
    });
}

// ACTUALIZA LA TABLA DE LA SUBCATEGORIA
function actualizarSubcategoria() {

    pantallaCarga('on');

    var frmFiltros = document.getElementById('frmFiltrosCatalogoSubcategorias');
    var nombre = frmFiltros.filtroNombre.value;

    const options = { method: "GET" };
    var ruta = "../../categoriaProductos/php/traeSubcategoriasAJAX.php?nombre="+nombre;
    
    fetch(ruta, options)
    .then(response => response.json())
    .then(data => {
        
        pantallaCarga('off');

        if (data["resultado"] == 1) {
            var noDatos = data["noDatos"];
            var catalogosubcategorias = document.getElementById("tablaCatalogoSubcategorias");

            catalogosubcategorias.innerHTML = "";
            catalogosubcategorias.innerHTML = "<thead><tr><th class=\"text-center\" scope=\"col\">Nombre de subcategoría</th><th class=\"text-center\" colspan=\"1\" scope=\"col\"></th></tr></thead>";

            var cadenaSubcategorias = "<tbody>";
            for (var i = 0; i < noDatos; i++) {
                var id = data[i]["id"];
                var nombre = data[i]["nombre"];

                cadenaSubcategorias = cadenaSubcategorias + " <tr><td class=\"text-center\">" + nombre + "</td><td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"abrirModalSubcategoria(" + id + ",'" + nombre + "')\"><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td></tr>";
            }

            cadenaSubcategorias = cadenaSubcategorias + "</tbody>"
            catalogosubcategorias.innerHTML = catalogosubcategorias.innerHTML + cadenaSubcategorias;
        }
    });
}

// ABRE MODAL PARA EDITAR
function abrirModalCategoria(id, nombre) {
    var formulario = document.getElementById("frmModificarCategoria");
    formulario.id.value = id;
    formulario.nombre.value = nombre;

    $("#modalModificarCategoria").modal('show');
}

// ABRE MODAL PARA EDITAR
function abrirModalSubcategoria(id, nombre) {
    var formulario = document.getElementById("frmModificarSubcategoria");
    formulario.id.value = id;
    formulario.nombre.value = nombre;

    $("#modalModificarSubcategoria").modal('show');
}

// MODIFICA LA CATEGORIA
function modificarCategoria() {

    const data = new FormData(document.getElementById('frmModificarCategoria'));

    if(data.get('nombre') != ''){

        pantallaCarga('on');

        const options = {
            method: "POST",
            body: data
        };

        fetch("../../categoriaProductos/php/modificarCategoriaAJAX.php", options)
        .then(response => response.json())
        .then(data => {

            if (data["resultado"] == 0) {
                alertImage('ERROR', 'La categoría ya se encuentra.', 'error')
                pantallaCarga('off');
            }
            if (data["resultado"] == 1) {
                actualizarCategoria();
                alertImage('EXITO', 'Se modificó exitosamente la categoría.', 'success')
                pantallaCarga('off');
                $('#modalModificarCategoria').modal('hide');
            }
            if (data["resultado"] == 2) {
                alertImage('ERROR', 'Error en la modificación.', 'error')
                pantallaCarga('off');
            }
        })
    } else {
        alertImage('Error', 'Llena el campo vació.', 'error');
    }
}

// MODIFICA LA SUBCATEGORIA
function modificarSubcategoria() {
    
    const data = new FormData(document.getElementById('frmModificarSubcategoria'));
    
    if(data.get('nombre') != ''){
    
        pantallaCarga('on');
        
        const options = {
            method: "POST",
            body: data
        };

        fetch("../../categoriaProductos/php/modificarSubcategoriaAJAX.php", options)
        .then(response => response.json())
        .then(data => {

            if (data["resultado"] == 0) {
                alertImage('ERROR', 'La subcategoría ya se encuentra.', 'error')
                pantallaCarga('off');
            }
            if (data["resultado"] == 1) {
                actualizarSubcategoria();
                alertImage('EXITO', 'Se modificó exitosamente la subcategoría.', 'success')
                pantallaCarga('off');
                $('#modalModificarSubcategoria').modal('hide');
            }
            if (data["resultado"] == 2) {
                alertImage('ERROR', 'Error en la modificación.', 'error')
                pantallaCarga('off');
            }
        })
    } else {
        alertImage('Error', 'Llena el campo vació.', 'error');
    }
}