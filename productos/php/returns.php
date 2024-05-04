<div class="row" id="returnsCatalog" style="display: none;">

    <!-- TITULO DEL CONTENIDO -->
    <div class="card_content">

        <div class="row">

            <form id="frmFiltrosReturnsCatalog">
                    
                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR FECHA INICIO-->
                        <div class="inputContainer">
                            <input id="filtroFechaInicio" name="filtroFechaInicio" class="inputField" required="" type="date" placeholder="Filtrar por fecha inicio" onchange="getReturns()">
                            <label class='usernameLabel' for='filtroFechaInicio'>Fecha inicio</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR FECHA FIN-->
                        <div class="inputContainer">
                            <input id="filtroFechaFin" name="filtroFechaFin" class="inputField" required="" type="date" placeholder="Filtrar por fecha fin" onchange="getReturns()">
                            <label class='usernameLabel' for='filtroFechaFin'>Fecha fin</label>
                            <i class="userIcon fa-solid fa-calendar-days"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <!-- FILTRO POR NUMERO DE PARTE -->
                        <div class="inputContainer">
                            <input id="filtroNParte" name="filtroNParte" class="inputField" required="" type="text" placeholder="Filtrar por número de parte" onkeyup="getReturns()">
                            <label class='usernameLabel' for='filtroNParte'>Número de parte</label>
                            <i class="userIcon fa-solid fa-hashtag"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR DESCRIPCIÓN -->
                        <div class="inputContainer">
                            <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por descripción" onkeyup="getReturns()">
                            <label class='usernameLabel' for='filtroDescripcion'>Descripción</label>
                            <i class="userIcon fa-solid fa-align-left"></i>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <!-- FILTRO POR NUMERO DE SERIE -->
                        <div class="inputContainer">
                            <input id="filtroNoSerie" name="filtroNoSerie" class="inputField" required="" type="text" placeholder="Filtrar por número de serie" onkeyup="getReturns()">
                            <label class='usernameLabel' for='filtroNoSerie'>Número de serie</label>
                            <i class="userIcon fa-solid fa-barcode"></i>
                        </div>
                    </div>

                </div>  
            </form>

            <div id='section_returns_catalog' class="col-sm-12 text-center">
                <label class="text-subtitle">Catálogo devoluciones</label>

                <!-- TABLA DONDE APARECEN LOS PRODUCTOS DEL INVENTARIO -->
                <div class="table-responsive">
                    <table id="tablaReturns" class="table"></table>
                </div>
            </div>

        </div>
    </div>

</div>