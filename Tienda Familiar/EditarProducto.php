<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_store";

$conn = mysqli_connect ($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del producto
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Obtener los detalles del producto
    $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID del producto no proporcionado.";
    exit;
}

// Actualizar el producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_producto = $conn->real_escape_string($_POST['nombre_producto']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $cantidad = $conn->real_escape_string($_POST['cantidad']);
    $id_proveedor = $conn->real_escape_string($_POST['proveedor']); // Cambia a ID del proveedor

    // Consulta de actualización
    $sql = "UPDATE productos SET 
            nombre_producto = '$nombre_producto', 
            precio = '$precio', 
            cantidad = '$cantidad', 
            id_proveedor = '$id_proveedor'  -- Cambia a id_proveedor
            WHERE id_producto = $id_producto";

    if ($conn->query($sql) === TRUE) {
        header('Location: Productos.php');
        exit;
    } else {
        echo "Error actualizando el producto: " . $conn->error;
    }
}

// Obtener lista de proveedores
$sql_proveedores = "SELECT id_proveedor, nombre_proveedor FROM proveedores";
$result_proveedores = $conn->query($sql_proveedores);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eceff1;
            margin: 0;
            padding: 0;
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
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #cfd8dc;
            font-family: 'Poppins', sans-serif;
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
    <h1>Editar Producto</h1>
    <form action="editarproducto.php?id=<?php echo $id_producto; ?>" method="post">
        <label for="nombre_producto">Nombre del Producto:</label>
        <input type="text" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" required>

        <label for="proveedor">Proveedor:</label>
        <select name="proveedor" required>
            <option value="">Seleccione un proveedor</option>
            <?php if ($result_proveedores->num_rows > 0): ?>
                <?php while ($proveedor = $result_proveedores->fetch_assoc()): ?>
                    <option value="<?php echo $proveedor['id_proveedor']; ?>" <?php echo $producto['id_proveedor'] == $proveedor['id_proveedor'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <button type="submit">Actualizar Producto</button>
    </form>
</div>

</body>
</html>
