<?php 
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        pintarHead('Clientes');
    ?>
</head>

<!-- //BUSCANDO Usuarios -->

<?php


$conexionClientes = new conexion;
$queryClientes = "SELECT * FROM clientes ";
$resultados = $conexionClientes->conn->query($queryClientes);

session_name('gpsingenieria');
session_start();

$datos = checarPermisosSeccion($_SESSION['usuarioid']);

?>


<body class="justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">

    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">
   
        <div class="col-12">

            <?php pintarEncabezado('Clientes','<i class="fa-solid fa-people-arrows fa-2xl"></i>', ''); ?>

            <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                <div class="col-12">
                    <?php 
                        foreach($datos->fetch_all() as $dato){
                            if($dato[1]==10){
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo</span>
                                        </span>
                                    </button>';
                            }
                            if($dato[1]==11){
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

            <!-- //botones del menu de usuarios fin-->

            <!-- Tabla de datos Usuarios -->
            <div class="row" id="catalogo" style="display: none;">
                <div class="col-12 text-center">
                    <label class="text-subtitle">Catálogo de usuarios</label>
                </div>
                
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="catalogoClientes" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">Nombre</th>
                                    <th class="text-center" scope="col">Domicilio</th>
                                    <th class="text-center" scope="col">Estado</th>
                                    <th class="text-center" scope="col">Codigo Postal</th>
                                    <th class="text-center" scope="col">Contacto</th>
                                    <th class="text-center" scope="col">Rfc</th>
                                    <th class="text-center" scope="col">Email</th>
                                    <th class="text-center" colspan="2" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <img class="marcaAguaTabla" src="../../src/imagenes/logo.png">
                                <!--LLENADO LOS DATOS DE LAS TABLAS   -->
                                <?php

                                foreach ($resultados->fetch_all() as $columna) {


                                    echo " <tr>
                                        <td class=\"text-center\">" . $columna[1] . " " .$columna[2]."</td>
                                        <td class=\"text-center\">" . $columna[3] . "</td>
                                        <td class=\"text-center\">" . $columna[4] . "</td>
                                        <td class=\"text-center\">" . $columna[5] . "</td>
                                        <td class=\"text-center\">" . $columna[6] . "</td>
                                        <td class=\"text-center\">" . $columna[7] . "</td>
                                        <td class=\"text-center\">" . $columna[8] . "</td>
                                        <td class=\"text-center\"><img src=\"../../src/imagenes/editargps.png\" width=\"50px\" onclick=\"abrirModal(" . $columna[0] . ",'" . $columna[1] . "','" . $columna[2] . "','" . $columna[3] . "','" . $columna[4] . "','" . $columna[5] . "','" . $columna[6] . "','" . $columna[7] . "','" . $columna[8] . "')\"></td>
                                        </tr>";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

        </div>

        <!-- div de registros -->
        <div class="row" id="registros" style="display: none;">
            <div class="col-12 text-center">
                <label class="text-subtitle">Registro de usuarios</label>
            </div>
            
            <div class="col-sm-12">
                <form class="frmRegistroCliente " id="frmRegistroCliente">

                    <div class="inputContainer">
                        <input id="nombres" name="nombres" class="inputField" required="" type="text" placeholder="Escriba el nombre">
                        <label class='usernameLabel' for='nombres'>Nombre</label>
                        <i class="userIcon fa-solid fa-text-width"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="apellidos" name="apellidos" class="inputField" required="" type="text" placeholder="Escriba los apellidos">
                        <label class='usernameLabel' for='apellidos'>Apellidos</label>
                        <i class="userIcon fa-solid fa-text-width"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="domicilio" name="domicilio" class="inputField" required="" type="text" placeholder="Escriba el domicilio">
                        <label class='usernameLabel' for='domicilio'>Domicilio</label>
                        <i class="userIcon fa-solid fa-house-chimney"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="estado" name="estado" class="inputField" required="" type="text" placeholder="Escriba el estado">
                        <label class='usernameLabel' for='estado'>Estado</label>
                        <i class="userIcon fa-solid fa-location-pin"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="codigoPostal" name="codigoPostal" class="inputField" required="" type="text" placeholder="Escriba el código postal">
                        <label class='usernameLabel' for='codigoPostal'>Código postal</label>
                        <i class="userIcon fa-solid fa-signs-post"></i>
                    </div>
 
                    <div class="inputContainer">
                        <input id="contacto" name="contacto" class="inputField" required="" type="text" placeholder="Escriba número de contacto">
                        <label class='usernameLabel' for='contacto'>Contacto</label>
                        <i class="userIcon fa-solid fa-address-book"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="rfc" name="rfc" class="inputField" required="" type="text" placeholder="Escriba el RFC">
                        <label class='usernameLabel' for='rfc'>RFC</label>
                        <i class="userIcon fa-solid fa-address-card"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="email" name="email" class="inputField" required="" type="text" placeholder="Escriba el e-mail">
                        <label class='usernameLabel' for='email'>E-mail</label>
                        <i class="userIcon fa-solid fa-envelope"></i>
                    </div>

                    <div class="contenedor-boton-gen">
                        <div class="main_div">
                            <button onclick="crearCliente()">GUARDAR</button>
                        </div>
                    </div>

                </form>
            </div>
            
        </div>




        <!-- Modal -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Modificar Usuario</label>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frmModificar">
                            <input type="text" id="id" name="id" hidden>
                            <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Escriba sus Nombres">
                        <label>Nombres</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Escriba sus Apellidos">
                        <label>Apellidos</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Escriba su  Domicilio">
                        <label>Domicilio</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="estado" name="estado" placeholder="Escriba su Estado">
                        <label>Estado</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="Escriba su Codigo Postal">
                        <label>Codigo Postal</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Escriba su Codigo Postal">
                        <label>Contacto</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Escriba su RFC">
                        <label>RFC</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="mail" class="form-control" id="email" name="email" placeholder="Escriba su Email">
                        <label>Email</label>
                    </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="modificarCliente()">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <?php pintarFooter()?>

</body>

</html>