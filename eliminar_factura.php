<?php
// Incluimos la conexión para poder entrar a la base de datos
include("conexion.php");

// Verificamos que el ID que viene por la URL sea válido
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Ejecutamos la orden de borrar
    $sql = "DELETE FROM guardar_factura WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Si todo sale bien, nos regresa a la tabla principal
        header("Location: facturacion.php");
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    echo "No se recibió un ID válido.";
}

$conn->close();
?>