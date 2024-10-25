<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Empleados') ?>
</head>

<!-- CONSULTA PARA TRAER LOS EMPLEADOS -->
<?php
    $conexionEmpleados = new conexion;
    $queryEmpleados = "SELECT idEmpleado,nombre,apellidos,correo,telefono,puesto FROM empleados WHERE status=1";
    $resultados = $conexionEmpleados->conn->query($queryEmpleados);

    // CHECA LOS PERMISOS DEL USUARIO PARA ESTAS SECCIONES

    session_name('gpsingenieria');
    session_start();

    $datos = checarPermisosSeccion($_SESSION['usuarioid']);
?>

<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
    
    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>
        
        <div class="col-12">

            <?php pintarEncabezado('Empleados','<i class="fa-solid fa-user fa-2xl"></i>',''); ?>

            <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                
                <div class="col-12 cont-botones-secciones">
                    <?php 
                        foreach($datos->fetch_all() as $dato){
                    
                            if($dato[1]==11){
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo</span>
                                        </span>
                                    </button>';
                            }
            
                            if($dato[1]==12){
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Registro</span>
                                        </span>
                                    </button>';
                            }                              
                        }                                      
                    ?>                    
                </div>
            </div>

            <!-- TABLA DONDE SE VEN LOS EMPLEADOS -->
            <div class="row" id="catalogo" style="display: none;">

                <div class="card_content">
                
                    <div class="col-12 text-center">
                        <label class="text-subtitle">Catálogo de empleados</label>
                    </div>
                    
                    <div class="col-12">
                        <div class="table-responsive">

                            <table id="catalogoEmpleados" class="table table-hover">
                                <!-- ENCABEZADO DE LA TABLA EMPLEADOS-->
                                <thead>
                                    <tr class="sticky-top">
                                        <th class="text-center" scope="col">Nombre</th>
                                        <th class="text-center" scope="col">Correo</th>
                                        <th class="text-center" scope="col">Telefono celular</th>
                                        <th class="text-center" scope="col">Puesto</th>
                                        <th class="text-center" colspan='2' scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <!-- CONTENIDO DE LA TABLA EMPLEADOS -->
                                <tbody>
                                    <?php
                                        foreach ($resultados->fetch_all() as $columna) {
                                            echo " <tr>
                                                <td class=\"text-center\">" . $columna[1] . " " . $columna[2] . "</td>
                                                <td class=\"text-center\">" . $columna[3] . "</td>
                                                <td class=\"text-center\">" . $columna[4] . "</td>
                                                <td class=\"text-center\">" . $columna[5] . "</td>
                                                <td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"abrirModal(" . $columna[0] . ",'" . $columna[1] . "','" . $columna[2] . "','" . $columna[3] . "','" . $columna[4] . "','" . $columna[5] . "')\"><i class='fa-solid fa-pen-to-square fa-lg'></i></div></div></td>
                                                <td><div class='cont-btn-tabla'><div class='cont-icono-tbl' onclick=\"eliminarUsuario(" . $columna[0] . ")\"><i class='fa-solid fa-trash fa-lg'></i></div></div></td>
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
        

        <div class="col-12">
            <!-- FORMULARIO PARA REGISTRAR EMPLEADO -->
            <div id="registros" style="display: none;">
                
                <div class="card_content">
                    <form class="justify-content-center" id="frmRegistroEmpleados">
                   
                        <div class="row">
                            <div class="col-12 text-center">
                                <label class="text-subtitle">Registro de empleados</label>
                            </div>
                            
                            <div class="col-sm-12 col-md-6">
                                <div class="inputContainer">
                                    <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba el nombre">
                                    <label class='usernameLabel' for='nombre'>Nombre</label>
                                    <i class="userIcon fa-solid fa-text-width"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <div class="inputContainer">
                                    <input id="apellidos" name="apellidos" class="inputField" required="" type="text" placeholder="Escriba los apellidos">
                                    <label class='usernameLabel' for='apellidos'>Apellidos</label>
                                    <i class="userIcon fa-solid fa-text-width"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="inputContainer">
                                    <input id="correo" name="correo" class="inputField" required="" type="text" placeholder="Escriba E-mail">
                                    <label class='usernameLabel' for='correo'>E-mail</label>
                                    <i class="userIcon fa-solid fa-envelope"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="inputContainer">
                                    <input id="TelefonoCelular" name="TelefonoCelular" class="inputField" required="" type="number" placeholder="Escriba el teléfono celular">
                                    <label class='usernameLabel' for='TelefonoCelular'>Teléfono celular</label>
                                    <i class="userIcon fa-solid fa-phone"></i>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="inputContainer">
                                    <input id="puesto" name="puesto" class="inputField" required="" type="text" placeholder="Escriba el puesto">
                                    <label class='usernameLabel' for='puesto'>Puesto</label>
                                    <i class="userIcon fa-solid fa-person-circle-question"></i>
                                </div>
                            </div>
                    
                            <div class="contenedor-boton-gen">
                                <div class="main_div">
                                    <a onclick="crearEmpleado()">GUARDAR</a>
                                </div>
                            </div>
                    
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

        <section>
            <!-- MODAL PARA EDITAR LOS EMPLEADOS -->
            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Modificar Empleado</label>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frmModificar">
                                <input type="text" id="id" name="id" hidden>
                                <label for="nombre">Nombre :</label><input class="form-control" type="text" id="nombre" name="nombre">
                                <label for="apellidos">Apellidos :</label><input class="form-control" type="text" id="apellidos" name="apellidos">
                                <label for="correo">Correo :</label><input class="form-control" type="text" id="correo" name="correo">
                                <label for="telefonoCelular">Telefono Celular :</label> <input class="form-control" type="text" id="telefonoCelular" name="telefonoCelular">
                                <label for="puesto">Puesto :</label> <input class="form-control" type="text" id="puesto" name="puesto">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="modificarEmpleado()">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <?php pintarFooter()?>
</body>

</html>