<?php
try {
    $pdo = new PDO('mysql:host=db;dbname=mydatabase', 'user', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Вывод результата запроса
    $stmt = $pdo->query('SELECT 1');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Соединение прошло успешно! Результат: " . $result[1];
    
} catch (PDOException $e) {
    echo "Соединение прервалось: " . $e->getMessage();
}

phpinfo();
?>

