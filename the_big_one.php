<?php
session_start();

// Verificar que el alumno haya iniciado sesión
if (!isset($_SESSION['student_id'])) {
    die("No se ha iniciado sesión.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendance_code = $_POST['attendance_code'];

    // Validar el código con Node.js
    $node_server = 'http://localhost:3000/attendance-code';
    $response = file_get_contents($node_server);
    $data = json_decode($response, true);

    if ($data['code'] == $attendance_code) {
        // Código válido, registrar asistencia
        $student_id = $_SESSION['student_id'];
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $conn = new mysqli('localhost', 'root', '', 'revelium_present');
        if ($conn->connect_error) {
            die("Conecteitor dice que no juega más: " . $conn->connect_error);
        }

        $sql = "INSERT INTO attendance (student_id, date, time) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $student_id, $date, $time);

        if ($stmt->execute()) {
            echo "Asistencia registrada.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Código incorrecto.";
    }
}
?>
