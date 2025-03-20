document.addEventListener("DOMContentLoaded", function () {
    function fetchWallet() {
        fetch("../mostrarSaldo.php")
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    document.getElementById("wallet").textContent = data.cartera; 
                } else {
                    console.error("Error al obtener el saldo:", data.message);
                }
            })
            .catch(error => console.error("Error en la petición:", error));
    }
    fetchWallet();
});
