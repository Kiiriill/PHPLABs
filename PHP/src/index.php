<?php
require 'db.php';

// Проверяем, была ли форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if(!empty($name) && !empty($surname) && !empty($birthdate) && !empty($email) && !empty($password)){
        $filePath = './user.csv';

        $file = fopen($filePath, 'a');
        if ($file === false) {
            die("Не удалось открыть файл для записи.");
        }

        // Добавляем параметр escape
        fputcsv($file, [$name, $surname, $birthdate, $email, $password], ',', '"', '\\');

        fclose($file);

        // Вставляем данные в базу данных
        $stmt = $pdo->prepare("INSERT INTO registrations (name, surname, birthdate, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $surname, $birthdate, $email, $password]);

        header('Location: index.php?status=success');
        exit; // Важно завершить выполнение после редиректа
    } else {
        header('Location: index.php?status=error');
        exit; 
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Заполните форму регистрации</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" minlength="2" maxlength="16" required>
            </div>
            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Введите вашу фамилию" minlength="2" maxlength="24" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Дата рождения</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" min="1900-01-01" max="<?php echo date('Y-m-d');?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Введите ваш email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" minlength="8" maxlength="64" required>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <div class="text-center">
            <a href="userform.php" class="btn btn-secondary mb-3">К CSV файлу</a>
    </div>

    <div class="container mt-5">
        <h2>Список зарегистрированных пользователей</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Дата рождения</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT name, surname, birthdate, email FROM registrations");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['birthdate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
