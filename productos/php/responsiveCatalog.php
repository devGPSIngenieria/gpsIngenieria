<div class="row" id="responsiveCatalog" style="display: none;">

    <div class="card_content text-center">

        <label class="text-subtitle">Catálogo responsivas</label>
        
        <div class="row">

            <div class="row justify-content-center">
                
                <form id="frmFiltrosResponsiveCatalog">
                        
                    <div class="row">

                        <div class="col-sm-12 col-md-3">
                            <!-- FILTRO POR FECHA INICIO-->
                            <div class="inputContainer">
                                <input id="filtroFechaInicio" name="filtroFechaInicio" class="inputField" required="" type="date" placeholder="Filtrar por fecha inicio" onchange="updateResponsiveCatalog()">
                                <label class='usernameLabel' for='filtroFechaInicio'>Fecha inicio</label>
                                <i class="userIcon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <!-- FILTRO POR FECHA FIN-->
                            <div class="inputContainer">
                                <input id="filtroFechaFin" name="filtroFechaFin" class="inputField" required="" type="date" placeholder="Filtrar por fecha fin" onchange="updateResponsiveCatalog()">
                                <label class='usernameLabel' for='filtroFechaFin'>Fecha fin</label>
                                <i class="userIcon fa-solid fa-calendar-days"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <!-- FILTRO POR EMPLEADO -->
                            <div class="inputContainer">
                                <select id="filtroEmpleado" name="filtroEmpleado" class="inputField" required="" type="text" placeholder="Filtrar por empleado" onchange="updateResponsiveCatalog()">
                                    <option value=0 selected>Empleados...</option>
                                    <?php
                                        $conexionEmpleado = new conexion;
                                        $queryEmpleado = "SELECT idempleado, CONCAT(nombre,' ',apellidos) FROM empleados WHERE status = 1";
                                        $empleados = $conexionEmpleado->conn->query($queryEmpleado);

                                        foreach ($empleados->fetch_all() as $index => $empleado) {

                                            print_r("<option value=\"" . $empleado[0] . "\" >" . $empleado[1] . "</option>");
                                        }
                                    ?>
                                </select>
                                <label class='usernameLabel' for='filtroEmpleado'>Empleado</label>
                                <i class="userIcon fa-solid fa-user-tie"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <!-- FILTRO POR FIRMADO -->
                            <div class="inputContainer">
                                <select id="filtroFirmado" name="filtroFirmado" class="inputField" required="" type="text" placeholder="Filtrar por firmado" onchange="updateResponsiveCatalog()">
                                    <option value='0' selected>Sin firmar</option>
                                    <option value='1'>Firmadas</option>
                                </select>
                                <label class='usernameLabel' for='filtroFirmado'>Firmado</label>
                                <i class="userIcon fa-solid fa-signature"></i>
                            </div>
                        </div>

                    </div>  
                </form>

            </div>

            <div class="row justify-content-center">
                <div class="table-responsive">
                    <table id="tableResponsiveCatalog" class="table"></table>
                </div>
            </div>
        </div>
    </div>
</div>