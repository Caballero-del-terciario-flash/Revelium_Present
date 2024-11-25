<?php
session_start();
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mi_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

// Capturar datos enviados desde Node.js
$data = json_decode(file_get_contents('php://input'), true);
$student_id = $data['student_id'] ?? null;

if ($student_id) {
    $query = "INSERT INTO attendance (student_id, subject_id, state, date) VALUES (?, $_SESSION['subject_id'], Presente, CURDATE())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Presente señor presidente."]);
    } else {
        echo json_encode(["error" => "No se pudo. Jodete: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Volvé a iniciar sesión o jodete (ID nula)"]);
}

$conn->close();
?>
