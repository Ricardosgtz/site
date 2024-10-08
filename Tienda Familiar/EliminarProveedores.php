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

// Eliminar proveedor
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_proveedor = $_GET['id'];

    $sql = "DELETE FROM proveedores WHERE id_proveedor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_proveedor);

    if ($stmt->execute() === TRUE) {
        header('Location: Proveedores.php?mensaje=Proveedor eliminado correctamente.');
        exit;
    } else {
        echo "Error al eliminar el proveedor: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID del proveedor no proporcionado o no válido.";
}

$conn->close();
?>
