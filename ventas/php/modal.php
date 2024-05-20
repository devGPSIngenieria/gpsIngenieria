<div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-center" id="exampleModalLabel" style="font-size: 30px;">Modificar Usuario</label>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmModificar">
                    <input type="text" id="id" name="id" hidden>
                    <label for="nombre">Nombre :</label><input class="form-control" type="text" id="nombre" name="nombre">
                    <label for="login">Login :</label><input class="form-control" type="text" id="login" name="login">
                    <label for="correo">Correo :</label><input class="form-control" type="text" id="correo" name="correo">
                    <label for="password">Contraseña :</label> <input class="form-control" type="password" id="password" name="password">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="modificarUsuario()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
    </div>



