document.addEventListener("DOMContentLoaded", function () {
    let imageReplaced = false;

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
                        <h5>${sobre.nombre}</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <p class="fw-bold mb-0">Precio: ${sobre.precio}€</p>
                            <button class="btn btn-outline-primary btn-sm ms-2 comprar" data-nombre="${sobre.nombre}" data-precio="${sobre.precio}" data-id="${sobre.id}" data-img="${sobre.img}" data-api="${sobre.api}" ${sobre.stock <= 0 ? 'disabled style="cursor: not-allowed;"' : ''}>
                                <i class="bi bi-cart4"></i>
                            </button>
                        </div>
                        <p class="${sobre.stock > 0 ? 'text-success' : 'text-danger'} mb-0">
                            ${sobre.stock > 0 ? '¡Hay stock!' : 'No hay stock'}
                        </p>
                        <a href="./probabilidades-cartas.php?texto=${sobre.api}">Ver cartas y probabilidades</a>
                    </div>
                </div>
            `;

            container.appendChild(card);
        });

        document.querySelectorAll(".comprar").forEach(button => {
            button.addEventListener("click", function () {
                const precio = parseFloat(this.getAttribute("data-precio")).toFixed(2);
                const saldo = parseFloat(document.getElementById("wallet").textContent).toFixed(2);
                const api = this.getAttribute("data-api");
                const img = this.getAttribute("data-img");
                const id = this.getAttribute("data-id");
                const nombre = this.getAttribute("data-nombre");
                if (saldo >= parseFloat(precio)){
                    let newSaldo = saldo-precio;
                    newSaldo = newSaldo.toFixed(2);
                    console.log(newSaldo);
                    
                    actualizarSaldo(id, api, img, newSaldo, nombre);
                }else{
                    alert("No hay saldo");
                }
            });
        });
    }

    function actualizarSaldo(id, api, img, newSaldo, nombre) {
        let datosActualizados = {
            cartera: newSaldo
        };
    
        fetch("actualizarSaldo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosActualizados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                document.getElementById("wallet").textContent = newSaldo;
                comprar(id, api, img, nombre);
            } 
            else if (data.status === "error") {
                alert(data.message);
            } 
            else {
                console.log("Respuesta inesperada:", data);
                alert("Hubo un problema con la respuesta del servidor.");
            }
        })
        .catch(error => {
            console.error("Error al realizar la compra:", error);
            alert("Hubo un error al procesar la compra.");
        });
    }
    

    function comprar(id, api, img, nombre) {
        
        fetch("restarSobre.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.mensaje) {
                alert(data.mensaje);
                abrir(api, img, nombre);
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error("Error al realizar la compra:", error);
            alert("Hubo un error al procesar la compra.");
        });
    }

    function abrir(api, img, nombre) {
        
        const modalImg = document.getElementById("modalImg");
        const modal = new bootstrap.Modal(document.getElementById("modalSobre"));
        const cardInfo = document.getElementById("cardInfo");

        // Reset variables y estilos
        imageReplaced = false;
        cardInfo.innerHTML = "";
        modalImg.src = `../img/${img}`;
        modalImg.style.pointerEvents = "auto";
        
        modal.show();

        modalImg.onclick = function () {
            if (!imageReplaced) {
                modalImg.style.pointerEvents = "none";
                fetch(`https://api-pokemon-nu.vercel.app/${api}`)
                    .then(response => response.json())
                    .then(data => {
                        const randomCard = getRandomCard(data);
        
                        fetch("addSobreAbierto.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: `nombreSobre=${nombre}&nombreCarta=${randomCard.name}&numero=${randomCard.number}&img=${randomCard.image}`,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert("Error añadir sobre abierto");
                            }
                        })
                        .catch(error => {
                            alert("Error añadir sobre abierto 2");
                        });
        
                        modalImg.src = randomCard.image;
                        modalImg.style.maxHeight = "300px";
                        modalImg.style.objectFit = "contain";
        
                        console.log(randomCard.rarity);
        
                        cardInfo.innerHTML = `
                            <h5><strong>${randomCard.number} - ${randomCard.name}</strong></h5>
                            <h6><strong>Tipo:</strong> ${randomCard.type}</h6>
                            <h6><strong>Rareza:</strong> ${randomCard.rarity}</h6>
                            <h6><strong>Precio:</strong> <span id="precioCarta">Cargando...</span></h6>
                            <div class="mt-3">
                                <button class="btn btn-primary me-2" id="venderCarta">Vender Carta</button>
                                <button class="btn btn-success" id="enviarCarta">Envíamela</button>
                            </div>
                        `;
        
                        document.getElementById("venderCarta").onclick = function () {
                            venderCarta();
                        };
        
                        document.getElementById("enviarCarta").onclick = function () {
                            enviarCarta(randomCard.number, randomCard.name);
                        };
        
                        fetch("precioscartas.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: `type=${encodeURIComponent(randomCard.rarity)}`,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                console.log(data.precio);
                                document.getElementById("precioCarta").textContent = data.precio;
                            } else {
                                console.error("Error al obtener el precio:", data.message);
                                document.getElementById("precioCarta").textContent = "No disponible";
                            }
                        })
                        .catch(error => {
                            console.error("Error en la petición:", error);
                            document.getElementById("precioCarta").textContent = "Error";
                        });
                        
                        function enviarCarta(numero, nombre) {
                            let saldo = parseFloat(document.getElementById("wallet").textContent);
                            let precioNum = parseFloat(document.getElementById("precioCarta").textContent);
                            
                            if (isNaN(precioNum)) {
                                alert("Precio no válido, intenta nuevamente.");
                                return;
                            }
                            
                            modal.hide();
                            const modalEnvio = new bootstrap.Modal(document.getElementById('modalEnvio'), {
                                backdrop: 'static',
                                keyboard: false
                            });
                        
                            const tiposEnvioList = document.getElementById('tiposEnvioList');
                        
                            fetch("preciosEnvios.php")
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === "success") {
                                        tiposEnvioList.innerHTML = "";
                                        
                                        data.data.forEach(envio => {
                                            const listItem = document.createElement('li');
                                            listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                                            listItem.innerHTML = `${envio.empresa} - ${envio.tipo} - ${envio.precio}€`;
                                            
                                            const selectButton = document.createElement('button');
                                            selectButton.classList.add('btn', 'btn-sm', 'btn-primary');
                                            selectButton.textContent = 'Seleccionar';
                                            selectButton.onclick = function () {
                                                let envioPrecio = parseFloat(envio.precio);
                                                let saldoFinal = (saldo - envioPrecio).toFixed(2);
                                                actualizarSaldo(saldoFinal);
                                                addPedido(precioNum, envio, numero, nombre);
                                                modalEnvio.hide();
                                            };
                                            
                                            listItem.appendChild(selectButton);
                                            tiposEnvioList.appendChild(listItem);
                                        });
                                        modalEnvio.show();
                                    } else {
                                        console.error("Error al obtener los tipos de envío:", data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error("Error en la petición de tipos de envío:", error);
                                });
                        }

                        function addPedido(precioCarta, envio, numeroCarta, nombreCarta) {
                            let nuevoPedido = {
                                numeroCarta: numeroCarta,
                                nombreCarta: nombreCarta,
                                precioCarta: precioCarta,
                                empresaEnvio: envio.empresa,
                                tipoEnvio: envio.tipo,
                                precioEnvio: envio.precio
                            };
                        
                            fetch("nuevoPedido.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(nuevoPedido)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    console.log("Pedido registrado correctamente.");
                                } else {
                                    alert("Hubo un error al registrar el pedido: " + data.message);
                                }
                            })
                            .catch(error => {
                                alert("Hubo un error al procesar tu pedido. Intenta nuevamente.");
                            });
                        }
                        
                        
                        function venderCarta() {
                            let saldo = parseFloat(document.getElementById("wallet").textContent);
                            let precioNum = parseFloat(document.getElementById("precioCarta").textContent);
                            
                            if (isNaN(precioNum)) {
                                alert("Precio no válido, intenta nuevamente.");
                                return;
                            }
                        
                            let saldoFinal = (saldo + precioNum).toFixed(2);
                            actualizarSaldo(saldoFinal);
                        }
                        
                        function actualizarSaldo(saldoFinal) {
                            let datosActualizados = {
                                cartera: saldoFinal
                            };
                        
                            fetch("actualizarSaldo.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(datosActualizados)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    // Actualizar la interfaz de usuario con el nuevo saldo
                                    document.getElementById("wallet").textContent = saldoFinal;
                                    modal.hide();  // Cerrar el modal
                                } else if (data.status === "error") {
                                    alert(data.message);
                                } else {
                                    alert("Hubo un problema con la respuesta del servidor.");
                                }
                            })
                            .catch(error => {
                                alert("Hubo un error al procesar la compra.");
                                console.error(error); // Para que puedas ver qué error ocurrió
                            });
                        }
                        
        
                        imageReplaced = true;
                    })
                    .catch(error => console.error("Error al cargar las cartas:", error));
            }
        };        
    }

    function getRandomCard(cards) {
        return cards[Math.floor(Math.random() * cards.length)];
    }
});
