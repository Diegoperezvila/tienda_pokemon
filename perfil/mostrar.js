document.addEventListener("DOMContentLoaded", function () {
  function verAperturas() {
    fetch("verAperturas.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          mostrarUltimosPedidos(data.data);
        } else {
          console.error("No se encontraron registros:", data.message);
        }
      })
      .catch((error) =>
        console.error("Error al obtener los registros:", error)
      );

    function mostrarUltimosPedidos(pedidos) {
      const container = document.getElementById("aperturas");
      container.innerHTML = "";

      if (pedidos.length === 0) {
        container.innerHTML = "<p>No hay registros recientes.</p>";
      } else {
        pedidos.forEach((pedido) => {
          const pedidoDiv = document.createElement("div");
          pedidoDiv.classList.add("row", "mb-3");

          pedidoDiv.innerHTML = `
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="${pedido.img}" alt="${pedido.nombreCarta}" class="img-fluid" style="max-width: auto; height: 100px;">
                    </div>
                    <div class="col-9 d-flex flex-column text-center justify-content-center">
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

  function verPedidos(orden, estado) {
    fetch("verPedidos.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ orden: orden, estado: estado }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          mostrarUltimosPedidos(data.data);
        } else {
          console.error("No se encontraron registros:", data.message);
        }
      })
      .catch((error) =>
        console.error("Error al obtener los registros:", error)
      );

    function mostrarUltimosPedidos(pedidos) {
      const container = document.getElementById("pedidos");
      container.innerHTML = "";

      if (pedidos.length === 0) {
        container.innerHTML = "<p>No hay registros recientes.</p>";
      } else {
        pedidos.forEach((pedido) => {
          const pedidoDiv = document.createElement("div");
          pedidoDiv.classList.add("row", "mb-3");

          pedidoDiv.innerHTML = `
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="${pedido.imagen}" alt="${pedido.nombreCarta}" class="img-fluid" style="max-width: auto; height: 100px;">
                    </div>
                    <div class="col-9 d-flex flex-column text-center justify-content-center">
                        <h5><strong></strong> ${pedido.numeroCarta} - ${pedido.nombreCarta} - ${pedido.precioCarta}€</h5>
                        <h5><strong></strong> Estado - ${pedido.estado}</h5>
                    </div>
                `;

          container.appendChild(pedidoDiv);
        });
      }
    }
  }

  verAperturas();
  verPedidos("", "");//Filtramos por todos los pedidos

const formulario = document.querySelector("#offcanvasFilters form");
const offcanvasElement = document.getElementById('offcanvasFilters');
const offcanvas = new bootstrap.Offcanvas(offcanvasElement);

formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    const ordenSelect = document.getElementById("orden");
    const estadoSelect = document.getElementById("estado");

    const orden = ordenSelect.value;
    const estado = estadoSelect.value;

    offcanvas.hide();

    verPedidos(orden, estado);//Filtramos por el orden y estado del form
});
});
