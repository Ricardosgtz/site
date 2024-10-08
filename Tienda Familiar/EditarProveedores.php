<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_store";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del proveedor
if (isset($_GET['id'])) {
    $id_proveedor = $_GET['id'];

    // Obtener los detalles del proveedor
    $sql = "SELECT * FROM proveedores WHERE id_proveedor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_proveedor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $proveedor = $result->fetch_assoc();
    } else {
        echo "Proveedor no encontrado.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID del proveedor no proporcionado.";
    exit;
}

// Actualizar el proveedor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

    $sql = "UPDATE proveedores SET 
            nombre_proveedor = ?, 
            telefono = ?, 
            direccion = ?, 
            email = ? 
            WHERE id_proveedor = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre_proveedor, $telefono, $direccion, $email, $id_proveedor);

    if ($stmt->execute() === TRUE) {
        header('Location: Proveedores.php');
        exit;
    } else {
        echo "Error al actualizar el proveedor: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eceff1;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: white;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h1 {
            font-size: 24px;
            color: #37474f;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-size: 14px;
            color: #607d8b;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="tel"], input[type="email"] {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #cfd8dc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            color: #37474f;
        }
        button {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            padding: 12px;
            background-color: #0288d1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0277bd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Editar Proveedor</h1>
    <form action="EditarProveedores.php?id=<?php echo $id_proveedor; ?>" method="post">
        <label for="nombre_proveedor">Nombre del Proveedor:</label>
        <input type="text" name="nombre_proveedor" value="<?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($proveedor['telefono']); ?>" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($proveedor['direccion']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($proveedor['email']); ?>" required>

        <button type="submit">Actualizar Proveedor</button>
    </form>
</div>

</body>
</html>
