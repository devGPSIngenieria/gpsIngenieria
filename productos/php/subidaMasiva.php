<!-- SECCIÓN DE REGISTRO DE PRODUCTOS -->
<div class="row" id="uploadDataProducts" style="display: none;">

    <div class="card_content">

        <div class="col-12 text-center ">
            <label class="text-subtitle">Subida Masiva de Productos</label>
        </div>

        <div class="row d-flex justify-content-center align-items-center">

            <div class="col-sm-12 col-md-4">
                <form id="frmExcelUpload" >
                    <!-- FILTRO POR FECHA FIN-->
                    <div class="inputContainer">
                        <input id="archivo" name="archivo" class="inputField" required="" type="file" placeholder="Selecciona archivo excel">
                        <label class='usernameLabel' for='archivo'>Fecha fin</label>
                        <i class="userIcon fa-solid fa-calendar-days"></i>
                    </div>
                </form>
            </div>

            <div class="contenedor-boton-gen">
                <div class="main_div">
                    <a onclick="uploadDataProducts()">GUARDAR</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
