document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const textoDeUrl = urlParams.get('texto');

    const apiUrl = `https://api-pokemon-nu.vercel.app/${textoDeUrl}`;

    listaPokemon = [];

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            listaPokemon = data;
            const rarezasContadas = contarRarezas(listaPokemon);
            mostrarRarezas(rarezasContadas, listaPokemon.length);
            mostrarCartas(listaPokemon);
        })
        .catch(error => console.error('Error al obtener los datos:', error));
});

function contarRarezas(pokemonList) {
    const rarezas = {};

    pokemonList.forEach(pokemon => {
        const rareza = pokemon.rarity;

        if (rarezas[rareza]) {
            rarezas[rareza] += 1; 
        } else {
            rarezas[rareza] = 1; 
        }
    });

    return rarezas;
}

function mostrarRarezas(rarezasContadas, totalPokemon) {
    const listaRarezasDiv = document.getElementById('probabilidades');
    listaRarezasDiv.innerHTML = '';

    for (const rareza in rarezasContadas) {
        const porcentaje = (rarezasContadas[rareza] / totalPokemon) * 100;
        const item = document.createElement('li');
        item.textContent = `${rareza}: ${porcentaje.toFixed(2)}%`;
        listaRarezasDiv.appendChild(item);
    }
}

function mostrarCartas(listaPokemon){
    // Obtener el contenedor donde se mostrarán las cartas
    const cardContainer = document.getElementById('cartas');

    // Mostrar las cartas en el contenedor
    listaPokemon.forEach(card => {
        const cardDiv = document.createElement('div');
        cardDiv.classList.add('card');

        cardDiv.innerHTML = `
            <img class="imgPoke" src="${card.image}" alt="${card.number}">
            <div class="card-info">
                <p><strong>${card.number} - ${card.name}</strong></p>
                <p><strong>Tipo:</strong> ${card.type}</p>
                <p><strong>Rareza:</strong> ${card.rarity}</p>
            </div>
        `;

        // Agregar la carta al contenedor
        cardContainer.appendChild(cardDiv);
    });
}