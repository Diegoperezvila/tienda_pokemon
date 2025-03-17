document.addEventListener("DOMContentLoaded", function() {
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

    function mostrarSobres(sobres) {
        const container = document.getElementById("divTienda");
        container.innerHTML = "";

        sobres.forEach(sobre => {
            const card = document.createElement("div");
            card.classList.add("col-md-3", "mb-4");

            card.innerHTML = `
                <div class="tarjeta">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="${sobre.img}" class="card-img-top" alt="${sobre.nombre}" style="width: 100px; height: 200px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="">${sobre.nombre}</h5>
                        <p class="fw-bold">Precio: ${sobre.precio}€</p>
                        <a href="./probabilidades-cartas.html?${sobre.api}" target="_blank">Ver cartas y probabilidades</a>
                    </div>
                </div>
            `;

            container.appendChild(card);
        });
    }
});
