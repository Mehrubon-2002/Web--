<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $incomeDate = $_POST["incomeDate"];
    $incomeAmount = $_POST["incomeAmount"];
    $incomeDescription = $_POST["incomeDescription"];

    // Подключение к базе данных (замените параметры на ваши)
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получение id пользователя из сессии
    $userId = $_SESSION["user_id"];

    // Подготовленный запрос для вставки данных о доходах в таблицу transactions
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, date, type, amount, description) VALUES (?, ?, 'Доход', ?, ?)");
    $stmt->bind_param("isss", $userId, $incomeDate, $incomeAmount, $incomeDescription);

    if ($stmt->execute()) {
        echo "Доход успешно добавлен!";
        echo '<script>
        setTimeout(function() {
            window.location.href = "../html/inputData.html";
        }, 800);
      </script>';
    } else {
        echo "Ошибка при добавлении дохода: " . $stmt->error;
        echo '<script>
        setTimeout(function() {
            window.location.href = "../html/inputData.html";
        }, 800);
      </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
