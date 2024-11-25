<?php
session_start();

// Verificar que el profesor inició sesión
if ($_SESSION['type'] != 'teacher') {
    die("El profesor no ha iniciado sesión.");
}

$teacher_id = $_SESSION['id'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener materias asignadas al profesor
$query = "SELECT subject_id, subject_name FROM subject WHERE teacher_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$subjects = $result->fetch_all(MYSQLI_ASSOC);

// Verificar si se encontraron materias
if (empty($subjects)) {
    die("No se encontraron materias para este profesor.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materializar Materia</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	Elija una materia profe <br>
    <form action="show_code.php" method="POST">
        <select name="subject_id" id="subject" required>
            <?php foreach ($subjects as $subject): ?>
                <option value="<?= $subject['subject_id']; ?>"><?= $subject['subject_name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Registrar Asistencia</button>
    </form>
</body>
</html>
