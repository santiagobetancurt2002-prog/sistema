<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$numerodecelular = $_POST['numerodecelular'];
$numerodeidentificacion = $_POST['numerodeidentificacion'];
$correoelectronico = $_POST['correoelectronico'];
$contrasena = $_POST['contrasena'];

$sql = "INSERT INTO registrarusuario (nombre, apellido, numerodecelular, numerodeidentificacion, correoelectronico, contrasena)
VALUES ('$nombre','$apellido','$numerodecelular','$numerodeidentificacion','$correoelectronico','$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario guardado correctamente";
} else {
    echo "Error: " . $conn->error;
}
 
$conn->close();

}

?>