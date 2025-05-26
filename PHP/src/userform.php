<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Список пользователей</h1>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary mb-3">Назад к выбору автомобилей</a>
            <a href="userform.php?action=get_forms" class="btn btn-secondary mb-3">Показать CSV-данные</a>
        </div>

        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'get_forms') {
            $filePath = 'user.csv';

            if (file_exists($filePath)) {
                $file = fopen($filePath, 'r');

                if ($file) {
                    echo '<table class="table table-bordered table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Имя</th>';
                    echo '<th>Фамилия</th>';
                    echo '<th>Дата рождения</th>';
                    echo '<th>Email</th>';
                    echo '<th>Пароль</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    $isHeader = true;
                    while (($row = fgetcsv($file, null, ',', '"', '\\')) !== false) {
                        if ($isHeader) {
                            $isHeader = false;
                            continue;
                        }

                        $safeRow = array_map('htmlspecialchars', $row);
                        echo '<tr>';
                        foreach ($safeRow as $cell) {
                            echo '<td>' . $cell . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';

                    fclose($file);
                } else {
                    echo '<div class="alert alert-danger">Не удалось открыть файл.</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Файл с данными не найден.</div>';
            }
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>