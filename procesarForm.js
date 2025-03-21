const form = document.getElementById("contactForm");
const submitButton = document.getElementById("submitBtn");

form.addEventListener("submit", function(event) {
    event.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const email = document.getElementById("email").value;
    const mensaje = document.getElementById("mensaje").value;

    const formData = {
        nombre: nombre,
        email: email,
        mensaje: mensaje
    };

    fetch("procesar_formulario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            var exitoForm = new bootstrap.Modal(document.getElementById('exitoForm'), {
                keyboard: false
              });
              
              exitoForm.show();//Abrir modal de éxito

            form.reset(); //Limpiar form
        } else {
            console.log("Hubo un problema al enviar el formulario. Inténtalo nuevamente.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        console.log("Hubo un problema al enviar el formulario. Inténtalo nuevamente.");
    });
});
