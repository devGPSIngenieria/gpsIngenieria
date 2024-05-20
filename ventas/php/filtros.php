<div class="row text-center">

    <div class="col-sm-12 col-md-4">
        <div class="inputContainer">
            <input id="filtroCliente" name="filtroCliente" class="inputField" required="" type="text" placeholder="Escriba el cliente" onkeyup="filtrarVentas()">
            <label class='usernameLabel' for='filtroCliente'>Cliente</label>
            <i class="userIcon fa-solid fa-people-arrows"></i>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="inputContainer">
            <input id="filtroTrabajador" name="filtroTrabajador" class="inputField" required="" type="text" placeholder="Escriba el trabajador" onkeyup="filtrarVentas()">
            <label class='usernameLabel' for='filtroTrabajador'>Trabajador</label>
            <i class="userIcon fa-solid fa-user-tie"></i>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="inputContainer">
            <input id="filtroCompra" name="filtroCompra" class="inputField" required="" type="text" placeholder="Escriba la compra" onkeyup="filtrarVentas()">
            <label class='usernameLabel' for='filtroCompra'>Compra</label>
            <i class="userIcon fa-solid fa-cart-shopping"></i>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="inputContainer">
            <input id="filtroFechaI" name="filtroFechaI" class="inputField" required="" type="date" placeholder="Ingrese la fecha inicio" onchange="filtrarVentas()">
            <label class='usernameLabel' for='filtroFechaI'>Fecha inicial</label>
            <i class="userIcon fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="inputContainer">
            <input id="filtroFechaF" name="filtroFechaF" class="inputField" required="" type="date" placeholder="Ingrese la fecha fin" onchange="filtrarVentas()">
            <label class='usernameLabel' for='filtroFechaF'>Fecha final</label>
            <i class="userIcon fa-solid fa-calendar-days"></i>
        </div>
    </div>

</div>