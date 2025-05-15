<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class ="contaner mt-5">
        <h1 class="text-center"> Список пользователей </h1>
        <div class="text-cener" >
            <a href="userform.php?action=get_forms" class="btn btn-secondary mb-3">К запонению формы</a>

        </div>

        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'get_forms')
        {
            $filePath = 'user.csv';

            if (file_exists($filePath)) {
                $file = fopen($filePath, 'r');

                if($file){
                    echo '<table class="table table-bordered table-striped">';
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
</body>
</html>