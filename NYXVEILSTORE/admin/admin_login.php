<?php
session_start();
include '../components/connect.php'; // Asegúrate de que este archivo tenga la conexión correcta.

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']); // Se mantiene SHA1

    // Verificar si el usuario existe
    $query = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $query->execute([$username]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if($row && $row['password'] === $password){
        $_SESSION['admin_id'] = $row['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "¡Usuario o contraseña incorrectos!";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DANGER</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="login-container">
    <h2>NYXVEIL</h2>

    <?php if(isset($message)): ?>
        <p class="error-message"><?= $message; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit" name="submit">Iniciar sesión</button>
    </form>
</div>

</body>
</html>
