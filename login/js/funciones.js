function validarEntrada() {

	const data = new FormData(document.getElementById("frmLogin"));

	const options = {
		method: "POST",
		body: data,
	};

	// Petición HTTP
	fetch("../../login/php/loginAJAX.php", options)
    .then((response) => response.json())
    .then((data) => {
		
		if (data[0]) {
			window.open("../../menuPrincipal/php/menuPrincipal.php", "_self");
		} else {
			Swal.fire({
			title: "Error",
			text: "El usuario o contraseña son incorrectos",
			icon: "error",
			confirmButtonText: "Aceptar",
			confirmButtonColor: "#B50309",
			allowOutsideClick: false,
			allowEnterKey: true,
			});
		}
    });
}
