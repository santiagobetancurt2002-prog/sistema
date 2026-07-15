<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
    /* 1. Forzamos a que la tabla ocupe el 100% del contenedor blanco */
    .table {
        table-layout: fixed; /* CLAVE: Esto congela el ancho de las columnas */
        width: 100% !important;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    /* 2. Definimos anchos exactos para cada columna (Suma 100%) */
    .table th, .table td {
        width: 20%; 
        text-align: center;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis; /* Si el nombre es muy largo, pone "..." en vez de ensanchar la tabla */
        white-space: nowrap;
    }

    /* 3. Estilo para la fila seleccionada */
    .fila-seleccionada {
        background-color: #cfe2ff !important; /* Azul clarito */
        color: #084298;
        font-weight: bold;
    }
    
    .fila-factura:hover {
        background-color: #f8f9fa;
    }
</style>
</head>


<body class="bg-light">

    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="menu-container shadow-sm bg-white p-4 text-center w-100">
                <h4 class="mb-3 text-primary">Gestión de Facturas</h4>
                <p class="small text-muted">Bienvenido, <strong><?php echo $_SESSION['nombre_usuario']; ?></strong></p>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalFactura">
        + Agregar
    </button>
    
    <a href="#" id="btnEditar" class="btn btn-warning text-white rounded-pill px-4 disabled">Editar</a>
    <a href="#" id="btnEliminar" class="btn btn-danger rounded-pill px-4 disabled">Eliminar</a>
    
    <a href="logout.php" class="btn btn-outline-secondary rounded-pill px-4">Salir</a>

   <script>
function seleccionarFactura(fila, idRecibido) {
    // 1. Confirmación visual inmediata
    console.log("ID capturado por JS: ", idRecibido);
    
    // Si sigue siendo 0 o vacío, avisamos con un mensaje
    if (!idRecibido || idRecibido == "0") {
        alert("¡Cuidado! El sistema detectó ID 0. Revisa que tu tabla en phpMyAdmin tenga una columna llamada 'id' con Auto_Increment.");
        return;
    }

    // 2. Pintar la fila
    document.querySelectorAll('.fila-factura').forEach(f => f.classList.remove('table-primary'));
    fila.classList.add('table-primary');

    // 3. Activar botones de arriba
    const btnE = document.getElementById('btnEditar');
    const btnD = document.getElementById('btnEliminar');

    if (btnE && btnD) {
        btnE.href = "editar_factura.php?id=" + idRecibido;
        btnD.href = "eliminar_factura.php?id=" + idRecibido;

        btnE.classList.remove('disabled');
        btnD.classList.remove('disabled');
    }
}
</script>
</div>
            </div>
        </div>

        <div class="tabla-container shadow-sm">
            <h5 class="mb-3">Listado de Facturas Registradas</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th># Factura</th>
                            <th>Cliente</th>
                            <th>Proveedor</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                
                        <tr>
                            <td colspan="5" class="text-center text-muted">Las facturas aparecerán aquí...</td>
                        </tr>
                 <tbody>
    <?php
    $sql = "SELECT * FROM guardar_factura ORDER BY id DESC"; // Ahora sí podemos ordenar por ID
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            // Guardamos el nuevo ID en una variable
            $id = $fila['id']; 

            echo "<tr class='fila-factura' onclick='seleccionarFactura(this, $id)' style='cursor:pointer;'>";
            echo "<td>" . $fila['numero_factura'] . "</td>";
            echo "<td>" . $fila['cliente'] . "</td>";
            echo "<td>" . $fila['proveedor'] . "</td>";
            echo "<td>$" . number_format($fila['valor'], 2) . "</td>";
            echo "<td>" . $fila['fecha'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFactura" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Nueva Factura</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form action="guardar_factura.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Número de Factura</label>
                    <input type="text" name="numero_factura" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del Cliente</label>
                    <input type="text" name="cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del Proveedor</label>
                    <input type="text" name="proveedor" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Valor Total</label>
                    <input type="number" name="valor" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Registrar Factura</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>