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
    // SQL-запрос для получения транзакций пользователя
    $sql = "SELECT * FROM transactions WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Выводим данные о транзакциях в таблицу
        while ($row = $result->fetch_assoc()) {
            echo "<tr data-transaction-id='" . $row["id"] . "'>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["amount"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td><button class='edit-button'>Изменить</button></td>";
            echo "<td><button class='delete-button'>Удалить</button></td>";
            echo "</tr>";
        }
    } //else {
    //     echo "<tr><td colspan='4'>Нет данных</td></tr>";
    // }
} 

// Закрытие соединения с базой данных
$conn->close();
?>
