document.addEventListener("DOMContentLoaded", function () {
    const sobresContainer = document.getElementById("sobres");

    function fetchSobres() {
        fetch("versobres.php")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    mostrarSobres(data.data);
                } else {
                    console.error("Error al obtener los sobres:", data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
    }

    function mostrarSobres(sobres) {
        sobresContainer.innerHTML = "";

        sobres.forEach(sobre => {
            const sobreCard = document.createElement("div");
            sobreCard.classList.add("col-12", "col-md-4", "p-2");

            sobreCard.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <img src="../../img/${sobre.img}" alt="${sobre.nombre}" class="me-3" style="width: 150px; height: 200px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" class="form-control mb-2" value="${sobre.nombre}" readonly>
                           
                            <label>Precio (€):</label>
                            <input type="number" name="precio" class="form-control mb-2" value="${sobre.precio}" min="0">
                           
                            <label>Stock:</label>
                            <input type="number" name="stock" class="form-control mb-2" value="${sobre.stock}">
                           
                            <label>API:</label>
                            <input type="text" name="api" class="form-control mb-2" value="${sobre.api}" readonly>
                           
                            <button class="btn btn-success guardar mt-2" data-id="${sobre.id}">Guardar</button>
                        </div>
                    </div>
                </div>
            `;

            sobresContainer.appendChild(sobreCard);
        });

        document.querySelectorAll(".guardar").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                guardarCambios(id, this);
            });
        });
    }

    function guardarCambios(id, boton) {
        let tarjeta = boton.parentElement;

        let nombre = tarjeta.querySelector("[name='nombre']").value;
        let precio = tarjeta.querySelector("[name='precio']").value;
        let stock = tarjeta.querySelector("[name='stock']").value;
        let api = tarjeta.querySelector("[name='api']").value;

        let datosActualizados = {
            id: id,
            nombre: nombre,
            precio: precio,
            stock: stock,
            api: api
        };

        fetch("actualizarSobre.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    fetchSobres();
                } else {
                    console.log("Error al actualizar el sobre: " + data.message);
                }
            })
            .catch(error => console.error("Error en la actualización:", error));
    }

    fetchSobres();//Mostramos todos los sobres
});