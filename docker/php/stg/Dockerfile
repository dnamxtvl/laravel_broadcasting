FROM tungnt89/php7.4-fpm:1.0

COPY . .
WORKDIR /var/www/html

RUN composer global require hirak/prestissimo && \
  composer install && \
  cp .env.stg .env  && \
  chmod -R a+w storage/ bootstrap/cache

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
