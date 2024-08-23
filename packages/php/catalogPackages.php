<!-- CATALOGO DE PAQUETES-->
<div class="col-12">
    <form class="justify-content-center" id="frmCatalogoPackages" method="POST" enctype="multipart/form-data" style="display: none;">
        
        <div class="card_content col-12">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center">
                    <label class="text-subtitle">Catálogo de paquetes</label>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="inputContainer">
                        <input type="text" id="filtroNombre" name="filtroNombre" class="inputField" required="" placeholder="Escriba nombre del paquete" maxlength="50" onkeyup="traeCatalogoPackages()">
                        <label class='usernameLabel' for='filtroNombre'>Nombre de paquete</label>
                        <i class="userIcon fa-solid fa-align-left"></i>
                    </div>
                </div>                

                <div class="col-sm-12">
                    <div class="card bg-light mb-3">
                        <div class="card-header"></div>
                        <div class="table-responsive">
                            <table id='tableCatalogPackage' class="table" style="box-shadow: none;"></table>
                        </div>
                        <div class="card-header"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>