FROM php:apache

# Установка необходимых расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Копирование файлов приложения в директорию контейнера
COPY ./src /var/www/html/