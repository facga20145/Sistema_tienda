document.addEventListener('DOMContentLoaded', function() {
    let productos = [];

    fetch("../../V_R_Productos/obtenerproductos.php")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                console.log('Datos obtenidos:', data); // Verifica los datos obtenidos
                productos = data;
                cargarProductos(productos);
            }
        })
        .catch(error => console.error('Fetch error:', error));

    const contenedorProductos = document.querySelector("#contenedor-productos");
    const botonesCategorias = document.querySelectorAll(".boton-categoria");
    const tituloPrincipal = document.querySelector("#titulo-principal");
    let botonesAgregar = document.querySelectorAll(".producto-agregar");
    const numerito = document.querySelector("#numerito");

    botonesCategorias.forEach(boton => boton.addEventListener("click", () => {
        aside.classList.remove("aside-visible");
    }));

    function cargarProductos(productosElegidos) {
        contenedorProductos.innerHTML = "";

        productosElegidos.forEach(producto => {
            const div = document.createElement("div");
            div.classList.add("producto");
            div.innerHTML = `
                <img class="producto-imagen" src="../../V_R_Productos/${producto.foto}" alt="${producto.nombreProducto}">
                <div class="producto-detalles">
                    <h3 class="producto-titulo">${producto.nombreProducto}</h3>
                    <p class="producto-precio">Precio: $${producto.precio}</p>
                    <p class="producto-descripcion">Descripcion: ${producto.descripcionProducto}</p>
                    <p class="producto-categoria">Categoría: ${producto.categoriaID}</p>
                    <button class="producto-agregar" id="${producto.productoID}">Agregar</button>
                </div>
            `;
            contenedorProductos.append(div);
        });

        actualizarBotonesAgregar();
    }

    botonesCategorias.forEach(boton => {
        boton.addEventListener("click", (e) => {
            botonesCategorias.forEach(boton => boton.classList.remove("active"));
            e.currentTarget.classList.add("active");

            if (e.currentTarget.id != "todos") {
                const productosBoton = productos.filter(producto => producto.categoriaID == e.currentTarget.id);
                tituloPrincipal.innerText = e.currentTarget.textContent.trim();
                cargarProductos(productosBoton);
            } else {
                tituloPrincipal.innerText = "Todos los productos";
                cargarProductos(productos);
            }
        });
    });

    function actualizarBotonesAgregar() {
        botonesAgregar = document.querySelectorAll(".producto-agregar");

        botonesAgregar.forEach(boton => {
            boton.addEventListener("click", agregarAlCarrito);
        });
    }

    let productosEnCarrito;

    let productosEnCarritoLS = localStorage.getItem("productos-en-carrito");

    if (productosEnCarritoLS) {
        productosEnCarrito = JSON.parse(productosEnCarritoLS);
        actualizarNumerito();
    } else {
        productosEnCarrito = [];
    }

    function agregarAlCarrito(e) {
        Toastify({
            text: "Producto agregado",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right, #4b33a8, #785ce9)",
                borderRadius: "2rem",
                textTransform: "uppercase",
                fontSize: ".75rem"
            },
            offset: {
                x: '1.5rem',
                y: '1.5rem'
            },
            onClick: function(){} 
        }).showToast();

        const idBoton = e.currentTarget.id;
        const productoAgregado = productos.find(producto => producto.productoID == idBoton);

        if (productosEnCarrito.some(producto => producto.productoID == idBoton)) {
            const index = productosEnCarrito.findIndex(producto => producto.productoID == idBoton);
            productosEnCarrito[index].cantidad++;
        } else {
            productoAgregado.cantidad = 1;
            productosEnCarrito.push(productoAgregado);
        }

        actualizarNumerito();
        localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
    }

    function actualizarNumerito() {
        let nuevoNumerito = productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0);
        numerito.innerText = nuevoNumerito;
    }
});