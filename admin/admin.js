document.addEventListener("DOMContentLoaded", function () {
    // Realizamos la petición para obtener los últimos 5 pedidos
    fetch('verAperturas.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                mostrarUltimosPedidos(data.data);
            } else {
                console.error("No se encontraron registros:", data.message);
            }
        })
        .catch(error => console.error("Error al obtener los registros:", error));

    function mostrarUltimosPedidos(pedidos) {
        const container = document.getElementById("ultimosPedidos");
        container.innerHTML = ""; // Limpiar el contenido previo del div

        if (pedidos.length === 0) {
            container.innerHTML = "<p>No hay registros recientes.</p>";
        } else {
            pedidos.forEach(pedido => {
                // Crear un contenedor para cada pedido
                const pedidoDiv = document.createElement("div");
                pedidoDiv.classList.add("row", "mb-3"); // Para que los elementos estén en fila y con margen

                // Estructura del pedido con imagen y detalles
                pedidoDiv.innerHTML = `
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <img src="${pedido.img}" alt="${pedido.nombreCarta}" class="img-fluid" style="max-width: auto; height: 100px;">
                    </div>
                    <div class="col-8 d-flex flex-column text-center justify-content-center">
                        <h5>${pedido.nombreSobre}</h5>
                        <h4><strong></strong> ${pedido.numero} - ${pedido.nombreCarta}</h4>
                    </div>
                `;
                
                // Agregar el div del pedido al contenedor de los últimos pedidos
                container.appendChild(pedidoDiv);
            });
        }
    }
});
