<?php
include "../../fGenerales/bd/conexion.php";
include "../../fGenerales/php/funciones.php";

pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Usuarios') ?>
</head>

<?php
    $conexionUsuarios = new conexion;
    $queryUsuarios = "SELECT usuario,nombre,correo,id_usuario FROM usuarios WHERE id_estado=1";
    $resultados = $conexionUsuarios->conn->query($queryUsuarios);

    session_name('gpsingenieria');
    session_start();

    $datos = checarPermisosSeccion($_SESSION['usuarioid']);
?>

<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">

    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">
        
        <div class="col-12">
        
            <?php pintarEncabezado('Usuarios', '<i class="fa-solid fa-users fa-2xl"></i>', '') ?>

            <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                
                <div class="col-12 cont-botones-secciones">
                    <?php
                        foreach ($datos->fetch_all() as $dato) {
                            if ($dato[1] == 1) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo usuarios</span>
                                        </span>
                                    </button>';
                            }
                            if ($dato[1] == 2) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Registro usuarios</span>
                                        </span>
                                    </button>';
                            }
                            if ($dato[1] == 3) {
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(3)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Permisos de secciones</span>
                                        </span>
                                    </button>';
                            }
                        }
                    ?>
                </div>
            </div>
        
            <!-- CATALOGO USUARIOS -->
            <div class="row" id="catalogo" style="display: none;">
                
                <div class="card_content">

                    <div class="row">
                        
                        <div class="col-12 text-center">
                            <label class="text-subtitle">Catálogo de Usuarios</label>
                        </div>
                    
                        <form id="frmFiltosCatalogoUsuarios">
                            <div class="row">

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroNombre" name="filtroNombre" class="inputField" required="" type="text" placeholder="Filtrar por nombre" onkeyup="actualizarUsuarios()">
                                        <label class='usernameLabel' for='filtroNombre'>Nombre</label>
                                        <i class="userIcon fa-solid fa-text-width"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroLogin" name="filtroLogin" class="inputField" required="" type="text" placeholder="Filtrar por login" onkeyup="actualizarUsuarios()">
                                        <label class='usernameLabel' for='filtroLogin'>Login</label>
                                        <i class="userIcon fa-solid fa-user"></i>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-4">
                                    <!-- FILTRO POR NUMERO DE PARTE -->
                                    <div class="inputContainer">
                                        <input id="filtroCorreo" name="filtroCorreo" class="inputField" required="" type="text" placeholder="Filtrar por correo" onkeyup="actualizarUsuarios()">
                                        <label class='usernameLabel' for='filtroCorreo'>Correo</label>
                                        <i class="userIcon fa-solid fa-envelope"></i>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="catalogoUsuarios" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Nombre</th>
                                            <th class="text-center" scope="col">Login</th>
                                            <th class="text-center" scope="col">Correo</th>
                                            <th class="text-center" colspan="2" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--LLENADO LOS DATOS DE LAS TABLAS   -->
                                        <?php
                                            foreach ($resultados->fetch_all() as $columna) {
                                                echo " <tr>
                                                        <td class=\"text-center\">" . $columna[1] . "</td>
                                                        <td class=\"text-center\">" . $columna[0] . "</td>
                                                        <td class=\"text-center\">" . $columna[2] . "</td>
                                                        <td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"abrirModal(" . $columna[3] . ",'" . $columna[1] . "','" . $columna[0] . "','" . $columna[2] . "')\"><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td>
                                                        <td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"eliminarUsuario(" . $columna[3] . ")\"><i class='fa-solid fa-xmark fa-lg'></i></div></div></td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <!-- REGISTRO -->
            <form class="justify-content-center row" id="frmRegistroUsuario" style="display: none;">
                
                <div class="card_content">
                    <div class="row">
                        <div class="col-12 text-center">
                            <label class="text-subtitle">Registro de Usuarios</label>
                        </div>

                        <div class="col-sm-12 col-md-7">
                            <div class="inputContainer">
                                <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba el nombre" maxlength="50" onkeyup="aceptaLetras(this)">
                                <label class='usernameLabel' for='nombre'>Nombre</label>
                                <i class="userIcon fa-solid fa-text-width"></i>
                            </div>
                        </div>
                            
                        <div class="col-sm-12 col-md-5">
                            <div class="inputContainer">
                                <input id="correo" name="correo" class="inputField" required="" type="text" placeholder="Escriba el correo" maxlength="50">
                                <label class='usernameLabel' for='correo'>Correo</label>
                                <i class="userIcon fa-solid fa-envelope"></i>
                            </div>
                        </div>
                            
                        <div class="col-sm-12 col-md-4">
                            <div class="inputContainer">
                                <input id="login" name="login" class="inputField" required="" type="text" placeholder="Escriba nombre de login" maxlength="15" onkeyup="aceptaLetras(this)">
                                <label class='usernameLabel' for='login'>Login</label>
                                <i class="userIcon fa-solid fa-user"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8">
                            <div class="inputContainer">
                                <input type="password" id="password" name="password" class="inputField" required="" placeholder="Escriba la contraseña" maxlength="20">
                                <label class='usernameLabel' for='password'>Contraseña</label>
                                <i class="userIcon fa-solid fa-lock"></i>
                            </div>
                        </div>

                        <div class="contenedor-boton-gen">
                            <div class="main_div">
                                <a onclick="crearUsuario()">GUARDAR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-12">
            <!-- PERMISOS DE USUARIO -->
            <div class="row" id="permisos" style="display: none;">
                <div class="card_content">

                    <div class="col-12 text-center">
                        <label class="text-subtitle">Permisos de Usuarios</label>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="col-sm-12 col-md-6">

                            <?php
                                $cadenaSelect = '<div class="inputContainer">
                                                    <select id="selectUsuarios" name="selectUsuarios" class="inputField" required="" type="text" onchange="cargaPermisos(this.value)" placeholder="Usuario">';

                                $conexionUsuarios = new conexion;
                                $queryUsuarios = "SELECT usuario,nombre,correo,id_usuario FROM usuarios WHERE id_estado=1";
                                $resultados = $conexionUsuarios->conn->query($queryUsuarios);
                                $cadenaSelect = $cadenaSelect . "<option value=\"0\">Usuarios...</option>";
                                while ($fila = $resultados->fetch_row()) {

                                    $cadenaSelect = $cadenaSelect . "<option value=\"" . $fila[3] . "\">" . $fila[1] . "</option>";
                                }
                                $cadenaSelect = $cadenaSelect . "</select>
                                                            <label class='usernameLabel' for='selectUsuarios'>Usuario</label>
                                                            <i class='fa-solid fa-user userIcon'></i>
                                                        </div>";

                                echo $cadenaSelect;
                            ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <div style="margin: 20px;">
                            <div class="col-12 justify-content-center d-flex">

                                <div class="col-6">
                                    <div id="divSeccionPermiso" class="seccionAreas"></div>
                                </div>

                                <div class="col-6">
                                    <div id="divSeccionTipoPermiso" class="seccionAreas"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- MODAL -->
            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <div class="col-12 text-center">
                                <label class="text-subtitle">Modificar Usuario</label>
                            </div>

                            <div class="col-12 text-center">
                                <label class="text-nota">*Ingresa solo el campo que se desea editar.</label>
                            </div>
                            
                            <form id="frmModificar" class="row justify-content-center">
                                <input type="text" id="id" name="id" hidden>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba el nombre" maxlength="50" onkeyup="aceptaLetras(this)">
                                        <label class='usernameLabel' for='nombre'>Nombre</label>
                                        <i class="userIcon fa-solid fa-text-width"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="login" name="login" class="inputField" required="" type="text" placeholder="Escriba nombre del login" maxlength="15" onkeyup="aceptaLetras(this)">
                                        <label class='usernameLabel' for='login'>Login</label>
                                        <i class="userIcon fa-solid fa-user"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input id="correo" name="correo" class="inputField" required="" type="text" placeholder="Escriba el correo" maxlength="50">
                                        <label class='usernameLabel' for='correo'>Correo</label>
                                        <i class="userIcon fa-solid fa-envelope"></i>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="inputContainer">
                                        <input type="password" id="password" name="password" class="inputField" required="" type="text" placeholder="Escriba la contraseña" maxlength="20">
                                        <label class='usernameLabel' for='password'>Contraseña</label>
                                        <i class="userIcon fa-solid fa-lock"></i>
                                    </div>
                                </div>
    
                            </form>

                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="modificarUsuario()">GUARDAR</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <?php pintarFooter(); ?>

</body>

</html>