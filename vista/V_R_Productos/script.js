document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const productsContainer = document.getElementById('productsContainer');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const saveChangesButton = document.getElementById('saveChanges');
    const editProductImageInput = document.getElementById('editProductImage');
    let currentProductCard;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const productName = document.getElementById('productName').value;
        const productPrice = document.getElementById('productPrice').value;
        const productDescription = document.getElementById('productDescription').value;
        const productCategory = document.getElementById('productCategory').value;
        const productImage = document.getElementById('productImage').files[0];

        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        const reader = new FileReader();

        reader.onload = function(e) {
            productCard.innerHTML = `
                <div><strong>Nombre:</strong> ${productName}</div>
                <div><strong>Precio:</strong> $${productPrice}</div>
                <div><strong>Descripción:</strong> ${productDescription}</div>
                <div><strong>Categoría:</strong> ${productCategory}</div>
                <img src="${e.target.result}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">
                <button class="edit-button">Editar</button>
            `;
            productsContainer.appendChild(productCard);

            productCard.querySelector('.edit-button').addEventListener('click', function() {
                editModal.style.display = 'block';
                currentProductCard = productCard;

                document.getElementById('editProductName').value = productName;
                document.getElementById('editProductPrice').value = productPrice;
                document.getElementById('editProductDescription').value = productDescription;
                document.getElementById('editProductCategory').value = productCategory;

                const editImageContainer = document.getElementById('editImageContainer');
                editImageContainer.innerHTML = `<img src="${e.target.result}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
            });
        };

        if (productImage) {
            reader.readAsDataURL(productImage);
        } else {
            productCard.innerHTML = `
                <div><strong>Nombre:</strong> ${productName}</div>
                <div><strong>Precio:</strong> $${productPrice}</div>
                <div><strong>Descripción:</strong> ${productDescription}</div>
                <div><strong>Categoría:</strong> ${productCategory}</div>
                <button class="edit-button">Editar</button>
            `;
            productsContainer.appendChild(productCard);

            productCard.querySelector('.edit-button').addEventListener('click', function() {
                editModal.style.display = 'block';
                currentProductCard = productCard;

                document.getElementById('editProductName').value = productName;
                document.getElementById('editProductPrice').value = productPrice;
                document.getElementById('editProductDescription').value = productDescription;
                document.getElementById('editProductCategory').value = productCategory;

                const editImageContainer = document.getElementById('editImageContainer');
                editImageContainer.innerHTML = `<img src="" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
            });
        }

        form.reset();
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
        const editProductName = document.getElementById('editProductName').value;
        const editProductPrice = document.getElementById('editProductPrice').value;
        const editProductDescription = document.getElementById('editProductDescription').value;
        const editProductCategory = document.getElementById('editProductCategory').value;
        const editProductImage = document.getElementById('editProductImage').files[0];

        const formData = new FormData();
        formData.append('productName', editProductName);
        formData.append('productPrice', editProductPrice);
        formData.append('productDescription', editProductDescription);
        formData.append('productCategory', editProductCategory);
        if (editProductImage) {
            formData.append('productImage', editProductImage);
        }

        fetch('guardarproducto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            if (data.includes('Producto guardado exitosamente')) {
                currentProductCard.innerHTML = `
                    <div><strong>Nombre:</strong> ${editProductName}</div>
                    <div><strong>Precio:</strong> $${editProductPrice}</div>
                    <div><strong>Descripción:</strong> ${editProductDescription}</div>
                    <div><strong>Categoría:</strong> ${editProductCategory}</div>
                    <img src="${URL.createObjectURL(editProductImage)}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">
                    <button class="edit-button">Editar</button>
                `;

                currentProductCard.querySelector('.edit-button').addEventListener('click', function() {
                    editModal.style.display = 'block';
                    document.getElementById('editProductName').value = editProductName;
                    document.getElementById('editProductPrice').value = editProductPrice;
                    document.getElementById('editProductDescription').value = editProductDescription;
                    document.getElementById('editProductCategory').value = editProductCategory;

                    const editImageContainer = document.getElementById('editImageContainer');
                    editImageContainer.innerHTML = `<img src="${URL.createObjectURL(editProductImage)}" alt="Imagen del producto" style="width:100px;height:100px;margin-top:10px;">`;
                });

                editModal.style.display = 'none';
            } else {
                console.error('Error al guardar el producto:', data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    };
});
