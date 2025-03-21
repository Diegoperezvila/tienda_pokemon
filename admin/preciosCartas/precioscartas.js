document.addEventListener("DOMContentLoaded", function () {
    const prCartasContainer = document.getElementById("precios");

    function fetchPrCartas() {
        fetch("precioscartas.php")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    mostrarPrCartas(data.data);
                } else {
                    console.error("Error al obtener los datos:", data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
    }

    function mostrarPrCartas(prCartas) {
        prCartasContainer.innerHTML = "";

        prCartas.forEach(prCarta => {
            const sobreCard = document.createElement("div");
            sobreCard.classList.add("col-12", "col-md-4", "p-2");

            sobreCard.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label>Rereza:</label>
                            <input type="text" name="rareza" class="form-control mb-2" value="${prCarta.rareza}" readonly>
                           
                            <label>Precio (€):</label>
                            <input type="number" name="precio" class="form-control mb-2" value="${prCarta.precio}" min="0">
                           
                            <button class="btn btn-success guardar mt-2" data-id="${prCarta.id}">Guardar</button>
                        </div>
                    </div>
                </div>
            `;

            prCartasContainer.appendChild(sobreCard);
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

        let rareza = tarjeta.querySelector("[name='rareza']").value;
        let precio = tarjeta.querySelector("[name='precio']").value;

        let datosActualizados = {
            id: id,
            rareza: rareza,
            precio: precio
        };

        fetch("actualizarPrecioCartas.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    fetchPrCartas();
                } else {
                    console.log("Error al actualizar el precio de la carta: " + data.message);
                }
            })
            .catch(error => console.error("Error en la actualización:", error));
    }

    fetchPrCartas();//Obtenemos todos los precios de las rarezas
});