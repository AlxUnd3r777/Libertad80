<?php
include 'connection.php';

if(isset($_FILES['image'])){
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    
    // Verificar si el archivo es una imagen
    $allowed_extensions = array("image/jpeg", "image/png", "image/gif");
    if(in_array($file_type, $allowed_extensions)){
        // Mover la imagen a la carpeta de uploads
        $file_path = "uploads/" . $file_name; // Aquí se corrige la construcción de la ruta
        move_uploaded_file($file_tmp, $file_path);
        
        // Preparar la consulta
        $sql = "INSERT INTO imagenes (nombre, ubicacion) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ss", $file_name, $file_path);
        if ($stmt->execute()) {
            // Redireccionar a success.php con un parámetro de consulta para evitar repetición al recargar la página
            header("Location: success.php?uploaded=true");
            exit(); // Terminar el script para evitar cualquier salida adicional
        } else {
            echo "Error al guardar la imagen en la base de datos: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error: El archivo no es una imagen válida.";
    }
} else {
    echo "Error: No se ha subido ninguna imagen.";
}
?>
