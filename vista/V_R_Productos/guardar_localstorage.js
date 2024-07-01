const modelURL = '../../my_model/model.json';
const metadataURL = '../../my_model/metadata.json';
let model, maxPredictions;

// Función para cargar el modelo
async function init() {
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();
    console.log("Model loaded");
}

init();

function uploadAndAnalyze() {
    const archivo = document.getElementById('productImage').files[0];
    const nombre = document.getElementById('productName').value;
    const precio = document.getElementById('productPrice').value;
    const categoria = document.getElementById('productCategory').selectedOptions[0].text;
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
    const contenedor = document.getElementById("productsContainer");
    contenedor.innerHTML = '';

    productos.forEach(producto => {
        const div = document.createElement('div');
        div.className = 'product-card';
        div.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}" style="width:100px;height:100px;">
            <p><strong>Nombre:</strong> ${producto.nombre}</p>
            <p><strong>Precio:</strong> $${producto.precio}</p>
            <p><strong>Categoría:</strong> ${producto.categoria}</p>
        `;
        contenedor.appendChild(div);
    });
}

function resetForm() {
    document.getElementById('productName').value = '';
    document.getElementById('productPrice').value = '';
    document.getElementById('productDescription').value = '';
    document.getElementById('productCategory').value = '';

    // Resetear el campo de imagen
    document.getElementById('productImage').value = '';
    document.getElementById('previewImage').src = '';
    document.getElementById('previewImage').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form').addEventListener('submit', function(event) {
        event.preventDefault();
        uploadAndAnalyze();
    });
    displayProducts();
});
