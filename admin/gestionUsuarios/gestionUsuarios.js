document.addEventListener("DOMContentLoaded", function () {
    const usuariosContainer = document.getElementById("usuarios");

    function fetchUsuarios(nombre) {
        fetch("verusuarios.php", {
            method: "POST", 
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ nombre: nombre }) 
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.status === "success") {
                mostrarUsuarios(data.data); 
            } else {
                console.error("Error al obtener los usuarios:", data.message);
            }
        })
        .catch(error => console.error("Error en la petición:", error)); 
    }
    

    function mostrarUsuarios(usuarios) {
        usuariosContainer.innerHTML = "";

        usuarios.forEach(usuario => {
            const usuarioCard = document.createElement("div");
            usuarioCard.classList.add("col-12", "col-md-3", "p-2");

            usuarioCard.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label>Usuario:</label>
                            <input type="text" name="usuario" class="form-control mb-2" value="${usuario.usuario}" readonly>
                           
                            <label>Cartera (€):</label>
                            <input type="number" name="cartera" class="form-control mb-2" value="${usuario.cartera}">
                           
                            <label>Admin:</label>
                            <input type="checkbox" name="rol" class="form-check-input mb-2" ${usuario.rol === "admin" ? "checked" : ""}>
                           <br>
                            <button class="btn btn-success guardar mt-2" data-id="${usuario.id}">Guardar</button>
                        </div>
                    </div>
                </div>
            `;

            usuariosContainer.appendChild(usuarioCard);
        });

        document.querySelectorAll(".guardar").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                guardarCambios(id, this);
            });
        });
    }

    function guardarCambios(id, boton) {
        let tarjeta = boton.closest(".card"); // Encuentra la tarjeta más cercana
    
        let cartera = tarjeta.querySelector("[name='cartera']").value;
        let rol = tarjeta.querySelector("[name='rol']").checked ? "admin" : "usuario";
    
        let datosActualizados = {
            id: id,
            cartera: cartera,
            rol: rol
        };
    
        fetch("actualizarUsuario.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Usuario actualizado correctamente");
                fetchUsuarios("");
            } else {
                console.error("Error al actualizar el usuario: " + data.message);
            }
        })
        .catch(error => console.error("Error en la actualización:", error));
    }
    

    fetchUsuarios("");
    const form = document.getElementById("buscarUsuarioForm");
    const inputNombre = document.getElementById("nombreUsuario");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const nombre = inputNombre.value.trim(); 

        fetchUsuarios(nombre);
    });
});