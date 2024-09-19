<?php
include 'connection.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$filename = $_GET["filename"];
$image_path = "uploads/" . $filename;

$sql = "INSERT INTO imagenes (nombre, ubicacion) VALUES ('$filename', '$image_path')";

if ($conn->query($sql) === TRUE) {
    echo "Imagen subida y guardada en la base de datos correctamente";
} else {
    echo "Error al guardar la imagen en la base de datos: " . $conn->error;
}

$conn->close();
?>
