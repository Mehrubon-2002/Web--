<?php
session_start();

// Подключение к базе данных
include('../config/connect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных пользователя из сессии
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Получение идентификатора транзакции из параметров запроса
$transactionId = isset($_GET['id']) ? $_GET['id'] : null;

// Проверка, что у пользователя есть идентификатор и идентификатор транзакции задан
if ($userId && $transactionId) {
    // SQL-запрос для получения данных транзакции
    $sql = "SELECT * FROM transactions WHERE id = $transactionId AND user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Получаем данные о транзакции
        $row = $result->fetch_assoc();
        $transactionData = [
            'date' => $row["date"],
            'type' => $row["type"],
            'amount' => $row["amount"],
            'description' => $row["description"]
        ];

        // Отправляем данные в формате JSON
        echo json_encode($transactionData);
    } else {
        // Если транзакция не найдена, отправляем пустой ответ
        echo "{}";
    }
} else {
    // Если данные пользователя отсутствуют, отправляем пустой ответ
    echo "{}";
}

// Закрытие соединения с базой данных
$conn->close();
?>
