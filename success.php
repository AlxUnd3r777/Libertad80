<?php
include 'connection.php';


// Verificar si se han seleccionado imágenes para eliminar
if(isset($_POST['delete_selected'])){
    if(isset($_POST['selected_images'])){
        foreach($_POST['selected_images'] as $image_id){
            deleteImage($image_id);
        }
    }
    
    // Redirigir al usuario de nuevo a la misma página para evitar procesamiento repetido del formulario
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Función para eliminar una imagen del sistema de archivos y la base de datos
function deleteImage($image_id) {
    global $conn;
    // Obtener la ubicación de la imagen a eliminar
    $sql_select = "SELECT ubicacion FROM imagenes WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $image_id);
    $stmt_select->execute();
    $stmt_select->bind_result($image_location);
    $stmt_select->fetch();
    $stmt_select->close();

    // Eliminar la imagen del sistema de archivos
    if (file_exists($image_location)) {
        if (unlink($image_location)) {
            // Eliminar la entrada de la base de datos
            $sql_delete = "DELETE FROM imagenes WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $image_id);
            if ($stmt_delete->execute()) {
                return true;
            } else {
                return false;
            }
            $stmt_delete->close();
        } else {
            return false;
        }
    } else {
        return false;    }
}

// Verificar si se han seleccionado imágenes para publicar
if(isset($_POST['publish_images'])){
    // Obtener las rutas de las imágenes seleccionadas
    $selected_images = $_POST['selected_images'];
    // Redireccionar a la página de previsualización del carrusel
    header("Location: preview.php?images=" . implode(",", $selected_images));
    exit();
}

// Obtener todas las imágenes de la base de datos
$sql = "SELECT id, nombre, ubicacion FROM imagenes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de imágenes</title>
     <link href="styles.css" rel="stylesheet">
    <!-- Agregar cualquier estilo CSS necesario -->
    <style>
        .image-container {
            float: left;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Mostrar las imágenes con miniaturas y checkboxes -->
    <div class="container">
        <h2>Imágenes Subidas</h2>
       <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="image-container">';
            echo '<img src="' . $row["ubicacion"] . '" alt="' . $row["nombre"] . '" width="100">';
            echo '<br>';
            echo '<input type="checkbox" name="selected_images[]" value="' . $row["id"] . '">';
            echo '</div>';
        }
    } else {
        echo "No hay imágenes subidas.";
    }
    ?>
    <br style="clear:both;">
    <button type="submit" name="publish_images">Publicar en Carrusel</button>
    <button type="submit" name="delete_selected">Eliminar Imágenes Seleccionadas</button>
</form>

    </div>
</body>
</html>
