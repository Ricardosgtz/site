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

// Verificar si se ha pasado un ID de usuario
if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); // Asegurarse de que el ID sea un número

    // Obtener datos del usuario
    $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = htmlspecialchars($row['nombre_usuario']);
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "ID de usuario no especificado.";
    exit;
}

// Procesar la actualización del usuario
$mensaje = ''; // Variable para almacenar el mensaje

if (isset($_POST['actualizar'])) {
    $nuevo_nombre = htmlspecialchars(trim($_POST['nombre_usuario']));
    $nueva_contrasena = trim($_POST['contrasena']); // No aplicar hash aún

    // Comprobar si se debe actualizar la contraseña
    if (!empty($nueva_contrasena)) {
        $nueva_contrasena_hashed = password_hash($nueva_contrasena, PASSWORD_DEFAULT); // Utilizar password_hash
        $sql = "UPDATE usuarios SET nombre_usuario = '$nuevo_nombre', password_usuario = '$nueva_contrasena_hashed' WHERE id_usuario = $id_usuario";
    } else {
        // Si la contraseña no se cambia, solo actualizar el nombre
        $sql = "UPDATE usuarios SET nombre_usuario = '$nuevo_nombre' WHERE id_usuario = $id_usuario";
    }

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Usuario actualizado correctamente."; // Establecer mensaje
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f4f8;
        }
        .container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s;
        }
        .container:hover {
            transform: scale(1.05);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #6a11cb;
            outline: none;
        }
        button {
            font-family: 'Poppins', sans-serif;
            padding: 12px;
            color: white;
            background-color: #6a11cb;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2575fc;
        }
        .message {
            margin: 15px 0;
            color: #28a745; /* Verde */
            font-weight: bold;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #6a11cb;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #2575fc;
        }
    </style>
    <!-- Fuentes de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Editar Usuario</h2>
    <?php
    // Mostrar mensaje si existe
    if (!empty($mensaje)) {
        echo '<div class="message">' . htmlspecialchars($mensaje) . '</div>';
    }
    ?>
    <form action="" method="post">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo $nombre_usuario; ?>" required>

        <label for="contrasena">Nueva Contraseña (opcional):</label>
        <input type="password" name="contrasena" id="contrasena">

        <button type="submit" name="actualizar">Actualizar Usuario</button>
    </form>
    <a href="Usuarios.php">Regresar a la gestión de usuarios</a>
</div>

</body>
</html>
