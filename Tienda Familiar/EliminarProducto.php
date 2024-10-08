<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_store"; // Actualizado con el nombre correcto de la base de datos

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha proporcionado un ID de producto
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Proteger contra inyecciones SQL utilizando consultas preparadas
    $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir después de la eliminación exitosa
        header('Location: Productos.php');
        exit;
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    $stmt->close(); // Cerrar la declaración preparada
} else {
    echo "ID del producto no proporcionado.";
}

$conn->close();
?>
