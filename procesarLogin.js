document.getElementById("inicioForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let usuario = document.getElementById("inputUser");
    let password = document.getElementById("inputPassword");

    fetch("procesar_login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            usuario: usuario.value,
            password: password.value
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.error) {
            usuario.style.border = "1px solid red";
            password.style.border = "1px solid red";
        } else {
            window.location.href = data.redirect;
        }
    })
    .catch((error) => {
        console.log("Error al hacer la solicitud:", error);
    });
});
