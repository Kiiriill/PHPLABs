<?php
require 'db.php';

// Обработка отправки формы заказа
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_order'])) {
    $car_model = isset($_POST['car_model']) ? $_POST['car_model'] : '';
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $configuration = isset($_POST['configuration']) ? $_POST['configuration'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (!empty($car_model) && !empty($color) && !empty($configuration) && !empty($price) && !empty($email)) {
        $stmt = $pdo->prepare("INSERT INTO orders (car_model, color, configuration, price, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$car_model, $color, $configuration, $price, $email]);
        header('Location: index.php?status=success');
        exit;
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
    <title>Выбор автомобиля</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .car-card { margin-bottom: 20px; }
        .email-form { display: none; margin-top: 10px; }
        .register-btn { position: absolute; top: 10px; right: 10px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="register.php" class="btn btn-primary register-btn">Зарегистрировать пользователя</a>
        <h2>Выберите автомобиль</h2>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success">Заявка успешно отправлена!</div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="alert alert-danger">Ошибка при отправке заявки. Заполните все поля.</div>
        <?php endif; ?>

        <div class="row">
            <!-- Карточка для машины 1 -->
            <div class="col-md-4 car-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Toyota Camry</h5>
                        <p class="card-text">Цвет:</p>
                        <select class="form-control color-select" data-car="camry">
                            <option value="white">Белый</option>
                            <option value="black">Черный</option>
                            <option value="red">Красный</option>
                        </select>
                        <p class="card-text mt-2">Комплектация:</p>
                        <select class="form-control config-select" data-car="camry" data-prices='{"base": 2000000, "comfort": 2500000, "premium": 3000000}'>
                            <option value="base">Базовая (2,000,000 ₽)</option>
                            <option value="comfort">Комфорт (2,500,000 ₽)</option>
                            <option value="premium">Премиум (3,000,000 ₽)</option>
                        </select>
                        <p class="card-text mt-2">Цена: <span class="price" data-car="camry">2,000,000 ₽</span></p>
                        <button class="btn btn-primary submit-order" data-car="camry">Отправить заявку</button>
                        <form class="email-form" data-car="camry" method="POST" action="">
                            <input type="hidden" name="car_model" value="Toyota Camry">
                            <input type="hidden" name="color" class="hidden-color" value="white">
                            <input type="hidden" name="configuration" class="hidden-config" value="base">
                            <input type="hidden" name="price" class="hidden-price" value="2000000">
                            <div class="form-group">
                                <label for="email-camry">Email</label>
                                <input type="email" class="form-control" id="email-camry" name="email" required>
                            </div>
                            <button type="submit" name="submit_order" class="btn btn-success">Подтвердить</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Карточка для машины 2 -->
            <div class="col-md-4 car-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Honda Accord</h5>
                        <p class="card-text">Цвет:</p>
                        <select class="form-control color-select" data-car="accord">
                            <option value="silver">Серебристый</option>
                            <option value="blue">Синий</option>
                            <option value="black">Черный</option>
                        </select>
                        <p class="card-text mt-2">Комплектация:</p>
                        <select class="form-control config-select" data-car="accord" data-prices='{"base": 1800000, "sport": 2300000, "luxury": 2800000}'>
                            <option value="base">Базовая (1,800,000 ₽)</option>
                            <option value="sport">Спорт (2,300,000 ₽)</option>
                            <option value="luxury">Люкс (2,800,000 ₽)</option>
                        </select>
                        <p class="card-text mt-2">Цена: <span class="price" data-car="accord">1,800,000 ₽</span></p>
                        <button class="btn btn-primary submit-order" data-car="accord">Отправить заявку</button>
                        <form class="email-form" data-car="accord" method="POST" action="">
                            <input type="hidden" name="car_model" value="Honda Accord">
                            <input type="hidden" name="color" class="hidden-color" value="silver">
                            <input type="hidden" name="configuration" class="hidden-config" value="base">
                            <input type="hidden" name="price" class="hidden-price" value="1800000">
                            <div class="form-group">
                                <label for="email-accord">Email</label>
                                <input type="email" class="form-control" id="email-accord" name="email" required>
                            </div>
                            <button type="submit" name="submit_order" class="btn btn-success">Подтвердить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Обновление цены при изменении комплектации
            $('.config-select').on('change', function() {
                let car = $(this).data('car');
                let prices = $(this).data('prices');
                let selectedConfig = $(this).val();
                let price = prices[selectedConfig];
                $(`.price[data-car="${car}"]`).text(price.toLocaleString('ru-RU') + ' ₽');
                $(`.hidden-price[data-car="${car}"]`).val(price);
                $(`.hidden-config[data-car="${car}"]`).val(selectedConfig);
            });

            // Обновление цвета в скрытом поле
            $('.color-select').on('change', function() {
                let car = $(this).data('car');
                let selectedColor = $(this).val();
                $(`.hidden-color[data-car="${car}"]`).val(selectedColor);
            });

            // Показ формы для email после нажатия кнопки "Отправить заявку"
            $('.submit-order').on('click', function() {
                let car = $(this).data('car');
                $(`.email-form[data-car="${car}"]`).slideDown();
                $(this).hide();
            });
        });
    </script>
</body>
</html>