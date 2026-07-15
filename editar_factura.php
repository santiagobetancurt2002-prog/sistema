<?php
include("conexion.php");

// 1. Capturamos el ID que viene de la tabla
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM guardar_factura WHERE id = $id";
    $resultado = $conn->query($sql);
    $factura = $resultado->fetch_assoc();
}

// 2. Si el usuario presiona "Actualizar"
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
    } else {
        echo "Error actualizando: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Factura</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar Factura #<?php echo $factura['numero_factura']; ?></h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $factura['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Número de Factura</label>
                            <input type="text" name="numero_factura" class="form-control" value="<?php echo $factura['numero_factura']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <input type="text" name="cliente" class="form-control" value="<?php echo $factura['cliente']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Proveedor</label>
                            <input type="text" name="proveedor" class="form-control" value="<?php echo $factura['proveedor']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valor</label>
                            <input type="number" step="0.01" name="valor" class="form-control" value="<?php echo $factura['valor']; ?>" required>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="facturacion.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning">Actualizar Factura</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>