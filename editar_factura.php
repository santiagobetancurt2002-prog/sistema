<?php
include("conexion.php");

$id = null;

// 1. Buscamos el ID ya sea que venga por GET (URL) o por POST (Formulario)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
}

// Si no hay ningún ID, regresamos a la tabla para evitar que la página se rompa
if (!$id) {
    header("Location: facturacion.php");
    exit();
}

// 2. Traemos la información actual de la factura de la base de datos
$sql = "SELECT * FROM guardar_factura WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $factura = $resultado->fetch_assoc();
} else {
    // Si el ID no existe en la base de datos, regresamos
    header("Location: facturacion.php");
    exit();
}

// 3. Si el usuario presiona "Actualizar"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_update = $_POST['id'];
    $n_factura = $_POST['numero_factura'];
    $cliente = $_POST['cliente'];
    $proveedor = $_POST['proveedor'];
    $valor = $_POST['valor'];

    $sql_update = "UPDATE guardar_factura SET 
                   numero_factura='$n_factura', 
                   cliente='$cliente', 
                   proveedor='$proveedor', 
                   valor='$valor' 
                   WHERE id=$id_update";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: facturacion.php?mensaje=actualizado");
        exit(); // Detiene la ejecución del script después de redireccionar
    } else {
        echo "Error actualizando: " . $conn->error;
    }
}
?>