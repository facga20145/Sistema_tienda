document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const productsContainer = document.getElementById('productsContainer');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const saveChangesButton = document.getElementById('saveChanges');
    const productImageInput = document.getElementById('productImage');
    const editProductImageInput = document.getElementById('editProductImage');
    let currentProductCard;

<<<<<<< HEAD
=======
    // Inicializar el modelo de Teachable Machine
    const modelURL = '../../my_model/model.json';
    const metadataURL = '../../my_model/metadata.json';
    let model, maxPredictions;

    async function init() {
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();
        console.log("Model loaded");
    }

    init();

>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
    // Función para renderizar un producto
    function renderProduct(product) {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';

        productCard.innerHTML = `
            <div><strong>Nombre:</strong> ${product.nombreProducto}</div>
            <div><strong>Precio:</strong> $${product.precio}</div>
            <div><strong>Descripción:</strong> ${product.descripcionProducto}</div>
<<<<<<< HEAD
            <div><strong>Categoría:</strong> ${product.categoriaID}</div>
=======
            <div><strong>Categoría:</strong> ${getCategoriaNombre(product.categoriaID)}</div>
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
            <img src="${product.foto}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">
            <button class="edit-button">Editar</button>
            <button class="delete-button">X</button>
        `;
        productsContainer.appendChild(productCard);

        productCard.querySelector('.edit-button').addEventListener('click', function() {
            editModal.style.display = 'block';
            currentProductCard = productCard;

            document.getElementById('editProductId').value = product.productoID;
            document.getElementById('editProductName').value = product.nombreProducto;
            document.getElementById('editProductPrice').value = product.precio;
            document.getElementById('editProductDescription').value = product.descripcionProducto;
            document.getElementById('editProductCategory').value = product.categoriaID;

            const editImageContainer = document.getElementById('editImageContainer');
            editImageContainer.innerHTML = `<img src="${product.foto}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
        });

        productCard.querySelector('.delete-button').addEventListener('click', function() {
            const productId = product.productoID;
            fetch(`eliminarproducto.php?id=${productId}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    productCard.remove();
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Cargar productos desde la base de datos
    fetch('obtenerproductos.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
<<<<<<< HEAD
=======
                product.categoria = getCategoriaNombre(product.categoriaID);
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
                renderProduct(product);
            });
        })
        .catch(error => console.error('Error:', error));

    form.addEventListener('submit', function(event) {
        event.preventDefault();

<<<<<<< HEAD
        const formData = new FormData(form);

        fetch('guardarproducto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderProduct(data.product);
                form.reset();
                const previewImage = document.getElementById('previewImage');
                previewImage.src = ''; // Limpiar la previsualización
                previewImage.style.display = 'none'; // Ocultar la previsualización
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });

=======
        // Subir y analizar la imagen antes de guardar
        const archivo = document.getElementById('productImage').files[0];
        const reader = new FileReader();

        reader.onloadend = async function () {
            const img = new Image();
            img.src = reader.result;
            img.onload = async function () {
                const prediction = await model.predict(img);
                console.log(prediction);

                // Ahora que tenemos la predicción, procedemos a guardar el producto
                const formData = new FormData(form);
                formData.append('prediccion', JSON.stringify(prediction));
                formData.append('foto', img.src); // Añadir la imagen como base64

                fetch('guardarproducto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.product.categoria = getCategoriaNombre(data.product.categoriaID);
                        renderProduct(data.product);
                        guardarProductoEnLocalStorage(data.product); // Guardar en localStorage
                        form.reset();
                        const previewImage = document.getElementById('previewImage');
                        previewImage.src = ''; // Limpiar la previsualización
                        previewImage.style.display = 'none'; // Ocultar la previsualización
                    } else {
                        console.error(data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            };
        };

        if (archivo) {
            reader.readAsDataURL(archivo);
        } else {
            alert("Por favor selecciona una foto.");
        }
    });

    function guardarProductoEnLocalStorage(producto) {
        let productosGuardados = JSON.parse(localStorage.getItem('productos')) || [];
        let productoReducido = {
            nombre: producto.nombreProducto,
            precio: producto.precio,
            imagen: producto.foto,
            categoria: getCategoriaNombre(producto.categoriaID) // Guardar el nombre de la categoría
        };
        productosGuardados.push(productoReducido);
        localStorage.setItem('productos', JSON.stringify(productosGuardados));
    }

>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
    productImageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
            previewImage.style.display = 'block'; // Mostrar la previsualización
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    editProductImageInput.addEventListener('change', function(event) {
        const newProductImage = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const editImageContainer = document.getElementById('editImageContainer');
            editImageContainer.innerHTML = `<img src="${e.target.result}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
        };

        if (newProductImage) {
            reader.readAsDataURL(newProductImage);
        }
    });

    saveChangesButton.addEventListener('click', function() {
        const formData = new FormData(editForm);

        fetch('actualizarproducto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentProductCard.querySelector('div:nth-child(1)').innerText = `Nombre: ${data.product.nombreProducto}`;
                currentProductCard.querySelector('div:nth-child(2)').innerText = `Precio: $${data.product.precio}`;
                currentProductCard.querySelector('div:nth-child(3)').innerText = `Descripción: ${data.product.descripcionProducto}`;
<<<<<<< HEAD
                currentProductCard.querySelector('div:nth-child(4)').innerText = `Categoría: ${data.product.categoriaID}`;
=======
                currentProductCard.querySelector('div:nth-child(4)').innerText = `Categoría: ${getCategoriaNombre(data.product.categoriaID)}`;
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
                currentProductCard.querySelector('img').src = data.product.foto;
                editModal.style.display = 'none';
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    };
<<<<<<< HEAD
});
=======

    function getCategoriaNombre(categoriaID) {
        switch (parseInt(categoriaID)) {
            case 1:
                return 'Polo';
            case 2:
                return 'Zapatilla-Zapato';
            default:
                return 'Desconocida';
        }
    }
});

function resetForm() {
    document.getElementById('archivo').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('precio').value = '';
    document.getElementById('categoria').value = '';
}
>>>>>>> aeaa91bd3b9e65cabd155ca7591047b0da16df8c
