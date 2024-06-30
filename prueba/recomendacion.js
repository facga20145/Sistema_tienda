const modelURL = './my_model/model.json';
const metadataURL = './my_model/metadata.json';

let model, maxPredictions;
let primeraRecomendacion = true;

async function init() {
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();
    console.log("Model loaded");
}

async function obtenerRecomendaciones() {
    const fileInput = document.getElementById('image-upload');
    const image = fileInput.files[0];
    if (!image) {
        alert("Por favor, selecciona una imagen primero.");
        return;
    }

    const reader = new FileReader();
    reader.onload = async function(event) {
        const img = new Image();
        img.src = event.target.result;
        img.onload = async function() {
            const prediction = await model.predict(img);
            console.log("Predictions:", prediction);

            let highestPrediction = prediction[0];
            for (let i = 1; i < prediction.length; i++) {
                if (prediction[i].probability > highestPrediction.probability) {
                    highestPrediction = prediction[i];
                }
            }
            const predictedClass = highestPrediction.className;
            console.log(`Highest Prediction: ${predictedClass}, Probability: ${highestPrediction.probability}`);

            const productosGuardados = JSON.parse(localStorage.getItem('productos')) || [];
            console.log("Productos en storage:", productosGuardados);

            const productosRecomendados = productosGuardados.filter(producto => {
                return producto.categoria.toLowerCase() === predictedClass.toLowerCase();
            });

            console.log("Productos recomendados:", productosRecomendados);

            if (productosRecomendados.length > 0) {
                let bestMatches = [];
                for (const producto of productosRecomendados) {
                    const productImage = new Image();
                    productImage.src = producto.imagen;
                    await new Promise(resolve => productImage.onload = resolve);

                    const productPrediction = await model.predict(productImage);
                    let score = 0;
                    for (const pred of productPrediction) {
                        if (pred.className === predictedClass) {
                            score = pred.probability;
                            break;
                        }
                    }

                    bestMatches.push({ producto, score });
                }

                bestMatches.sort((a, b) => b.score - a.score);

                let topMatches = [];
                if (primeraRecomendacion) {
                    // La primera vez, mostrar las mejores 3 recomendaciones
                    topMatches = bestMatches.slice(0, 3).map(match => match.producto);
                    primeraRecomendacion = false;
                } else {
                    // En las siguientes recomendaciones, mostrar 3 productos aleatorios
                    while (topMatches.length < 3 && bestMatches.length > 0) {
                        const randomIndex = Math.floor(Math.random() * bestMatches.length);
                        topMatches.push(bestMatches[randomIndex].producto);
                        bestMatches.splice(randomIndex, 1);
                    }
                }

                mostrarProductosRecomendados(topMatches);
            } else {
                mostrarProductosRecomendados([]);
            }
        };
    };
    reader.readAsDataURL(image);
}

function mostrarProductosRecomendados(productos) {
    const recomendacionDiv = document.getElementById('recomendaciones');
    recomendacionDiv.innerHTML = '';

    if (productos.length > 0) {
        productos.forEach(producto => {
            const productoDiv = document.createElement('div');
            productoDiv.innerHTML = `
                <img src="${producto.imagen}" alt="${producto.nombre}" width="100">
                <p>Nombre: ${producto.nombre}</p>
                <p>Precio: ${producto.precio}</p>
                <p>Categoría: ${producto.categoria}</p>
            `;
            recomendacionDiv.appendChild(productoDiv);
        });
    } else {
        recomendacionDiv.innerHTML = '<p>No se encontraron recomendaciones basadas en tus preferencias.</p>';
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('recomendar-btn').addEventListener('click', obtenerRecomendaciones);
    init();
});
