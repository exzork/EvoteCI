FROM php:7.4-apache
RUN apt-get update && \
    apt-get install -y
RUN apt-get install -y curl
RUN apt-get install -y libicu-dev libzip-dev
RUN apt-get update
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install mysqli pdo pdo_mysql zip exif 
RUN a2enmod rewrite
RUN service apache2 restart
COPY composer.json /var/www/composer.json
WORKDIR /var/www
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install
EXPOSE 80
EXPOSE 443