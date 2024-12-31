FROM php:8.2-apache

WORKDIR /var/www/html
RUN apt update && apt install -y wget unzip zip libzip-dev git curl libicu-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli && docker-php-ext-configure zip && docker-php-ext-install zip

RUN docker-php-ext-configure intl && docker-php-ext-install intl && docker-php-ext-enable intl

COPY . .

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN composer install --ignore-platform-req=ext-intl --ignore-platform-req=ext-zip --ignore-platform-req=ext-exif
RUN chmod +x start.sh
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080

CMD ["./start.sh"]
