<?php
    foreach ($datos->fetch_all() as $dato) {

        if ($dato[1] == 17) {
            echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Cotizador</span>
                    </span>
                </button>';
        }
    }
?>