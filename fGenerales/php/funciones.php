<?php
//funcion para revisar la adición de actualizado de actualizado
$SOFTWARE_VERSION_PHP="1.2";

// CHECA EL USUARIO EXISTENTE EN LA BD
if (!function_exists('checarLogin')) {
    function checarLogin($usuario, $password)
    {
        $conexion = new conexion;
        $query = "SELECT id_usuario ,nombre FROM usuarios WHERE usuario = ? and PASSWORD = SHA2(?,256)";

        $queryPreparada = $conexion->conn->prepare($query);
        $queryPreparada->bind_param('ss', $usuario, $password);
        $queryPreparada->execute();

        $resultados = $queryPreparada->get_result();

        $datos = [];

        if ($resultados->num_rows > 0) {

            session_name('gpsingenieria');
            session_start();

            foreach ($resultados->fetch_all() as $usuario) {
                $datos[0] = true;
                $datos[1] = $usuario[0];
                $datos[2] = $usuario[1];
            }

            $_SESSION['usuarioid'] = $datos[1];
            $_SESSION['nombre'] = $datos[2];

            return $datos;
        } else {

            $datos[0] = false;
            return $datos;
        }
    }
}

if (!function_exists('iniciarSession')) {
    function iniciarSession()
    {
        session_name('gpsingenieria');
        session_start();
    }
}

// CHECA SI EL USUARIO TIENE PERMISO EN LAS SECCIONES
if (!function_exists('checarPermisosSeccion')) {
    function checarPermisosSeccion($usuarioid)
    {
        $conexionSeccionesPermisos = new conexion;
        $query = "SELECT * FROM permisos_secciones where  id_usuario = " . $usuarioid ;
        $datos = $conexionSeccionesPermisos->conn->query($query);

        return $datos;
    }
}

// CHECA SI EL USUARIO TIENE PERMISO EN EL AREA
if (!function_exists('checarPermisosArea')) {
  function checarPermisosArea($usuarioid, $seccionid)
  {
      $conexionSeccionesPermisos = new conexion;
      $query = "SELECT * FROM permisos_secciones where id_usuario=".$usuarioid." and id_seccion=".$seccionid;
      $datos = $conexionSeccionesPermisos->conn->query($query);

      if($datos->num_rows > 0){
        return true;
      } else {
        return false;
      }
  }
}

if (!function_exists('pintarHead')) {
  function pintarHead($titulo)
  {
      global $SOFTWARE_VERSION_PHP;

      echo "
      <script> const SOFTWARE_VERSION_PHP=" . $SOFTWARE_VERSION_PHP . "; </script>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      
      <link rel='shortcut icon' href='../../src/imagenes/logo.png'>
      <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' />
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin='anonymous'>
    
      <link href='../../fGenerales/css/newStyle.css?" . $SOFTWARE_VERSION_PHP . "' rel='stylesheet' />
      <link href='../css/style.css?" . $SOFTWARE_VERSION_PHP . "' rel='stylesheet' />

      <link href='../../src/fontawesome-free-6.4.2-web/css/fontawesome.css' rel='stylesheet'>
      <link href='../../src/fontawesome-free-6.4.2-web/css/brands.css' rel='stylesheet'>
      <link href='../../src/fontawesome-free-6.4.2-web/css/solid.css' rel='stylesheet'>
      
      <script src='../js/funciones.js?" . $SOFTWARE_VERSION_PHP . "'></script>
      <script src='../../fGenerales/js/funciones.js?" . $SOFTWARE_VERSION_PHP . "'></script>
      <script src='../../fGenerales/js/alerts.js'></script>

      <script src='https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js'></script>
      <script src='../../fGenerales/js/jquery.js'></script>";

      echo "<title>GpsIngeniería-" . $titulo . "</title>";

      echo "<img class='marcaAguaBody' src='../../src/imagenes/logo.png'>";
  }
}


