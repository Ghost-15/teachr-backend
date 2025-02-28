FROM php:8.3-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_pgsql intl

RUN curl -sS https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN apt update && apt install -yqq nodejs npm

RUN mkdir -p /var/run/apache2 && chown -R www-data:www-data /var/run/apache2

RUN a2enmod rewrite

WORKDIR /var/www/

COPY . /var/www/

RUN chown -R www-data:www-data var/cache var/log && \
    chmod -R 775 var/cache var/log

COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]