<!-- MODAL 1 DE RESPONSIVAS -->
<div class="modal modal-backdrop-static" id="modalResponsiva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Datos de responsiva</label>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:#d5d8d4; border-radius: 100px;"></button>
            </div>
            <div class="modal-body">
                <form id="frmModalResponsiva">

                    <div class="contenedorCont">
                        <div class="row">
                            <?php
                                $conexionEmpleados = new conexion;
                                $queryEmpleados = "SELECT idEmpleado,nombre,apellidos,correo,telefono,puesto FROM empleados WHERE status=1";
                                $resultados = $conexionEmpleados->conn->query($queryEmpleados);
                            ?>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="empleado" name="empleado" aria-label="Floating label select example">
                                    <option value="" selected>Empleado...</option>
                                    <?php
                                        foreach ($resultados->fetch_all() as $index => $resultados) {
                                            print_r("<option value=\"" . $resultados[0] . "\" >" . $resultados[1] . " ".$resultados[2]."</option>");
                                        }
                                    ?>

                                </select>
                                <label for="floatingSelect">Empleado</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="tablaProdSel" class="table table-hover"></table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="generarResponsiva()">Generar responsiva</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2 VER RESPONSIVAS -->
<div id="modalResponsivas" class="ventanaModal">
    <div class="ventanaModal-content ventanaModal-fullscreen">

        <div class="cont-modal-iframe">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="cont-modal-top"></div>
            <!-- <iframe class="iframe" id="iframeManual" frameborder="0" scrolling="no" readonly="readonly"></iframe> -->
            <iframe id="iframeVerPdf" class="iframe"></iframe>
        </div>
    </div>
</div>