if (!function_exists('pintarEncabezado')) {
    function pintarEncabezado($titulo, $img, $variante)
    {
        if ($titulo == '' && $img == '') {
            if ($variante != 'inicio') {
                echo "<div class='row'>
                <div class='col-3 justify-content-center align-items-center'>
                  <button class='button-regreso' onclick='regreso()'>
                    <div class='button-box'>
                      <span class='button-elem'>
                        <svg viewBox='0 0 46 40' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z'></path>
                        </svg>
                      </span>
                      <span class='button-elem'>
                        <svg viewBox='0 0 46 40'>
                          <path
                            d='M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z'></path>
                        </svg>
                      </span>
                    </div>
                  </button>

                </div>
                
                <div class='col-3'></div>
              </div>";
            }
        } else {
            echo "<div class='row'>
              <!-- BOTON DE IR ATRAS -->
              <button class='button-regreso' onclick='regreso()'>
                <div class='button-box'>
                  <span class='button-elem'>
                    <svg viewBox='0 0 46 40' xmlns='http://www.w3.org/2000/svg'>
                      <path d='M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z'></path>
                    </svg>
                  </span>
                  <span class='button-elem'>
                    <svg viewBox='0 0 46 40'>
                      <path
                        d='M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z'></path>
                    </svg>
                  </span>
                </div>
              </button>

              <!-- TITULO DEL MODULO -->
              <div class='col-12  text-center  txtTitulo'>
                <span><div class='cont-img-title'><label class='text-title'>" . $titulo . "</label><i id='iconoMPanal' style='background:#438c36; padding:16px 10px; border-radius:50%; color:#ffffff;'>" . $img . "</i></div></span>
              </div>       
            </div>";
        }
    }
}

if (!function_exists('pintarNavBar')) {
    function pintarNavBar()
    {
        echo '<nav class="navbar navbar-expand-lg style-nav-gen">
            <div class="container-fluid style-nav-cont">
              <a class="navbar-brand style-nav-img cont-img-nav" href="/gpsIngenieria/menuPrincipal/php/menuPrincipal.php"><img src="../../src/imagenes/logo.svg" width="50px"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 style-nav-cont-list">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/gpsIngenieria/menuPrincipal/php/menuPrincipal.php" style="font-weight: bold; color: #438c36">Inicio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Acerca de</a>
                  </li>

                  <!-- COMENTADO
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Disabled</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li> 
                  -->

                  <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                  </li>
                </ul>
                
                <div class="d-flex style-nav-fecha">
                    <label>' . date('d-m-Y') . ' | Semana ' . date('W') . '</label>
                </div>


                <!-- COMENTADO 
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                -->
                
              </div>
            </div>
          </nav>';
    }
}

if (!function_exists('pintarFooter')) {
    function pintarFooter()
    {
        // echo "
        //     <footer class='footer-distributed fixed-bottom'>
        //       <div class='contenedorFlecha'><div class='flecha'></div></div>
        //       <div class='footer-left'>
        //         <h3><img src='../../src/imagenes/logo.jpg' width='100px'></h3>
        //         <p class='footer-links'>
        //           <a href='../../menuPrincipal/php/menuPrincipal.php' class='link-1'>Inicio</a>
        //           <a href='#'>Blog</a>
        //           <a href='#acercaDe'>Acerca de</a>
        //           <a href='#contacto'>Contacto</a>
        //         </p>

        //         <p class='footer-company-name'>GPSIngeniería © 2023</p>
        //       </div>

        //       <div class='footer-center' id='contacto'>
        //         <div>
        //           <i class='fa fa-map-marker'></i>
        //           <p><span>Col. Primero de Mayo C.P. 36644</span> Irapuato,Gto.</p>
        //         </div>

        //         <div>
        //           <i class='fa fa-phone'></i>
        //           <p>Tel. 462 173 51 96</p>
        //         </div>
    
        //         <div>
        //           <i class='fa fa-envelope'></i>
        //           <p><a href='mailto:correo@gpsing.com'>correo@gpsing.com</a></p>
        //         </div>
        //       </div>
    
        //       <div class='footer-right' id='acercaDe'>
        //         <p class='footer-company-about'>
        //           <span>Acerca de la compañía</span>
        //           Ejemplo de información de la empresa tal y más información al respecto, etc.
        //         </p>
    
        //         <div class='footer-icons'>
        //           <a href='#'><i class='fa-brands fa-facebook'></i></a>
        //           <a href='#'><i class='fa-brands fa-twitter'></i></a>
        //           <a href='#'><i class='fa-brands fa-whatsapp'></i></a>
        //         </div>
        //       </div>
        //     </footer>";
    }
}

if (!function_exists('pantallaCarga')) {
    function pantallaCarga($vis)
    {
        if ($vis == 'on') {
            $visibilidad = 'display:flex;';
        } else {
            $visibilidad = 'display:none;';
        }
        echo "<div id='pantallaCarga' class='dots' style='--size: 200px; --dot-size: 15px; --dot-count: 6; --color: #ffffff; --speed: 1s; --spread: 60deg; " . $visibilidad . " '>
            <div class='fondoDot'></div>
            <div style='--i: 0;' class='dot'></div>
            <div style='--i: 1;' class='dot'></div>
            <div style='--i: 2;' class='dot'></div>
            <div style='--i: 3;' class='dot'></div>
            <div style='--i: 4;' class='dot'></div>
            <div style='--i: 5;' class='dot'></div>
          </div>";
    }
}
