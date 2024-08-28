<?php
// Conexión a la base de datos
$servername = "tu_servidor";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";   

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);   

}

// Recibir datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Hash de la contraseña (ejemplo con bcrypt)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Consultar la base de datos
$sql = "SELECT * FROM usuarios WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();   

    // Verificar contraseña
    if (password_verify($password, $row['password'])) {
        // Iniciar sesión
        session_start();
        $_SESSION['username'] = $username;
        header("Location: bienvenida.php");
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}

$conn->close();
?>