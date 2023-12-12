<?php
// Подключение к базе данных
include('../config/connect.php');

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение ID транзакции из параметра запроса
$transactionId = $_GET['id'];

// Подготовленный запрос на удаление
$sql = "DELETE FROM transactions WHERE id = ?";

// Подготовка запроса
$stmt = $conn->prepare($sql);

// Привязка параметра
$stmt->bind_param("i", $transactionId);

// Выполнение запроса
if ($stmt->execute()) {
    // Успешное удаление
    echo "Транзакция успешно удалена.";
} else {
    // Ошибка удаления
    echo "Ошибка при удалении транзакции: " . $stmt->error;
}

// Закрытие подключения
$stmt->close();
$conn->close();
?>