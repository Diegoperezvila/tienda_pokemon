document.addEventListener("DOMContentLoaded", function () {
    function verAperturas(){
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
    }

    function verPedidos(){
        fetch('verPedidos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ estado: 'pedido' }) //Solo los que tengan el estado pedido
        })
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
        const container = document.getElementById("cartasPedidas");
        container.innerHTML = "";

        if (pedidos.length === 0) {
            container.innerHTML = "<p>No hay registros recientes.</p>";
        } else {
            pedidos.forEach(pedido => {
                const pedidoDiv = document.createElement("div");
                pedidoDiv.classList.add("row", "mb-3");
            
                //Creamos un id único para los botones de aceptar y rechazar de cada tarjeta
                const rechazarId = `rechazar-${pedido.id}`;
                const aceptarId = `aceptar-${pedido.id}`;
            
                pedidoDiv.innerHTML = `
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="${pedido.imagen}" alt="${pedido.nombreCarta}" class="img-fluid" style="max-width: auto; height: 100px;">
                    </div>
                    <div class="col-9 d-flex flex-column text-center justify-content-center">
                        <h5><strong></strong> ${pedido.numeroCarta} - ${pedido.nombreCarta} - ${pedido.precioCarta}€</h5>
                        <div class="d-flex justify-content-center mt-2">
                            <button id="${rechazarId}" class="btn me-2 rechazar">❌</button>
                            <button id="${aceptarId}" class="btn aceptar">✅</button>
                        </div>
                    </div>
                `;
            
                container.appendChild(pedidoDiv);
            
                document.getElementById(aceptarId).onclick = function () {
                    actualizarEstado(pedido.id, "aceptado");
                };
            
                document.getElementById(rechazarId).onclick = function () {
                    actualizarEstado(pedido.id, "rechazado");
                    let totalDevolver = parseFloat(pedido.precioCarta)+parseFloat(pedido.precioEnvio);
                    totalDevolver=totalDevolver.toFixed(2);
                    actualizarWallet(pedido.usuario, totalDevolver);//Debemos actualizar wallet para darle el dinero de la carta y envío al rechazarla
                };

                function actualizarWallet(usuario, totalDevolver){
                    fetch('actualizarSaldo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ usuario: usuario, totalDevolver: totalDevolver })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            console.log("Actualizado");
                        } else {
                            console.error("No se encontraron registros:", data.message);
                        }
                    })
                    .catch(error => console.error("Error al obtener los registros:", error));
                }
            
                function actualizarEstado(id, nuevoEstado) {
                    fetch('actualizarEstado.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: id, estado: nuevoEstado })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            verPedidos();
                        } else {
                            console.error("No se encontraron registros:", data.message);
                        }
                    })
                    .catch(error => console.error("Error al obtener los registros:", error));
                }
            });
            
            
        }
    }
    }
    
    verAperturas();//Mostramos las últimas 5 aperturas
    verPedidos();//Mostramos los pedidos
});
