<div class="row" id="generalInventory" style="display: none;">

<!-- TITULO DEL CONTENIDO -->
<div class="card_content">

    <div class="row">

        <div class="row justify-content-center">
            <form id="frmFiltrosGeneralInventory" style="display: none;">
                    
                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR FECHA INICIO-->
                        <div class="inputContainer">
                            <input id="filtroFechaInicio" name="filtroFechaInicio" class="inputField" required="" type="date" placeholder="Filtrar por fecha inicio" onchange="actualizaCatalogoInventarioGeneral()">
                            <label class='usernameLabel' for='filtroFechaInicio'>Fecha inicio</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR FECHA FIN-->
                        <div class="inputContainer">
                            <input id="filtroFechaFin" name="filtroFechaFin" class="inputField" required="" type="date" placeholder="Filtrar por fecha fin" onchange="actualizaCatalogoInventarioGeneral()">
                            <label class='usernameLabel' for='filtroFechaFin'>Fecha fin</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR NUMERO DE PARTE -->
                        <div class="inputContainer">
                            <input id="filtroNParte" name="filtroNParte" class="inputField" required="" type="text" placeholder="Filtrar por número de parte" onkeyup="actualizaCatalogoInventarioGeneral()">
                            <label class='usernameLabel' for='filtroNParte'>Número de parte</label>
                            <i class="userIcon fa-solid fa-hashtag"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR NUMERO DE SERIE -->
                        <div class="inputContainer">
                            <input id="filtroNoSerie" name="filtroNoSerie" class="inputField" required="" type="text" placeholder="Filtrar por número de serie" onkeyup="actualizaCatalogoInventarioGeneral()">
                            <label class='usernameLabel' for='filtroNoSerie'>Número de serie</label>
                            <i class="userIcon fa-solid fa-barcode"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR DESCRIPCIÓN -->
                        <div class="inputContainer">
                            <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por descripción" onkeyup="actualizaCatalogoInventarioGeneral()">
                            <label class='usernameLabel' for='filtroDescripcion'>Descripción</label>
                            <i class="userIcon fa-solid fa-align-left"></i>
                        </div>
                    </div>

                </div>  
            </form>
            
            <input id="idsProductos" disabled style="display: none;">

            <div id='section_inventario_general' class="col-sm-12 text-center">
                <label class="text-subtitle">Inventario general</label>

                <label class='containerCheck contenedorMargen' style="justify-content: left; margin-left: 20px; width: 200px; color: #899bbd; margin-bottom: 20px;">
                    Inventario detallado
                    <input type='checkbox' id='checkInventarioGenDetallado' onclick='actualizaCatalogoInventarioGeneral();'>
                    <div class='checkmark'></div>
                </label>

                <!-- TABLA DONDE APARECEN LOS PRODUCTOS DEL INVENTARIO -->
                <div class="table-responsive">
                    <table id="tablaCatalogoInventarioGeneral" class="table"></table>
                </div>
            </div>

            <div id='section_inventario_responsiva' class="col-sm-12 col-md-6 text-center" hidden>
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
                            <th>No. serial</th>
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