<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $expenseDate = $_POST["expenseDate"];
    $expenseAmount = $_POST["expenseAmount"];
    $expenseDescription = $_POST["expenseDescription"];

    // Подключение к базе данных (замените параметры на ваши)
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получение id пользователя из сессии
    $userId = $_SESSION["user_id"];

    // Подготовленный запрос для вставки данных о расходах в таблицу transactions
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, date, type, amount, description) VALUES (?, ?, 'Расход', ?, ?)");
    $stmt->bind_param("isss", $userId, $expenseDate, $expenseAmount, $expenseDescription);

    if ($stmt->execute()) {
        echo "Расход успешно добавлен!";
        echo '<script>
        setTimeout(function() {
            window.location.href = "../html/inputData.html";
        }, 800);
      </script>';
    } else {
        echo "Ошибка при добавлении расхода: " . $stmt->error;
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
