FROM tungnt89/php7.4-fpm:1.0

COPY . .
WORKDIR /var/www/html

RUN composer global require hirak/prestissimo && \
  composer install && \
  cp .env.prd .env  && \
  php artisan key:generate && \
  chmod -R a+w storage/ bootstrap/cache

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
