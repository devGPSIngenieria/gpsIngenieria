<!-- FORMULARIO DE REGISTRO DE PAQUETES-->
<div class="col-12">
    <form class="justify-content-center" id="frmRegisterPackages" method="POST" enctype="multipart/form-data" style="display: none;">
        
        <div class="card_content col-12">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center">
                    <label class="text-subtitle">Registro de paquetes</label>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="inputContainer">
                        <input type="text" id="namePackage" name="namePackage" class="inputField" required="" placeholder="Escriba nombre del paquete" maxlength="50">
                        <label class='usernameLabel' for='namePackage'>Nombre de paquete</label>
                        <i class="userIcon fa-solid fa-align-left"></i>
                    </div>
                </div>                

                <div class="col-sm-12 col-md-3">
                    <div class="inputContainer">
                        <input type="number" id="pricePackage" name="pricePackage" class="inputField" required="" min="0" placeholder="Escriba precio del paquete" maxlength="50">
                        <label class='usernameLabel' for='pricePackage'>Precio paquete</label>
                        <i class="userIcon fa-solid fa-dollar-sign"></i>
                    </div>
                </div>     
                
                <div class="col-12 text-center">
                    <label class="text-subtitle">Productos para el paquete</label>
                </div>
                
                <div id="containerInputsProducts">
                        
                    <div class="row d-flex justify-content-center">
    
                        <div class="col-sm-12 col-md-6">
                            <div class="inputContainer">
                                <input class="inputField numeroParte-Package" required="" type="text" placeholder="Escriba el número de parte" maxlength="50">
                                <label class='usernameLabel' for='nParte'>Número de parte</label>
                                <i class="userIcon fa-solid fa-hashtag"></i>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="inputContainer">
                                <textarea type="text" class="inputField descripcion-Package" required="" placeholder="Escriba descripción" maxlength="200"></textarea>
                                <label class='usernameLabel' for='descripcion'>Descripción</label>
                                <i class="userIcon fa-solid fa-align-left"></i>
                            </div>
                        </div>

                    </div>     

                </div>


                <div onclick="addInputsProducts()" data-toggle="tooltip" data-placement="top" title="Agregar un producto" style="background:#336ee2" class="cont-icono-tbl">
                    <i class="fa-solid fa-plus fa-xl"></i>
                </div>

                <div class="contenedor-boton-gen">
                    <div class="main_div">
                        <a onclick="registerPackage()">GUARDAR</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>