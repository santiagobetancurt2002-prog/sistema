<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Captura de datos (asegúrate de que los 'name' coincidan con tu modal)
    $numero_factura = $_POST['numero_factura'];
    $cliente = $_POST['cliente'];
    $proveedor = $_POST['proveedor'];
    $valor = $_POST['valor'];
     $fecha = $_POST['fecha'];

    // 2. CORRECCIÓN DEL NOMBRE DE LA TABLA: guardar_factura
    // También asegúrate de que los nombres de las columnas (id, numero_factura, etc) sean iguales en phpMyAdmin
    $sql = "INSERT INTO guardar_factura (numero_factura, cliente, proveedor, valor) 
            VALUES ('$numero_factura', '$cliente', '$proveedor', '$valor', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('¡Factura guardada con éxito!');
                window.location.href='facturacion.php';
              </script>";
    } else {
        // Esto te dirá si el error ahora es por un nombre de columna mal escrito
        echo "Error al guardar: " . $conn->error;
    }
}

$conn->close();
?>

