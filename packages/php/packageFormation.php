<div class="col-12">
    <!-- FORMULARIO DE REGISTRO DE PAQUETES-->
    <form class="justify-content-center" id="frmPackagesFormation" method="POST" enctype="multipart/form-data" style="display: none;">
        
        <div class="card_content col-12">
            <div class="row d-flex justify-content-center">
                <div class="col-12 text-center">
                    <label class="text-subtitle">Formar paquete</label>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="inputContainer">
                        <input id="nParte" name="nParte" class="inputField" required="" type="text" placeholder="Escriba el número de parte" maxlength="50">
                        <label class='usernameLabel' for='nParte'>Número de parte</label>
                        <i class="userIcon fa-solid fa-hashtag"></i>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8">
                    <div class="inputContainer">
                        <select type="text" id="filtroPackage" name="filtroPackage" class="inputField" required="" placeholder="Seleccione paquete">
                            <option value=0 selected>...</option>
                            <?php
                                $conPackages = new conexion;
                                $queryPackages = "SELECT * FROM packages";
                                $packages = $conPackages->conn->query($queryPackages);

                                foreach ($packages->fetch_all() as $index => $package) {
                                    print_r("<option value=\"" . $package[0] . "\" >" . $package[1] . "</option>");
                                }
                            ?>
                        </select>
                        <label class='usernameLabel' for='filtroPackage'>Pertenece al paquete</label>
                        <i class="userIcon fa-regular fa-object-ungroup"></i>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="inputContainer">
                        <textarea type="text" id="descripcion" name="descripcion" class="inputField" required="" placeholder="Escriba descripción" maxlength="200"></textarea>
                        <label class='usernameLabel' for='descripcion'>Descripción</label>
                        <i class="userIcon fa-solid fa-align-left"></i>
                    </div>
                </div>

                <div class="contenedor-boton-gen">
                    <div class="main_div">
                        <a onclick="">GUARDAR</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>