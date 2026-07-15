<?php

include("conexion.php");

$correoelectronico = $_POST['correoelectronico'];
$contraseña = $_POST['contrasena'];

$sql = "INSERT INTO usuarios (correoelectronico, contrasena)
VALUES ('$correoelectronico', '$contraseña')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario guardado correctamente";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

?>