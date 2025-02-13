<?php
// Configuración de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emprendedor1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los suscriptores
$sql = "SELECT nombre_c, correo_c, celular_c FROM datos";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar los registros
    $suscriptores = [];
    while($row = $result->fetch_assoc()) {
        $suscriptores[] = $row;
    }
    // Devolver los registros en formato JSON
    echo json_encode($suscriptores);
} else {
    // Si no hay registros
    echo json_encode([]);
}

$conn->close();
?>
