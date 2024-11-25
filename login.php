<html lang="es">
<head>
    <title>Entrada Épica</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Dropdown</button>
		<div class="dropdown-content">
			<a href="index.html">Inicio</a><br>
			<a href="#">Perfil</a><br>
			<a href="#">Link 3</a>
		</div>
	</div>
	</div>

<?php
$words= ['crack','maestro','guerrero','mastodonte','bestia','caballero de la noche','fiera','masterclass','relámpago','locura','Big Boss'];
$word= array_rand($words);
$randomword= $words[$word];

session_start(); // Inicia la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Captura los datos del formulario
$mail = $_POST['mail'];
$password_ingresada = $_POST['password'];
$type = $_POST['type'];

// Consulta para verificar el usuario
$stmt = $conn->prepare("SELECT ".$type."_id, name, surname, DNI, password FROM ".$type."s WHERE mail = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica la contraseña
    if (password_verify($password_ingresada, $row['password'])) {
        // Guarda la ID y el tipo de cuenta en la sesión
        $_SESSION['id'] = $row[$type.'_id'];
        $_SESSION['type'] = $type;
		$_SESSION['name'] = $row['name'];
		$_SESSION['surname'] = $row['surname'];
		$_SESSION['DNI'] = $row['DNI'];

        echo "Sesión iniciada como ".$_SESSION['name'].' '.$_SESSION['surname'].".<br>Que onda $randomword? Todo piola?<br><br>".htmlspecialchars($mail);
        //header("Location: inicio.php");
        exit();
    } else {
        echo "Le pifiaste a la contraseña.";
    }
} else {
    echo "¿Y vo quien so?";
}

$stmt->close();
$conn->close();
?>
</body>
</html>
<?php /*
$words= ['crack','maestro','guerrero','mastodonte','bestia','caballero de la noche','fiera','masterclass','relámpago','locura','big boss'];
$word= array_rand($words);
$randomword= $words[$word];

session_start(); // Iniciar o reanudar la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Capturar datos del formulario
$type = $_POST['type'];
$mail = $_POST['mail'];
$password_ingresada = $_POST['password'];

// Preparar consulta para buscar el usuario por mail
$stmt = $conn->prepare("SELECT password FROM $type WHERE mail = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Obtener la contraseña almacenada
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verificar la contraseña ingresada
    if (password_verify($password_ingresada, $hashed_password)) {
        // Guardar información del usuario en la sesión
        $_SESSION['usuario'] = $mail;
        $_SESSION['loggedin'] = true;

        echo "Sesión iniciada. Que onda $randomword?<br>" . htmlspecialchars($mail);
        // Redirigir a la página principal
        header("Location: index.html");
        exit();
    } else {
        echo "Le pifiaste a la contraseña.";
    }
} else {
    echo "¿Y vo quien so?";
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
*/