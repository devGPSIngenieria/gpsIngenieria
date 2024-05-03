<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";

    pantallaCarga('on');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php pintarHead('Servicios') ?>
</head>

<!-- //BUSCANDO Productos -->

<?php

$conexionServicios = new conexion;
$queryServicios = "SELECT * FROM servicios";
$resultados = $conexionServicios->conn->query($queryServicios);

session_name('gpsingenieria');
session_start();

$datos = checarPermisosSeccion($_SESSION['usuarioid']);

?>


<body class=" justify-content-center align-items-center" onload="document.getElementById('pantallaCarga').style.display='none'">
    
    <!-- NAVBAR -->
    <?php pintarNavBar(); ?>

    <div class="contenedorCont">
        
        <div class="col-12">

            <?php pintarEncabezado('Servicios','<i class="fa-solid fa-toolbox fa-2xl"></i>', '')?>
            
            <div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">

                <div class="col-12">

                    <?php 
                        foreach($datos->fetch_all() as $dato){
                            if($dato[1]==12){
                                echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                                        <span class="button_lg">
                                            <span class="button_sl"></span>
                                            <span class="button_text">Catálogo</span>
                                        </span>
                                    </button>';
                            }
                            if($dato[1]==13){
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

            <div class="row" id="catalogo" style="display: none;">

                <div class="col-12 text-center">
                    <label class="text-subtitle">Catálogo de servicios</label>
                </div>
                
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="catalogoServicios" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">Nombre</th>
                                    <th class="text-center" scope="col">Descripción</th>
                                    <th class="text-center" scope="col">Precio</th>
                                    <th class="text-center" colspan="2" scope="col"></th>
                                    <th class="text-center" colspan="6" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <img class="marcaAguaTabla" src="../../src/imagenes/logo.png">
                                <!--LLENADO LOS DATOS DE LAS TABLAS   -->
                                <?php
                                    foreach ($resultados->fetch_all() as $columna) {
                                        echo " <tr>
                                            <td class=\"text-center\">" . $columna[1] . "</td>
                                            <td class=\"text-center\">" . $columna[2] . "</td>
                                            <td class=\"text-center\">" . $columna[3] . "</td>
                                            <td class=\"text-center\"><img src=\"../../src/imagenes/editargps.png\" width=\"50px\" onclick=\"abrirModal(" . $columna[0] . ",'" . $columna[1] . "','" . $columna[2] . "','" . $columna[3] . "')\"></td>
                                            
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
                <label class="text-subtitle">Registro de productos</label>
            </div>

            <div class="col-12">
                <form class="frmRegistroServicio" id="frmRegistroServicio">

                    <div class="inputContainer">
                        <input id="nombre" name="nombre" class="inputField" required="" type="text" placeholder="Escriba el nombre">
                        <label class='usernameLabel' for='nombre'>Nombre</label>
                        <i class="userIcon fa-solid fa-text-width"></i>
                    </div>

                    <div class="inputContainer">
                        <textarea id="descripcion" name="descripcion" class="inputField" required="" type="text" placeholder="Escriba la descripción"></textarea>
                        <label class='usernameLabel' for='descripcion'>Descripción</label>
                        <i class="userIcon fa-solid fa-text-width"></i>
                    </div>

                    <div class="inputContainer">
                        <input id="precio" name="precio" class="inputField" required="" type="number" placeholder="Escriba el precio">
                        <label class='usernameLabel' for='precio'>Precio</label>
                        <i class="userIcon fa-solid fa-dollar-sign"></i>
                    </div>

                    <div class="contenedor-boton-gen">
                        <div class="main_div">
                            <button onclick="crearNuevoElemento()">GUARDAR</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-1"></div>
        </div>
        <!-- div de registros -->







        <!-- Modal -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Modificar Servicio</label>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frmModificar">
                            <input type="text" id="id" name="id" hidden>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escriba el Numero de Parte">
                                <label>Nombre</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escriba una Descripcion"></textarea>
                                <label>Descripcion</label>
                            </div>
                        

                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Coloque el Maximo">
                                <label>Precio</label>
                            </div>

                
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="modificarUsuario()">Guardar</button>
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