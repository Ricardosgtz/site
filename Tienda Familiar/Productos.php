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

// Inicializar variables para el filtro de búsqueda
$searchTerm = "";
$sql = "SELECT p.*, pr.nombre_proveedor 
        FROM productos p 
        LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor"; // Consulta por defecto para mostrar productos y proveedores

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $searchTerm = $_GET['buscar'];
    $sql = "SELECT p.*, pr.nombre_proveedor 
            FROM productos p 
            LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor 
            WHERE p.id_producto LIKE '%$searchTerm%' OR p.nombre_producto LIKE '%$searchTerm%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h1 {
            margin-top: 20px;
            color: #333;
            text-align: center;
        }

        .container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 90%;
            max-width: 1200px;
            overflow: hidden;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input[type="text"] {
            font-family: 'Poppins', sans-serif;
            padding: 10px;
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .search-bar input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .search-bar button {
            font-family: 'Poppins', sans-serif;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        .add-button,
        .menu-button {
            padding: 10px 30px;
            background-color: #28a745;
            /* Verde para el botón de agregar */
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-left: auto;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .menu-button {
            background-color: #007bff;
            /* Azul para el botón de menú */
        }

        .menu-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }

        .edit-btn,
        .delete-btn {
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .edit-btn {
            font-family: 'Poppins', sans-serif;
            background-color: #007bff;
        }

        .edit-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .delete-btn {
            font-family: 'Poppins', sans-serif;
            background-color: #dc3545;
            margin-left: 10px;
        }

        .delete-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            th,
            td {
                font-size: 14px;
            }

            .finalize-btn {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
    <!-- Fuentes de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1>Lista de Productos</h1>

        <!-- Botón para ir al menú -->
        <a href="menu.php" class="menu-button" style="float: right;">Menú</a>

        <!-- Barra de búsqueda -->
        <div class="search-bar">
            <form action="Productos.php" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="buscar" placeholder="Buscar por ID o Nombre del Producto..." value="<?php echo $searchTerm; ?>">
                <button type="submit">Buscar</button>
            </form>
            <a href="AgregarProducto.php" class="add-button">Agregar</a>
        </div>

        <!-- Tabla de productos -->
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre del Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Proveedor</th>
                <th>Fecha Agregado</th>
                <th>Acciones</th>
            </tr>
            <?php
            // Mostrar los productos en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id_producto']}</td>
                        <td>{$row['nombre_producto']}</td>
                        <td>{$row['precio']}</td>
                        <td>{$row['cantidad']}</td>
                        <td>{$row['nombre_proveedor']}</td>
                        <td>{$row['fecha_agregado']}</td>
                        <td class='action-buttons'>
                            <a href='EditarProducto.php?id={$row['id_producto']}'><button class='edit-btn'>Editar</button></a>
                            <a href='EliminarProducto.php?id={$row['id_producto']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\")'><button class='delete-btn'>Eliminar</button></a>
                        </td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay productos disponibles</td></tr>";
            }
            ?>
        </table>
    </div>

</body>

</html>

<?php
$conn->close();
?>
