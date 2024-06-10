<div class="row" id="quoter" style="display: none;">
    <div class="card_content">
                    
        <form id="frmQuoter">

            <div class="row">

                <div class="col-sm-12 col-md-6">
                    <!-- FILTRO POR NUMERO DE PARTE -->
                    <div class="inputContainer">
                        <input id="filtroNParte" name="filtroNParte" class="inputField" required="" type="text" placeholder="Filtrar por número de parte" onkeyup="bringProducts()">
                        <label class='usernameLabel' for='filtroNParte'>Número de parte</label>
                        <i class="userIcon fa-solid fa-hashtag"></i>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <!-- FILTRO POR DESCRIPCIÓN -->
                    <div class="inputContainer">
                        <input id="filtroDescripcion" name="filtroDescripcion" class="inputField" required="" type="text" placeholder="Filtrar por descripción" onkeyup="bringProducts()">
                        <label class='usernameLabel' for='filtroDescripcion'>Descripción</label>
                        <i class="userIcon fa-solid fa-align-left"></i>
                    </div>
                </div>

            </div>
        </form>

        <div class="table-responsive">
            <table class="table" id="tablaTemplateCotizador" style="text-align: center;">
                <thead>
                    <tr><th colspan="8" style="background-color: #FFFFFF !important;">  <img src="../../src/imagenes/djiAgriculture.png" alt="imagen dji agriculture" width="100px"></th></tr>
                    <tr><th colspan="8" style="height:35px; text-align: right;">Fecha: <?php echo date('Y-d-m');?></th></tr>
                    <tr>
                        <th colspan="8" style="height:35px; background-color: #55A447 !important;">
                            <div class="cont-btn-tabla">
                                <div data-toggle="tooltip" data-placement="top" title="Exportar a excel" style="background:#ffffff" class="cont-icono-tbl" onclick='exportarTablaExcel("tablaTemplateCotizador", "Cotizador", "Cotizador")'>
                                    <i class="fa-solid fa-file-excel fa-xl" style="color: #00a85a;"></i>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr><th colspan="8" style="height:35px; background-color: #FFFFFF !important;"></th></tr>
                    <tr style="height:35px;">
                        <!-- <th style="background-color: #e1dfdf !important; color:#000000;">#</th> -->
                        <th style="background-color: #e1dfdf !important; color:#000000;">Número de parte</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">Descripción</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">Precio regular</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">% Descuento</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">$ Descuento</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">Precio con descuento</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">Cantidad</th>
                        <th style="background-color: #e1dfdf !important; color:#000000;">Precio total</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" rowspan="3" style="background-color: #ffffff !important;"></th>
                        <th style="background-color: #565555 !important;">Total</th>
                        <th style="background-color: #cfcfcf !important; color:#000000;" class="SubTotalProductos"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="table-busqueda table-responsive">
            <table class="table" id="tablaProductosBuscador"></table>
        </div>
       
    </div>
</div>