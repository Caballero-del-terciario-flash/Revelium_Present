<?php
session_start();

if ($_SESSION['type'] != 'student') {
    die("No profe. Esto es para el alumno.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Código</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="the_big_one.php" method="POST">
        <input type="text" name="attendance_code" placeholder="Viste ese código de 4 dígitos en la compu del pprofe? Poné eso acá." required><br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
