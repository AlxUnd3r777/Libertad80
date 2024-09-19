<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsualización del Carrusel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Previsualización del Carrusel</h2>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                include 'connection.php';

                $sql = "SELECT * FROM imagenes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $index = 0;
                    while($row = $result->fetch_assoc()) {
                        echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $index . '" class="' . ($index == 0 ? 'active' : '') . '"></li>';
                        $index++;
                    }
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $index = 0;
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="carousel-item ' . ($index == 0 ? 'active' : '') . '">';
                        echo '<img class="d-block w-100" src="' . $row["ubicacion"] . '" alt="' . $row["nombre"] . '">';
                        echo '</div>';
                        $index++;
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
