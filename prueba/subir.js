const modelURL = '../my_model/model.json';
const metadataURL = '../my_model/metadata.json';
let model, maxPredictions;

// Función para cargar el modelo
async function init() {
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();
    console.log("Model loaded");
}

init();

function uploadAndAnalyze() {
    const archivo = document.getElementById('archivo').files[0];
    const nombre = document.getElementById('nombre').value;
    const precio = document.getElementById('precio').value;
    const categoria = document.getElementById('categoria').value;
    const reader = new FileReader();

    reader.onloadend = async function () {
        const img = new Image();
        img.src = reader.result;
        img.onload = async function () {
            const prediction = await model.predict(img);
            console.log(prediction);
            saveProduct({ nombre, precio, categoria, imagen: img.src });
            displayProducts();
            resetForm();
        };
    };

    if (archivo) {
        reader.readAsDataURL(archivo);
    } else {
        alert("Por favor selecciona una foto.");
    }
}

function saveProduct(product) {
    const productos = JSON.parse(localStorage.getItem("productos")) || [];
    productos.push(product);
    localStorage.setItem("productos", JSON.stringify(productos));
}

function displayProducts() {
    const productos = JSON.parse(localStorage.getItem("productos")) || [];
    const contenedor = document.getElementById("productos-guardados");
    contenedor.innerHTML = '';

    productos.forEach(producto => {
        const div = document.createElement('div');
        div.className = 'producto';
        div.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}">
            <p><strong>Nombre:</strong> ${producto.nombre}</p>
            <p><strong>Precio:</strong> $${producto.precio}</p>
            <p><strong>Categoría:</strong> ${producto.categoria}</p>
        `;
        contenedor.appendChild(div);
    });
}

function resetForm() {
    document.getElementById('archivo').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('precio').value = '';
    document.getElementById('categoria').value = '';
}

function deleteProducts() {
    localStorage.removeItem("productos");
    displayProducts();
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('subirAnalizar').addEventListener('click', uploadAndAnalyze);
    document.getElementById('borrarProductos').addEventListener('click', deleteProducts);
    displayProducts();
});
