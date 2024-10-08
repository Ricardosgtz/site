<!-- manage_users.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 900px;
            transition: transform 0.3s;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], select {
            width: 95%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="password"]:focus, select:focus {
            border-color: #80bdff;
            outline: none;
        }
        button {
            font-family: 'Poppins', sans-serif;
            padding: 12px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .edit-btn {
            background-color: #ffc107;
        }
        .edit-btn:hover {
            background-color: #e0a800;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .back-btn {
            background-color: #007bff;
            margin-top: 10px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
    
</head>
<body>

<div class="container">
    <h2>Gestión de Usuarios</h2>

    <!-- Formulario para agregar usuarios -->
    <form action="Usuarios.php" method="post">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>

        <label for="rol">Rol del Usuario:</label>
        <select name="rol" id="rol" required>
            <option value="empleado">Empleado</option>
            <option value="admin">Administrador</option>
        </select>

        <button type="submit" name="agregar">Agregar Usuario</button>
    </form>

    <br>

    <!-- Mostrar la tabla de usuarios -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre de Usuario</th>
            <th>Rol</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>

        <?php
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
        
        // Procesar la adición de un nuevo usuario
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contrasena = md5($_POST['contrasena']); // Encriptación simple con md5
            $rol = $_POST['rol'];

            $sql = "INSERT INTO usuarios (nombre_usuario, password_usuario, rol) 
                    VALUES ('$nombre_usuario', '$contrasena', '$rol')";
            if ($conn->query($sql) === TRUE) {
                // Redirigir a la misma página para evitar reenvíos
                header("Location: Usuarios.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Procesar la eliminación de un usuario
        if (isset($_GET['eliminar'])) {
            $id_usuario = $_GET['eliminar'];
            $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
            if (mysqli_query($conn, $sql)) {
                echo "Usuario eliminado exitosamente.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Obtener todos los usuarios
        $sql = "SELECT * FROM usuarios";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id_usuario'] . "</td>";
                echo "<td>" . $row['nombre_usuario'] . "</td>";
                echo "<td>" . $row['rol'] . "</td>";
                echo "<td>" . $row['fecha_registro'] . "</td>";
                echo "<td>
                    <a href='EditarUsuarios.php?id=" . $row['id_usuario'] . "'><button class='edit-btn'>Editar</button></a>
                    <a href='Usuarios.php?eliminar=" . $row['id_usuario'] . "' onclick='return confirm(\"¿Estás seguro?\")'><button class='delete-btn'>Eliminar</button></a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
        }

        mysqli_close($conn);
        ?>

    </table>
    <a href="menu.php"><button class="back-btn">Volver al Menú</button></a>
</div>

</body>
</html>
