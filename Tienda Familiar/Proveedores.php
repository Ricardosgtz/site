<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_store";

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los proveedores
$sql = "SELECT * FROM proveedores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Fuente moderna */
            background-color: #e9ecef; /* Color de fondo más claro */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh; /* Asegura que el contenido esté centrado verticalmente */
        }
        h1 {
            margin-top: 20px;
            color: #333;
            font-weight: 700; /* Texto en negrita */
        }
        .container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 90%;
            max-width: 1100px;
        }
        .add-button, .menu-button {
            padding: 10px 30px;
            text-align: center;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s; /* Transiciones suaves */
        }
        .add-button {
            background-color: #28a745; /* Color verde */
        }
        .add-button:hover {
            background-color: #218838; /* Verde más oscuro */
            transform: translateY(-2px); /* Efecto de elevación */
        }
        .menu-button {
            background-color: #007bff; /* Color azul */
            margin-top: 10px; /* Espaciado superior */
        }
        .menu-button:hover {
            background-color: #0056b3; /* Azul más oscuro */
            transform: translateY(-2px); /* Efecto de elevación */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Espaciado superior */
        }
        table, th, td {
            border: 1px solid #dee2e6; /* Color de borde */
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #f8f9fa; /* Fondo más claro para encabezados */
            font-weight: 700; /* Texto en negrita */
        }
        .action-buttons {
            display: flex;
            justify-content: space-evenly;
        }
        .edit-btn, .delete-btn {
            padding: 15px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transición suave */
            margin-left: 10px;
        }
        .edit-btn {
            font-family: 'Poppins', sans-serif;
            background-color: #007bff; /* Color azul */
        }
        .edit-btn:hover {
            background-color: #0056b3; /* Azul más oscuro */
        }
        .delete-btn {
            font-family: 'Poppins', sans-serif;
            background-color: #dc3545; /* Color rojo */
        }
        .delete-btn:hover {
            background-color: #c82333; /* Rojo más oscuro */
        }

        @media (max-width: 768px) {
            body {
                padding: 10px; /* Espaciado alrededor del contenido */
            }

            .container {
                width: 100%; /* Container ocupa el 100% del ancho */
                padding: 15px; /* Espaciado interno reducido */
            }

            h1 {
                font-size: 24px; /* Tamaño de fuente más pequeño para el título */
                text-align: center; /* Centrar el título */
            }

            .add-button, .menu-button {
                width: 100%; /* Botones ocupan todo el ancho */
                margin: 10px 0; /* Espaciado entre botones */
            }

            table {
                font-size: 14px; /* Tamaño de fuente más pequeño para la tabla */
            }

            th, td {
                padding: 10px; /* Espaciado interno reducido en celdas */
            }

            .action-buttons {
                flex-direction: column; /* Cambiar a columna para los botones de acción */
                align-items: center; /* Centrar los botones */
                gap: 10px; /* Espaciado entre los botones */
            }

            .edit-btn, .delete-btn {
                width: 100%; /* Botones ocupan todo el ancho */
                padding: 10px; /* Espaciado interno en botones */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Lista de Proveedores</h1>

    <!-- Botón para regresar al menú -->
    <a href="menu.php" class="menu-button">Regresar al Menú</a>

    <!-- Botón para agregar proveedores -->
    <a href="AgregarProveedores.php" class="add-button">Agregar Proveedor</a>

    <!-- Tabla de proveedores -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre del Proveedor</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Email</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Mostrar los proveedores en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_proveedor']}</td>
                        <td>{$row['nombre_proveedor']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['direccion']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['fecha_registro']}</td>
                        <td class='action-buttons'>
                            <a href='EditarProveedores.php?id={$row['id_proveedor']}'><button class='edit-btn'>Editar</button></a>
                            <a href='EliminarProveedores.php?id={$row['id_proveedor']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este proveedor?\")'><button class='delete-btn'>Eliminar</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay proveedores disponibles</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
