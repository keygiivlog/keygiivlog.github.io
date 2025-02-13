<?php
// Configuración de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emprendedor1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $celular = $_POST['telefono'];

    // Verificar si el correo ya existe
    $checkQuery = "SELECT * FROM datos WHERE correo_c = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el correo ya está registrado
        echo "<script>
            alert('Este correo ya está registrado. Por favor, utiliza otro correo.');
            window.location.href = 'http://localhost/emprendedor/keygiivlog.github.io/index.html';
        </script>";
    } else {
        // Si el correo es nuevo, insertar datos y mostrar mensaje de éxito con confeti
        $sql = "INSERT INTO datos (nombre_c, correo_c, celular_c) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $correo, $celular);

        if ($stmt->execute()) {
            echo "<script>
                alert('¡Felicidades! Ya tienes un 10% de descuento en tu primera compra.');
                window.location.href = 'http://localhost/emprendedor/keygiivlog.github.io/index.html'; // Redirecciona a localhost (index.html)
                // Añadir animación de confetti aquí
                document.body.innerHTML += '<div id=\"confetti\"></div>'; // Crea el contenedor de confetti
                let confetti = document.getElementById('confetti');
                for (let i = 0; i < 100; i++) {
                    let piece = document.createElement('div');
                    piece.style.position = 'absolute';
                    piece.style.width = '10px';
                    piece.style.height = '10px';
                    piece.style.backgroundColor = ['#ffcc00', '#ff6666', '#66ccff', '#99ff99'][Math.floor(Math.random() * 4)];
                    piece.style.borderRadius = '50%';
                    piece.style.opacity = '0.9';
                    piece.style.left = Math.random() * 100 + 'vw';
                    piece.style.animation = 'confettiAnimation 5s infinite';
                    confetti.appendChild(piece);
                }
                // Crear el mensaje de Felicidades
                let message = document.createElement('div');
                message.id = 'felicitaciones';
                message.innerHTML = '¡Felicidades!<br>Ya tienes un 10% de descuento en tu primera compra.';
                document.body.appendChild(message);
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<style>
    @keyframes confettiAnimation {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(100vh) rotate(180deg); }
        100% { transform: translateY(0) rotate(360deg); }
    }

    #felicitaciones {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        font-size: 3em;
        font-weight: bold;
        color: #fff;
        background: linear-gradient(45deg, #ff6f61, #ffcc00);
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        z-index: 9999;
        animation: bounceIn 2s ease-out, scaleIn 1s ease-out;
    }

    /* Animación para el mensaje de Felicidades */
    @keyframes bounceIn {
        0% { transform: translateY(-100px); opacity: 0; }
        60% { transform: translateY(20px); opacity: 1; }
        100% { transform: translateY(0); }
    }

    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
