<?php



///formulario para pagos

function frmpagos(){

   echo '<div id="divPagos">
   <table id="tablaPagos" class="table table-hover" ></table>
   <form id="frmPagos" style="display: none;">
   <input type="text" id="estado" name="estado" value=1 hidden>
   <input type="text" id="id" name="id" hidden>
   <div class="form-floating mb-3">
       <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Escriba una Descripcion">
       <label>Cantidad</label>
   </div>
   <div class="mb-3">
       <label for="formFile" class="form-label">Evidencia</label>
       <input class="form-control" type="file" id="evidencia" name="evidencia" enctype="multipart/form-data">
   </div>
</form> </div>';


}

function frmFacturas(){


    echo '<form id="frmFactura" style="display: block;">
    <input type="text" id="id" name="id" hidden>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="factura" name="factura" placeholder="Escriba una Descripcion">
        <label>Factura</label>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Evidencia</label>
        <input class="form-control" type="file" id="evidenciaFactura" name="evidenciaFactura" enctype="multipart/form-data">
    </div>
 </form>';

  

}