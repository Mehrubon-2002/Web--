<?php
session_start();

// Подключение к базе данных
include('../config/connect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных пользователя из сессии
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Проверка, что у пользователя есть идентификатор
if ($userId) {
    // Получаем данные из POST-запроса
    $date = $_POST['date'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $transactionId = $_POST['transactionId'];

    // Подготовленный запрос для обновления данных транзакции
    $stmt = $conn->prepare("UPDATE transactions SET date=?, type=?, amount=?, description=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssssii", $date, $type, $amount, $description, $transactionId, $userId);

    // Выполнение запроса
    $stmt->execute();

    // Проверка успешного выполнения запроса
    if ($stmt->affected_rows > 0) {
        echo "Данные успешно обновлены";
    } else {
        echo "Ошибка при обновлении данных";
    }

    // Закрытие запроса
    $stmt->close();
} else {
    echo "Ошибка: Пользователь не авторизован";
}

// Закрытие соединения с базой данных
$conn->close();
?>
