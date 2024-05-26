document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const productsContainer = document.getElementById('productsContainer');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const saveChangesButton = document.getElementById('saveChanges');
    const editProductImageInput = document.getElementById('editProductImage');
    let currentProductCard;

    // Función para renderizar un producto
    function renderProduct(product) {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        productCard.dataset.productId = product.productoID;

        productCard.innerHTML = `
            <button class="delete-button">X</button>
            <div><strong>Nombre:</strong> ${product.nombreProducto}</div>
            <div><strong>Precio:</strong> $${product.precio}</div>
            <div><strong>Descripción:</strong> ${product.descripcionProducto}</div>
            <div><strong>Categoría:</strong> ${product.categoriaID}</div>
            <img src="${product.foto}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">
            <button class="edit-button">Editar</button>
        `;
        productsContainer.appendChild(productCard);

        // Manejar la eliminación del producto
        productCard.querySelector('.delete-button').addEventListener('click', function() {
            const productId = productCard.dataset.productId;
            fetch(`eliminarproducto.php?id=${productId}`, { method: 'GET' })
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

        productCard.querySelector('.edit-button').addEventListener('click', function() {
            editModal.style.display = 'block';
            currentProductCard = productCard;

            document.getElementById('editProductName').value = product.nombreProducto;
            document.getElementById('editProductPrice').value = product.precio;
            document.getElementById('editProductDescription').value = product.descripcionProducto;
            document.getElementById('editProductCategory').value = product.categoriaID;

            const editImageContainer = document.getElementById('editImageContainer');
            editImageContainer.innerHTML = `<img src="${product.foto}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
        });
    }

    // Cargar productos desde la base de datos
    fetch('obtenerproductos.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
                renderProduct(product);
            });
        })
        .catch(error => console.error('Error:', error));

    form.addEventListener('submit', function(event) {
        event.preventDefault();

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
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
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
        const newProductName = document.getElementById('editProductName').value;
        const newProductPrice = document.getElementById('editProductPrice').value;
        const newProductDescription = document.getElementById('editProductDescription').value;
        const newProductCategory = document.getElementById('editProductCategory').value;
        const newProductImage = document.getElementById('editProductImage').files[0];

        const reader = new FileReader();

        reader.onload = function(e) {
            currentProductCard.innerHTML = `
                <div><strong>Nombre:</strong> ${newProductName}</div>
                <div><strong>Precio:</strong> $${newProductPrice}</div>
                <div><strong>Descripción:</strong> ${newProductDescription}</div>
                <div><strong>Categoría:</strong> ${newProductCategory}</div>
                <img src="${e.target.result}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">
                <button class="edit-button">Editar</button>
            `;
            currentProductCard.querySelector('.edit-button').addEventListener('click', function() {
                editModal.style.display = 'block';
                document.getElementById('editProductName').value = newProductName;
                document.getElementById('editProductPrice').value = newProductPrice;
                document.getElementById('editProductDescription').value = newProductDescription;
                document.getElementById('editProductCategory').value = newProductCategory;

                const editImageContainer = document.getElementById('editImageContainer');
                editImageContainer.innerHTML = `<img src="${e.target.result}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
            });
        };

        if (newProductImage) {
            reader.readAsDataURL(newProductImage);
        } else {
            currentProductCard.innerHTML = `
                <div><strong>Nombre:</strong> ${newProductName}</div>
                <div><strong>Precio:</strong> $${newProductPrice}</div>
                <div><strong>Descripción:</strong> ${newProductDescription}</div>
                <div><strong>Categoría:</strong> ${newProductCategory}</div>
                <button class="edit-button">Editar</button>
            `;
            currentProductCard.querySelector('.edit-button').addEventListener('click', function() {
                editModal.style.display = 'block';
                document.getElementById('editProductName').value = newProductName;
                document.getElementById('editProductPrice').value = newProductPrice;
                document.getElementById('editProductDescription').value = newProductDescription;
                document.getElementById('editProductCategory').value = newProductCategory;

                const editImageContainer = document.getElementById('editImageContainer');
                editImageContainer.innerHTML = `<img src="" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
            });
        }

        editModal.style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    };
});
