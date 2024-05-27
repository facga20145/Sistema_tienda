<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa - StyleGenie</title>
    <link rel="stylesheet" href="styleRegistro.css"> <!-- Asegúrate de que la ruta al CSS sea correcta -->
</head>
<body>
    <div class="container">
        <h1>Registro de Empresa</h1>
        <div class="container-logo">
            <img src="../../img/Logo.png" alt="" class="logo">
        </div>
        <form action="../../controlador/C_R_Empresa.php" method="post">
            
            <div class="form-1">
                <label>
                    Nombre de la Empresa:
                    <img src="../../img/empresa.svg" alt="" class="img-1">
                    <input type="text"name="nombreEmpresa" placeholder="Ingrese el nombre de su Empresa" required>
                </label>
    
                <label>
                    Dirección:
                    <img src="../../img/direccion.svg" alt="" class="img-2">
                    <input type="text" name="direccion" placeholder="Ingrese la dirección" required>
                </label>
    
                <label>
                    Teléfono:
                    <img src="../../img/telefono.svg" alt="" class="img-1">
                    <input type="tel" name="telefono" placeholder="Ingrese su telefono" required>
                </label>
            </div>
            <div class="barra"></div>
            <div class="form-1">
                <label>
                    Email:
                    <img src="../../img/email.svg" alt="" class="img-1">
                    <input type="email"name="email" placeholder="Ingrese su correo electrónico" required>
                </label>
    
                <label>
                    Contraseña:
                    <img src="../../img/lock.svg" alt="" class="img-1">
                    <input type="password" name="contrasenha" placeholder="Ingrese su contraseña" required>
                </label>

                <button type="submit">Registrar Empresa<img src="../../img/login.svg" alt=""></button>
                <p>¿Ya estás registrado? <a href="Empresa_login.html">Inicia sesión aquí</a></p

            </div>

            <!-- Este campo está asumiendo que el usuarioID será manejado en el back-end, por ejemplo, asignado al usuario que crea la empresa. -->
            <!-- <input type="hidden" id="usuarioID" name="usuarioID" value="ID_Asignado"> -->          
        </form>
        
    </div>
</body>
</html>