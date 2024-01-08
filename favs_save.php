<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include("config.php");

$conn = new mysqli($db_server, $db_user,$db_pass,$db_name,$db_serverport);
mysqli_set_charset($conn,'utf8');

$sql = "TRUNCATE TABLE drawers_fav";
$result = $conn->query($sql);

// Recibir datos JSON desde la solicitud POST
$jsonData = file_get_contents("php://input");

// Decodificar el JSON a un array de PHP
$data = json_decode($jsonData, true);

// Verificar si la decodificación fue exitosa
if ($data !== null) {
  foreach ($data as $producto) {
    // Acceder a los datos de cada producto
    $titulo = $producto['titulo'];
    $link = $producto['link'];
    $precio = $producto['precio'];
    $imagen = $producto['imagen'];
    $sql = "INSERT INTO drawers_fav (fav_title, fav_link, fav_img, fav_price)
    VALUES('$titulo', '$link', '$imagen', $precio)";
    $result = $conn->query($sql);

    // echo "Producto: $titulo, Precio: $precio, Enlace: $link, Imagen: $imagen<br>";
}
} else {
    // Error en la decodificación del JSON
    echo "Error al decodificar el JSON.";
}
$response = array(
  'status' => 'ok',
  'message' => 'Datos recibidos correctamente',
  'data' => $data  // Puedes incluir datos adicionales en la respuesta si es necesario
);

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>

