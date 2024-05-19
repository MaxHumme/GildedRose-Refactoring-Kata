FROM php:8.3-cli

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# we need git and some zip libs to make composer work
RUN apt-get update && apt-get install -y git libzip-dev zip && docker-php-ext-install zip

RUN mkdir -p /usr/src/php-kata
WORKDIR /usr/src/php-kata
