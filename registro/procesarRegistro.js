document
  .getElementById("registroForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    let usuario = document.getElementById("usuario").value;
    let correo = document.getElementById("correo").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let mensaje = document.getElementById("mensaje");

    if (password !== confirmPassword) {
      mensaje.innerHTML =
        "<span class='text-danger'>Las contraseñas no coinciden.</span>";
      return;
    }

    fetch("procesar_registro.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `nombre=${nombre}&apellido=${apellido}&usuario=${usuario}&correo=${correo}&password=${password}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          mensaje.innerHTML = `<span class='text-danger'>${data.error}</span>`;
        } else {
          mensaje.innerHTML = `<span class='text-success'>${data.mensaje}</span>`;
          window.location.href = "../";
        }
      })
      .catch((error) => {
        mensaje.innerHTML =
          "<span class='text-danger'>Error en el registro.</span>";
      });
  });
