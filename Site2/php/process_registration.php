<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Хеширование пароля

    // Подключение к базе данных (замените параметры на ваши)
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Проверка существования пользователя с таким email
    $checkEmailSql = "SELECT * FROM users WHERE email='$email'";
    $checkResult = $conn->query($checkEmailSql);

    if ($checkResult->num_rows > 0) {
        // Пользователь с таким email уже существует
        echo '<script>
                alert("Пользователь с таким email уже зарегистрирован.");
                window.location.href = "../html/registration.html";
              </script>';
    } else {
        // Пользователь с таким email не существует, выполняем регистрацию
        // Подготовка SQL-запроса
        $insertSql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

        if ($conn->query($insertSql) === TRUE) {
            // Запись успешно добавлена
            echo '<script>
                    alert("Регистрация прошла успешно!");
                    window.location.href = "../html/login.html";
                  </script>';
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
