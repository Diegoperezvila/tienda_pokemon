document.addEventListener("DOMContentLoaded", function () {
    const ticketsContainer = document.getElementById("tickets");

    function fetchTickets() {
        fetch("verTickets.php")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    mostrarTickets(data.data);
                } else {
                    console.error("Error al obtener los sobres:", data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
    }

    function mostrarTickets(tickets) {
        ticketsContainer.innerHTML = "";

        tickets.forEach(ticket => {
            const ticketCard = document.createElement("div");
            ticketCard.classList.add("col-12", "col-md-4", "p-2");

            ticketCard.innerHTML = `
                <div class="card p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" class="form-control mb-2" value="${ticket.nombre}" readonly>
                           
                            <label>Email:</label>
                            <input type="text" name="email" class="form-control mb-2" value="${ticket.email}" readonly>
                           
                            <label>Mensaje:</label>
                            <input type="text" name="mensaje" class="form-control mb-2" value="${ticket.mensaje}" readonly>
                           
                            <label>Fecha:</label>
                            <input type="text" name="fecha" class="form-control mb-2" value="${ticket.fecha}" readonly>
                        </div>
                    </div>
                </div>
            `;

            ticketsContainer.appendChild(ticketCard);
        });
    }

    fetchTickets();//Obtenemos todos los tickets
});