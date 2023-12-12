<?php

session_start(); // Не забудьте вызвать session_start()

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"]; // Введите здесь хешированный пароль
    // Подключение к базе данных (замените параметры на ваши)
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получение хеша из базы данных по email
    $sql = "SELECT id, name, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Проверка соответствия хешированного пароля
        if (password_verify($password, $hashedPassword)) {
            // Сохранение имени пользователя в сессии
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];

            echo "Вход выполнен успешно!";

            // Скрипт JavaScript для перенаправления через 8 секунды
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "../html/LC.html";
                    }, 800);
                  </script>';
        } else {
            echo '<script>
                    alert("Неверный пароль!");
                    window.location.href = "../html/login.html";
                  </script>';
        }
    } else {
     //   echo "Пользователь с таким email не найден.";
        echo '<script>
        alert("Пользователь с таким email не найден.");
        window.location.href = "../html/login.html";
      </script>';
    }

    $conn->close();
}
?>
