<?php
session_start(); // Iniciar sesión

// Variables de conexión
$servidor = 'localhost';
$usuario = 'root';
$clave = '';
$base_datos = 'family_store';

// Conectar a la base de datos
$conn = mysqli_connect($servidor, $usuario, $clave, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar inicio de sesión
if (isset($_POST['login'])) {
    $nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
    $contrasena = md5($_POST['contrasena']); // Asegúrate de usar el mismo método de hash que usaste al guardar la contraseña

    // Verificar si la columna se llama 'password_usuario' (en vez de 'contrasena')
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND password_usuario = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado, guardar información en la sesión
        $_SESSION['nombre_usuario'] = $nombre_usuario;

        // Obtener el rol del usuario para almacenarlo en la sesión
        $row = $result->fetch_assoc();
        $_SESSION['rol'] = $row['rol'];

        header("Location: menu.php"); // Redirigir a la página de gestión de usuarios
        exit;
    } else {
        $mensaje = "Nombre de usuario o contraseña incorrectos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Fuente moderna */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7; /* Color de fondo suave */
        }
        .container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 700; /* Texto en negrita */
        }
        input[type="text"], input[type="password"] {
            font-family: 'Poppins', sans-serif;
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            font-family: 'Poppins', sans-serif;
            border-color: #6a11cb; /* Color de enfoque */
            outline: none;
        }
        button {
            font-family: 'Poppins', sans-serif;
            padding: 12px;
            color: white;
            background-color: #6a11cb; /* Color principal */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2575fc; /* Color al pasar el mouse */
        }
        .message {
            margin: 15px 0;
            color: #dc3545; /* Color rojo */
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($mensaje)) { echo '<div class="message">' . htmlspecialchars($mensaje) . '</div>'; } ?>
    <form action="" method="post">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>

        <button type="submit" name="login">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>
