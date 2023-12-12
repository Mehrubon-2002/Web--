<?php
session_start();
function getTotalAmounts() {
    // Замените эти параметры на ваши
    include('../config/connect.php');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION["user_id"];

    // Пример SQL-запроса для получения общей суммы доходов
    $sqlIncome = "SELECT SUM(amount) AS totalIncome FROM transactions WHERE type = 'Доход' and user_id = $userId";
    $resultIncome = $conn->query($sqlIncome);
    $rowIncome = $resultIncome->fetch_assoc();
    $totalIncome = $rowIncome['totalIncome'];

    // Пример SQL-запроса для получения общей суммы расходов
    $sqlExpense = "SELECT SUM(amount) AS totalExpense FROM transactions WHERE type = 'Расход' and user_id = $userId";
    $resultExpense = $conn->query($sqlExpense);
    $rowExpense = $resultExpense->fetch_assoc();
    $totalExpense = $rowExpense['totalExpense'];

    $conn->close(); // Закрываем соединение

    // Обратите внимание, что мы проверяем наличие значений и, если они отсутствуют, устанавливаем их в 0
    return [
        'totalIncome' => $totalIncome ? $totalIncome : 0,
        'totalExpense' => $totalExpense ? $totalExpense : 0
    ];
}

// Вызываем функцию и возвращаем результат в формате JSON
echo json_encode(getTotalAmounts());
?>
