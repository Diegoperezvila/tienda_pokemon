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
                            .then((response) => response.json())
                            .then((data) => {
                              if (data.error) {
                                alert("Error añadir sobre abierto");
                              }
                            })
                            .catch((error) => {
                                alert("Error añadir sobre abierto 2");
                            });
                        modalImg.src = randomCard.image;
                        modalImg.style.maxHeight = "300px";
                        modalImg.style.objectFit = "contain";

                        cardInfo.innerHTML = `
                            <h5><strong>${randomCard.number} - ${randomCard.name}</strong></h5>
                            <h6><strong>Tipo:</strong> ${randomCard.type}</h6>
                            <h6><strong>Rareza:</strong> ${randomCard.rarity}</h6>
                        `;

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
