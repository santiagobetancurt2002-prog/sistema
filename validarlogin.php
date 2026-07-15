<?php
include("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Limpiamos los datos para evitar espacios accidentales
    $correo = trim($_POST['correoelectronico']);
    $password = trim($_POST['contrasena']);

    // 2. Validación de seguridad básica: Que no estén vacíos
    if (empty($correo) || empty($password)) {
        echo "<script>alert('Por favor, completa todos los campos'); window.location.href='login.html';</script>";
        exit();
    }

    // 3. Consulta SQL EXACTA
    // Usamos AND para que AMBOS deben coincidir en la misma fila
    $sql = "SELECT * FROM registrarusuario WHERE correoelectronico = '$correo' AND contrasena = '$password'";
    
    $resultado = $conn->query($sql);

    // 4. LA CLAVE: ¿Cuántas filas encontró?
    if ($resultado && $resultado->num_rows === 1) {
        // Si encontró exactamente UNA coincidencia
        $usuario = $resultado->fetch_assoc();
        
        // Guardamos el nombre en la sesión
        $_SESSION['nombre_usuario'] = $usuario['nombre'];
        
        // Redirigimos a la página privada
        header("Location: sistema.html");
        exit(); 
    } else {
        // Si encontró 0 filas o hubo un error
        echo "<script>
                alert('Acceso denegado: El correo o la contraseña no coinciden.');
                window.location.href='login.html';
              </script>";
        exit();
    }
}
$conn->close();
?>