<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "znxrbfwq_admin";
$password = "IGFICVDPKQWL";
$dbname = "znxrbfwq_demodental";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos de los usuarios a crear
$users = [
    ['username' => 'admin', 'password' => 'admin'],
    ['username' => 'admin2', 'password' => 'admin2'],
    ['username' => 'superadmin', 'password' => 'superadmin']
];

foreach ($users as $user) {
    $username = $user['username'];
    $password = $user['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Insertar el nuevo usuario
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Usuario $username creado exitosamente.<br>";
        } else {
            echo "Error al crear el usuario $username: " . $stmt->error . "<br>";
        }
    } else {
        echo "El usuario $username ya existe.<br>";
    }

    $stmt->close();
}

$conn->close();
?>
