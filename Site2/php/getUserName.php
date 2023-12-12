<?php
session_start(); // Не забудьте вызвать session_start() в начале скрипта

function getUserNameFromDatabase() {
    // Замените эти параметры на ваши
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Проверяем, есть ли пользователь в сессии
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        // Пример SQL-запроса для получения имени пользователя  
        $sql = "SELECT name FROM users WHERE id = $userId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $conn->close(); // Закрываем соединение здесь
            return $row["name"];
        }
    }

    $conn->close(); // Закрываем соединение здесь
    // Если не удалось получить имя, вернем "Гость" или другое значение по умолчанию
    return "Гость";
}

// Вызываем функцию и возвращаем результат как текст
echo getUserNameFromDatabase();
?>
