FROM php:7.3-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev libicu-dev g++ unzip sudo git \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl pdo pdo_pgsql

RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www
COPY --chown=www:www . /var/www
USER www

EXPOSE 9000

CMD ["php-fpm"]