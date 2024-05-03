<?php
    include "../../fGenerales/bd/conexion.php";
    include "../../fGenerales/php/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php pintarHead('Login');?>
    </head>

    <body class="row d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center" style="padding: 100px;">
            <div class="divLogo">
                <img class="imgLogo" src="../../src/imagenes/logo.png" />
            </div>
            <div class="screen">
                <div class="screen__content">
                    <form class="login" id="frmLogin">

                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input name="usuario" type="text" class="login__input" placeholder="Usuario">
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input name="password" type="password" class="login__input" placeholder="Contraseña">
                        </div>
        
                        <div class="contenedor-boton-gen">
                            <div class="main_div" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
                                <a type="button" onclick="validarEntrada()" style="font-size: 13px;">Iniciar sesión</a>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="screen__background">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>		
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div>		
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    </body>

</html>