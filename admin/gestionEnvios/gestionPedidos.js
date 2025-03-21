document.addEventListener("DOMContentLoaded", function () {
    const pedidosContainer = document.getElementById("pedidos");

    function fetchPedidos(usuario, estado) {
        fetch('../verPedidos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({usuario:usuario, estado: estado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                mostarPedidos(data.data);
            } else {
                console.error("No se encontraron registros:", data.message);
            }
        })
        .catch(error => console.error("Error al obtener los registros:", error));
    }
    

    function mostarPedidos(pedidos) {
        pedidosContainer.innerHTML = "";

        pedidos.forEach(pedido => {
            const pedidoCard = document.createElement("div");
            pedidoCard.classList.add("col-12", "col-md-3", "p-2");
        
            let botonesHTML = '';
        
            //Diferentes botones según el estado del pedido
            if (pedido.estado === "aceptado") {
                botonesHTML = `<button class="btn btn-success enviar mt-2" data-id="${pedido.id}">Enviar</button>`;
            } else if (pedido.estado === "enviado") {
                botonesHTML = `<button class="btn btn-success completado mt-2" data-id="${pedido.id}">Completado</button>`;
            } else if (pedido.estado === "pedido" || pedido.estado === "rechazado" || pedido.estado === "completado") {
                botonesHTML = `<button class="btn btn-secondary mt-2" disabled>Sin Acción</button>`;
            }
        
            pedidoCard.innerHTML = `
                <div class="card p-3" style="min-height: 300px;">
                    <div class="d-flex flex-column align-items-stretch">
                        <div class="flex-grow-1">
                            <label>Usuario:</label>
                            <input type="text" name="usuario" class="form-control mb-2" value="${pedido.usuario}" readonly>
        
                            <label>Pedido:</label>
                            <input type="text" name="carta" class="form-control mb-2" value="${pedido.numeroCarta} - ${pedido.nombreCarta}" readonly>
                           
                            <label>Estado:</label>
                            <input type="text" name="estado" class="form-control mb-2" value="${pedido.estado}" readonly>
                            
                            ${botonesHTML}
                        </div>
                    </div>
                </div>
            `;
        
            pedidosContainer.appendChild(pedidoCard);

            if (pedido.estado === "aceptado") {
                const enviarButton = pedidoCard.querySelector('.enviar');
                enviarButton.addEventListener('click', () => {
                    guardarCambios(pedido.id, "enviado");
                });
            }
        
            if (pedido.estado === "enviado") {
                const completadoButton = pedidoCard.querySelector('.completado');
                completadoButton.addEventListener('click', () => {
                    guardarCambios(pedido.id, "completado");
                });
            }
        });
        
    }

    function guardarCambios(id, estado) {
        let datosActualizados = {
            id: id,
            estado: estado
        };
    
        fetch("actualizarPedido.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                const inputNombre = document.getElementById('nombreUsuario');
                const estadoPedido = document.getElementById('estadoPedido');
                
                const nombre = inputNombre.value.trim();
                const estado = estadoPedido.value.trim();
                fetchPedidos(nombre, estado);//Solo actualizamos, dejamos los filtros de usuario y estado
            } else {
                console.error("Error al actualizar el pedido: " + data.message);
            }
        })
        .catch(error => console.error("Error en la actualización:", error));
    }
    

    fetchPedidos("", "");//Por defecto obtenemos los pedidos de todos los usuarios y cualquier estado
    const form = document.getElementById('buscarUsuarioForm');
    const inputNombre = document.getElementById('nombreUsuario');
    const estadoPedido = document.getElementById('estadoPedido');

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const nombre = inputNombre.value.trim();
        const estado = estadoPedido.value.trim();

        fetchPedidos(nombre, estado);//Obtenemos los pedidos con ese usuario y estado
    });
});