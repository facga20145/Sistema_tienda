document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const productImageInput = document.getElementById('productImage');
    const previewImage = document.getElementById('previewImage');

    productImageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

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
                // Aquí puedes hacer cualquier otra cosa que necesites después de guardar en la base de datos
                resetForm(); // Resetear el formulario después de agregar el producto
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function resetForm() {
        document.getElementById('productName').value = '';
        document.getElementById('productPrice').value = '';
        document.getElementById('productDescription').value = '';
        document.getElementById('productCategory').value = '';

        // Resetear el campo de imagen
        document.getElementById('productImage').value = '';
        previewImage.src = '';
        previewImage.style.display = 'none';
    }
});
