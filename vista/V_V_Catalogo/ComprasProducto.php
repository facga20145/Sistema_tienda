<!DOCTYPE html>
<html lang="es">
<head>
    <!--Meta etiquetas-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Titulo-->
    <title>Stylegenie | Compra</title>
    <!--Meta datos-->
    <meta name="description" content="Descubre estilo único en Stylegenie. Moda elegante y moderna para cada ocasión. ¡Explora y encuentra tu estilo con nosotros!">
    <!--MD Redes Sociales-->
    <meta property="og:title" content="Stylegenie | Compra">
    <meta property="og:description" content="Descubre estilo único en Stylegenie. Moda elegante y moderna para cada ocasión. ¡Explora y encuentra tu estilo con nosotros!">
    <meta property="og:image" content="">

    <!--Estilos-->
    <link rel="stylesheet" href="Estilos/style-compra.css">
    <link rel="icon" href="img/Logo.png"> <!--icon-->
    <link rel="apple-touch-icon" href=""> <!--icon de movil-->
    <meta name="theme-color" content="#FFFF0"> <!--color de barra de movil-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">

</head>
<body>
    <!--Encabezado-->

    <header class="header">
        <div class="header-logo">
            <img src="img/Logo.png" alt="">
            <h1><a href="index.html">Stylegenie</a></h1>
        </div>
        <nav class="nav">
            <div class="paste-button">
                <a class="comprar" href="compra.html">Comprar &nbsp;▼</a>
                <div class="dropdown-content">
                    <a href="compra.html">Polos</a>
                    <a href="compra.html">Pantalones</a>
                    <a href="compra.html">Camisas</a>
                    <a href="compra.html">Abrigos</a>
                    <a id="ult" href="">Zapatos</a>
                </div>
              </div>          
            <a href="">Blog</a>
            <a href="contacto.html">Contacto</a>
        </nav>
        <div class="header-search">
            <input type="text" placeholder="Buscar en Stylegenie">
            <button><img src="img/search.svg" alt=""></button>
        </div>
        <div class="header-options">           
            <a href="login.html"><img src="img/user.svg" alt="">Iniciar Sesión</a>
            <a href=""><img src="img/heart.svg" alt=""></a>
            <a href=""><img src="img/shopping-cart.svg" alt=""><div>0</div></a>
        </div>
    </header>

    <!--aside - redes-->

    <aside class="aside-redes">
        <a href=""><img class="facebook" src="img/facebook.svg" alt=""></a>
        <a href=""><img class="instagram" src="img/instagram.svg" alt=""></a>
        <a href=""><img class="tiktok" src="img/tiktok.svg" alt=""></a>
    </aside>

    <!--Cuerpo-->

    <main class="main">

        <!-- Catálogo de productos -->
    <div class="wrapper">
        <header class="header-mobile">
            <h1 class="logo">STYLEGENIE</h1>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <aside class="aside-elvis">
            <button class="close-menu" id="close-menu">
                <i class="bi bi-x"></i>
            </button>
            <header>
                <h1 class="logo">STYLEGENIE</h1>
            </header>
            <nav>
                <ul class="menu">
                    <li>
                        <button id="todos" class="boton-menu boton-categoria active"><i class="bi bi-hand-index-thumb-fill"></i> Todos los productos</button>
                    </li>
                    <li>
                        <button id="polos" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Polos</button>
                    </li>
                    <li>
                        <button id="pantalones" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Pantalones</button>
                    </li>
                    <li>
                        <button id="camisetas" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Camisetas</button>
                    </li>
                    <li>
                        <button id="abrigos" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Abrigos</button>
                    </li>
                    <li>
                        <button id="zapatos" class="boton-menu boton-categoria"><i class="bi bi-hand-index-thumb"></i> Zapatos</button>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito" href="./carrito.php">
                            <i class="bi bi-cart-fill"></i> Carrito <span id="numerito" class="numerito">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© 2024 STYLEGENIE</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal" id="titulo-principal">Todos los productos</h2>
            <div id="contenedor-productos" class="contenedor-productos">
                <!-- Esto se va a rellenar con JS -->
            </div>
        </main>
    </div>

    </main>

    <!--ASIDE-->

    <aside class="aside-wsp">
        <a href=""><img src="img/whatsapp-svgrepo-com.svg" alt=""></a>
    </aside>

    <!--Pie de pagina-->

    <footer class="footer">
        <p>&copy;2024, Stylegenie</p>
    </footer>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="Scripts/main.js"></script>
    <script src="Scripts/menu.js"></script>

</body>
</html>