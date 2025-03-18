document.addEventListener("DOMContentLoaded", function () {
    const enviosContainer = document.getElementById("precios");

    function fetchEnvios() {
        fetch("preciosEnvios.php")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    mostrarEnvios(data.data);
                } else {
                    console.error("Error al obtener los datos:", data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
    }

    function mostrarEnvios(envios) {
        enviosContainer.innerHTML = "";

        envios.forEach(envio => {
            const sobreCard = document.createElement("div");
            sobreCard.classList.add("col-12", "col-md-4", "p-2");

            sobreCard.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label>Empresa:</label>
                            <input type="text" name="empresa" class="form-control mb-2" value="${envio.empresa}" readonly>

                            <label>Tipo de Envío:</label>
                            <input type="text" name="tipo" class="form-control mb-2" value="${envio.tipo}" readonly>
                           
                            <label>Precio (€):</label>
                            <input type="number" name="precio" class="form-control mb-2" value="${envio.precio}" min="0">
                           
                            <button class="btn btn-success guardar mt-2" data-id="${envio.id}">Guardar</button>
                        </div>
                    </div>
                </div>
            `;

            enviosContainer.appendChild(sobreCard);
        });

        const divNuevoEnvio = document.createElement("div");
        divNuevoEnvio.classList.add("col-12", "col-md-4", "p-2");

        divNuevoEnvio.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label>Empresa:</label>
                            <input type="text" name="empresa" class="form-control mb-2" placeholder="Empresa">

                            <label>Tipo de Envío:</label>
                            <input type="text" name="tipo" class="form-control mb-2" placeholder="Tipo de envío">
                           
                            <label>Precio (€):</label>
                            <input type="number" name="precio" class="form-control mb-2" min="0" placeholder="0">
                           
                            <button class="btn btn-success nuevoEnvio mt-2"">Añadir</button>
                        </div>
                    </div>
                </div>
            `;

            enviosContainer.appendChild(divNuevoEnvio);

        document.querySelectorAll(".guardar").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                guardarCambios(id, this);
            });
        });
    }

    function guardarCambios(id, boton) {
        let tarjeta = boton.parentElement;

        let empresa = tarjeta.querySelector("[name='empresa']").value;
        let tipo = tarjeta.querySelector("[name='tipo']").value;
        let precio = tarjeta.querySelector("[name='precio']").value;

        let datosActualizados = {
            id: id,
            empresa: empresa,
            tipo: tipo,
            precio: precio
        };

        fetch("actualizarPreciosEnvios.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    fetchEnvios();
                } else {
                    console.log("Error al actualizar el envío: " + data.message);
                }
            })
            .catch(error => console.error("Error en la actualización:", error));
    }

    fetchEnvios();
});