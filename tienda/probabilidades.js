document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);//Parámetro de la url
    const textoDeUrl = urlParams.get('texto');

    const apiUrl = `https://api-pokemon-nu.vercel.app/${textoDeUrl}`; //Crear url de la api

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
    const cardContainer = document.getElementById('cartas');

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

        cardContainer.appendChild(cardDiv);
    });
}

//General pdf de cada expansión
document.getElementById('generarPDF').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const urlParams = new URLSearchParams(window.location.search);//Parámetro de la url
    const textoDeUrl = urlParams.get('texto');

    doc.setFontSize(16);
    doc.text('Lista de Cartas de Pokémon - ' + textoDeUrl, 10, 10);

    let yPosition = 20;

    listaPokemon.forEach((card, index) => {
        const cardInfo = `${card.number} - ${card.name} - ${card.type} - ${card.rarity}`;
        
        doc.setFontSize(12);
        doc.text(cardInfo, 10, yPosition);

        yPosition += 10;

        if (yPosition > 270) {
            doc.addPage();
            yPosition = 10;
        }
    });

    doc.save(`${textoDeUrl}.pdf`);
});
