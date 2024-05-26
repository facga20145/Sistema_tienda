<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa - StyleGenie</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de que la ruta al CSS sea correcta -->
</head>
<body>
    <div class="container">
        <h1>Registro de Empresa</h1>
        <form action="../../controlador/C_R_Empresa.php" method="post">
            <label for="nombreEmpresa">Nombre de la Empresa:</label>
            <input type="text" id="nombreEmpresa" name="nombreEmpresa" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contrasenha">Contraseña:</label>
            <input type="password" id="contrasenha" name="contrasenha" required>

            <!-- Este campo está asumiendo que el usuarioID será manejado en el back-end, por ejemplo, asignado al usuario que crea la empresa. -->
            <!-- <input type="hidden" id="usuarioID" name="usuarioID" value="ID_Asignado"> -->

            <button type="submit">Registrar Empresa</button>
        </form>
        <p>¿Ya estás registrado? <a href="Empresa_login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
