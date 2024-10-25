<div class="row" id="seccionInvPackages" style="display: none;">

<!-- TITULO DEL CONTENIDO -->
<div class="card_content">

    <div class="row">

        <div class="row justify-content-center">
            <form id="frmFiltrosPackagesInventory" style="display: none;">
                    
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR FECHA INICIO-->
                        <div class="inputContainer">
                            <input id="filtroFechaInicio" name="filtroFechaInicio" class="inputField" required="" type="date" placeholder="Filtrar por fecha inicio" onchange="actualizaCatalogoInventarioPaquetes()">
                            <label class='usernameLabel' for='filtroFechaInicio'>Fecha inicio</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR FECHA FIN-->
                        <div class="inputContainer">
                            <input id="filtroFechaFin" name="filtroFechaFin" class="inputField" required="" type="date" placeholder="Filtrar por fecha fin" onchange="actualizaCatalogoInventarioPaquetes()">
                            <label class='usernameLabel' for='filtroFechaFin'>Fecha fin</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <!-- FILTRO POR NOMBRE DE PAQUETE -->
                        <div class="inputContainer">
                            <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por nombre de paquete" onkeyup="actualizaCatalogoInventarioPaquetes()">
                            <label class='usernameLabel' for='filtroDescripcion'>Nombre de paquete</label>
                            <i class="userIcon fa-solid fa-align-left"></i>
                        </div>
                    </div>

                </div>  
            </form>
            
            <input id="idsProductosPaquetes" disabled style="display: none;">

            <div id='section_inventario_paquetes' class="col-sm-12 text-center">
                <label class="text-subtitle">Inventario de paquetes</label>

                <label class='containerCheck contenedorMargen' style="justify-content: left; margin-left: 20px; width: 200px; color: #899bbd; margin-bottom: 20px;">
                    Inventario detallado
                    <input type='checkbox' id='checkInventarioPaqDetallado' onclick='actualizaCatalogoInventarioPaquetes()'>
                    <div class='checkmark'></div>
                </label>

                <!-- TABLA DONDE APARECEN LOS PRODUCTOS DEL INVENTARIO -->
                <div class="table-responsive">
                    <table id="tablaCatalogoInventarioPaquetes" class="table"></table>
                </div>
            </div>

            <div id='section_inventario_paquetes_responsiva' class="col-sm-12 col-md-6 text-center" hidden>
                <div class="row">
                    <label class="text-subtitle">Productos para responsiva</label>
                </div>
                <div class="row">
                    <label class="text-nota">* Los productos que aqui aparecen serán agregados a la responsiva una vez dando click en continuar</label>
                </div>

                <div class="table-responsive">
                    <table id="tablaResponsiva" class="table">
                        <thead>
                            <th>No. de parte</th>
                            <th>Descripción</th>
                        </thead>
                    </table>
                </div>

                <form id="frmEmpleadoResponsable" class="d-flex justify-content-center">
                    <div class="col-sm-12">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12 col-md-8">
                                <div class="inputContainer">
                                    <select id="empleado" name="empleado" class="inputField" required="" type="text" placeholder="Selecciona empleado">
                                        <option value=0 selected></option>
                                        <?php
                                            $conexionEmpleados = new conexion;
                                            $queryEmpleados = "SELECT idEmpleado, CONCAT(nombre, ' ', apellidos) AS nombre_completo FROM empleados WHERE status=1";
                                            $resultados = $conexionEmpleados->conn->query($queryEmpleados);
                                            
                                            foreach ($resultados->fetch_all() as $index => $empleado) {

                                                print_r("<option value=\"" . $empleado[0] . "\" >" . $empleado[1] . "</option>");
                                            }
                                        ?>
                                    </select>
                                    <label class='usernameLabel' for='filtroCategoria'>Empleado</label>
                                    <i class="userIcon fa-solid fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12 col-md-8">
                                <!-- COMENTARIOS -->
                                <div class="inputContainer">
                                    <textarea id="comentarios" maxlength="80" name="comentarios" class="inputField" required="" placeholder="Agrega comentarios a la responsiva"></textarea>
                                    <label class='usernameLabel' for='comentarios'>Comentarios</label>
                                    <i class="userIcon fa-solid fa-comments"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="contenedor-boton-gen">
                    <div class="main_div">
                        <a onclick="prepararParaResponsiva()">CONTINUAR</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</div>

<style>
    .oculto {
        display: none;
    }
</style>