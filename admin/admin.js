document.addEventListener("DOMContentLoaded", function () {
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
        container.innerHTML = "";

        if (pedidos.length === 0) {
            container.innerHTML = "<p>No hay registros recientes.</p>";
        } else {
            pedidos.forEach(pedido => {
                const pedidoDiv = document.createElement("div");
                pedidoDiv.classList.add("row", "mb-3");

                pedidoDiv.innerHTML = `
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <img src="${pedido.img}" alt="${pedido.nombreCarta}" class="img-fluid" style="max-width: auto; height: 100px;">
                    </div>
                    <div class="col-8 d-flex flex-column text-center justify-content-center">
                        <h6>${pedido.usuario}</h6>
                        <h6>${pedido.nombreSobre}</h6>
                        <h5><strong></strong> ${pedido.numero} - ${pedido.nombreCarta}</h5>
                    </div>
                `;
                
                container.appendChild(pedidoDiv);
            });
        }
    }
});
