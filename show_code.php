<?php
$chosen_one = $_POST['subject_id'];
$_SESSION['chosen_one'] = $chosen_one;
session_start();
$codigo = rand(1000, 9999); // Genera un código aleatorio
$_SESSION['code'] = $codigo; // Guarda el código en la sesión
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Asistencia</title>
	<link rel="stylesheet" href="styles.css">
    <script>
        setInterval(() => {
            location.reload(); // Actualiza la página cada 5 segundos
        }, 5000);
    </script>
</head>
<body>
    <p align="center"><big-smoke><?= $codigo ?></big-smoke><br> <?$chosen_one?> <br>
	Che pibe. Escribite este codigo mara marcar tu presencia y anular a la mufa.</p>
</body>
</html>
