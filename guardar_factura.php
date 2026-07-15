<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Captura de datos
    $numero_factura = $_POST['numero_factura'];
    $cliente = $_POST['cliente'];
    $proveedor = $_POST['proveedor'];
    $valor = $_POST['valor'];
    $fecha = $_POST['fecha'];

    // 2. Consulta corregida (Se agregó 'fecha' a las columnas)
    $sql = "INSERT INTO guardar_factura (numero_factura, cliente, proveedor, valor, fecha) 
            VALUES ('$numero_factura', '$cliente', '$proveedor', '$valor', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('¡Factura guardada con éxito!');
                window.location.href='facturacion.php';
              </script>";
    } else {
        echo "Error al guardar: " . $conn->error;
    }
}

$conn->close();
?>
