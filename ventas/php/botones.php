<?php
    $datos = checarPermisosSeccion($_SESSION['usuarioid']);
?>

<div class="row" style="display: flex; justify-content: center; align-items: center; text-align: center;">
    <div class="col-12 cont-botones-secciones">
        <?php 
            // foreach($datos->fetch_all() as $dato){
                // if($dato[1]==7){                                        
                    echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                        <span class="button_lg">
                            <span class="button_sl"></span>
                            <span class="button_text">Catálogo ventas</span>
                        </span>
                    </button>';
                // }
            // }
        ?>


    </div>

</div>