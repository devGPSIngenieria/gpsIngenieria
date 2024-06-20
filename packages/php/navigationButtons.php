<?php
    foreach ($datos->fetch_all() as $dato) {

        if ($dato[1] == 18) {
            echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(1)">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Registrar paquetes</span>
                    </span>
                </button>';
        }
        if ($dato[1] == 19) {
            echo '<button class="btn-apartado-secciones" onclick="abrirSeccion(2)">
                    <span class="button_lg">
                        <span class="button_sl"></span>
                        <span class="button_text">Formar paquete</span>
                    </span>
                </button>';
        }
    }
?>